import { CONFIRM_CREATE_MESSAGE } from "./message";

document.addEventListener('DOMContentLoaded', event => {
    document.getElementById('create-form').addEventListener('submit', event => {
        // 確認ダイアログを表示
        if (!confirm(CONFIRM_CREATE_MESSAGE)) {
            // キャンセルが押されたらフォーム送信を中止
            event.preventDefault();
        }
        // OKならstore()へフォームを送信
    });
});