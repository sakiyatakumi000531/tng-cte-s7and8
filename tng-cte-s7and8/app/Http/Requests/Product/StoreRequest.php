<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // 権限チェックが必要ならここにロジックを書く
        return true;
    }


    /**
     * バリデーション前にデータを整形する
     */
    protected function prepareForValidation()
    {
        $this->merge([
            // 1. 全角英数字を半角に変換（mb_convert_kana）
            // 2. 前後の空白（全角含む）を削除（preg_replace）
            'product_code' => $this->sanitize($this->product_code),

            // 価格などは全角で入力されても数値として扱えるように半角化
            'price' => mb_convert_kana($this->price, 'n'),
        ]);
    }


    /**
     * 独自のサニタイズロジック
     */
    private function sanitize(?string $value): ?string
    {
        if (is_null($value)) return null;

        // 全角英数字を半角に変換 ('a' は英字, 'n' は数字)
        $value = mb_convert_kana($value, 'as');

        // 前後の全角・半角スペースを取り除く
        return preg_replace('/(^\s+|\s+$)/u', '', $value);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 必須 / 文字列 / 255文字以内
            'product_name' => ['required', 'string', 'max:255'],
            // 「半角記号」を除外する正規表現
            //（半角英数字、または全角文字のみを許可）
            // 'regex:/^[a-zA-Z0-9|[^\x01-\x7E]]+$/u',

            // 必須 / 整数 / companiesテーブルのidに存在すること
            'company_id'   => ['required', 'integer', 'exists:companies,id'],

            // 必須 / 整数 / 0以上 / int(11)の最大値以内
            'price'        => ['required', 'integer', 'min:0', 'max:2147483647'],

            // 必須 / 整数 / 0以上 / int(11)の最大値以内
            'stock'        => ['required', 'integer', 'min:0', 'max:2147483647'],

            // 任意(Nullable) / 文字列 / text型なので大きめの制限（例: 2000文字）
            'comment'      => ['nullable', 'string', 'max:2000'],

            // 任意(Nullable) / 文字列(パス) / 255文字以内
            'img_path'     => ['nullable', 'string', 'max:255'],
            // ※ファイルアップロードとして扱う場合は 'image' ルールなどを使用
            // 「Step7スプレッドシート」の「DB定義」シートで varchar(255) が指定されているので文字列として設定しているが、フォームから画像をアップロードする場合は、以下のように記述するのが一般的
            // // 画像ファイルそのものをバリデーションする場合の例
            // 'img_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MBまで
        ];
    }


    /**
     * 項目名（名詞）の定義
     * これにより、標準メッセージの「:attribute」部分が日本語に置換される
     */
    public function attributes(): array
    {
        return [
            'company_id'   => 'メーカー',
            'product_name' => '商品名',
            'price'        => '価格',
            'stock'        => '在庫数',
            'comment'      => 'コメント',
            'img_path'     => '商品画像パス',
        ];
    }

    /**
     * 特定のルールに対するカスタムメッセージ
     * attributes() だけでは表現しきれない「言い回し」を調整
     */
    public function messages(): array
    {
        return [
            // 存在しないIDが送られた場合
            'company_id.exists' => '選択された:attributeは、マスターに登録されていません。',

            // 価格の最小値エラー
            'price.min' => ':attributeにマイナスの値は入力できません。',

            // 在庫数の型エラー（数値以外）
            'stock.integer' => ':attributeは半角数字で入力してください。',

            // 画像パスの長さエラー
            'img_path.max' => '画像のファイル名が長すぎます（255文字以内）。',
        ];
    }
}
