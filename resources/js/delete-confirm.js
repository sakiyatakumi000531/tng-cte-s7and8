import { CONFIRM_DELETE_MESSAGE } from "./message";

document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', (event) => {
        if (!confirm(CONFIRM_DELETE_MESSAGE)) {
            event.preventDefault();
        }
    });
});