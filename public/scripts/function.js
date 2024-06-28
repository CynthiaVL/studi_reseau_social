const togglePassword = () => {
    const inputTogglePassword = document.querySelector("#password");
    inputTogglePassword.type = inputTogglePassword.type === "text" ? "password" : "text";
    const eyeIcon = document.querySelector('#eye');
    const eyeSlashIcon = document.querySelector('#eyeSlash');

    if (eyeIcon && eyeSlashIcon) {
        if (inputTogglePassword.type === "text") {
            eyeIcon.classList.add('d-none');
            eyeSlashIcon.classList.remove('d-none');
        } else {
            eyeIcon.classList.remove('d-none');
            eyeSlashIcon.classList.add('d-none');
        }
    }
}