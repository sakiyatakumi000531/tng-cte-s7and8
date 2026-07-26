<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * リクエストの実行が許可されているか（今回は誰でも登録できるので true）
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * バリデーション前にサニタイズする
     */
    protected function prepareForValidation() {
        // 1. 一括でサニタイズしたい項目リストを作成
        $targets = ['name', 'email', 'password', 'password_confirmation'];

        // 2. あとでまとめてmerge()する用の空の配列を作成
        $data = [];

        // 3-1. リストに入っている項目だけをループで処理
        foreach ($targets as $field) {
            // 3-2フィールドが存在する場合のみサニタイズしてセット
            if ($this->has($field)) {
                // 3-3. 全角英数字を半角に変換（mb_convert_kana）
                // 3-4. 前後の空白（全角含む）を削除（preg_replace）
                $data[$field] = $this->sanitize($this->input($field));
            }
        }

        /*
        // 4. 個別で「別の加工」をしたいものは別途追加
        if ($this->has('price')) {
            // 価格などは全角で入力されても数値として扱えるように半角化
            $data['price'] = mb_convert_kana($this->price, 'n');
        }
        */

        // 5. まとめてデータに反映
        $this->merge($data);
    }

    /**
     * 独自のサニタイズロジック
     */
    private function sanitize(?string $value): ?string {
        if (is_null($value)) return null;

        // 全角英数字を半角に変換 ('a' は英字, 's' は数字)
        $value = mb_convert_kana($value, 'as');

        // 前後の全角・半角スペースを取り除く
        return preg_replace('/(^\s+|\s+$)/u', '', $value);
    }

    /**
     * バリデーションルールを定義
     */
    public function rules(): array {
        return [
            // 必須 / 半角記号を除外(半角英数, 全角はOK) / 255文字まで
            'name' => [
                'required',
                'regex:/^[a-zA-Z0-9|[^\x01-\x7E]]+$/u',
                'max:255'
            ],

            // 必須 / 半角英数のみ(全角, 記号はNG) / メールアドレス形式 / 255文字以内 / 重複禁止
            'email' => [
                'required',
                'alpha_num',
                'email',
                'max:255',
                'unique:users' // usersテーブル内で重複していないこと
            ],

            // 必須 / 半角英数のみ(全角, 記号はNG) / 8文字以上 / 255文字以内 / 確認用フィールドとの一致要
            'password' => [
                'required',
                'alpha_num',
                'min:8',
                'max:255',
                'confirmed' // password_confirmationフィールドと一致すること
            ],

            // 'password' で 'confirmed' を指定しているので、password_confirmation 用の記述は不要
        ];
    }
}
