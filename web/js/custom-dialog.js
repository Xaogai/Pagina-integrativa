function showCustomDialog(messageHTML, type = "info", onAccept = null, onCancel = null) {
    const dialog = document.getElementById("custom-dialog");
    const messageContainer = document.getElementById("custom-dialog-message");
    const dialogBox = document.getElementById("custom-dialog-box");

    dialog.className = "";
    dialog.classList.add(`dialog-${type}`);

    messageContainer.innerHTML = messageHTML;

    dialog.style.display = "flex";

    document.getElementById("custom-dialog-accept").onclick = function () {
        dialog.style.display = "none";
        if (onAccept) onAccept();
    };

    document.getElementById("custom-dialog-cancel").onclick = function () {
        dialog.style.display = "none";
        if (onCancel) onCancel();
    };
}