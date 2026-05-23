import { CONFIRM_EDIT_MESSAGE } from "./message";

document.addEventListener('DOMContentLoaded', event => {
    document.getElementById('edit-form').addEventListener('submit', event => {
        // 確認ダイアログを表示
        if (!confirm(CONFIRM_EDIT_MESSAGE)) {
            // キャンセルが押されたらフォーム送信を中止
            event.preventDefault();
        }
        // OKならupdate()へフォームを送信
    });
});