let pathname = window.location.pathname;
let btnLoading = document.querySelector(".btnLoading");
let form = document.getElementsByTagName("form")[0];

switch (pathname) {
    case "/login":
        let icon = document.querySelector(".icon");
        let btnLogin = document.querySelector(".login");
        let containerIcon = document.querySelector(".containerIcon");
        let password = document.querySelector(".password");

        form.addEventListener("submit", function () {
            btnLogin.classList.toggle("d-none");
            btnLoading.classList.toggle("d-none");
        });

        containerIcon.addEventListener("click", function () {
            icon.classList.toggle("bi-eye-slash-fill");
            icon.classList.toggle("bi-eye-fill");

            if (password.type === "password") {
                password.type = "text";
            } else if (password.type === "text") {
                password.type = "password";
            }
        });
        break;

    default:
        const toggleButtons = document.querySelectorAll(".containerIcon");
        let btnRegistration = document.querySelector(".registration");
        let btnForgotPassword = document.querySelector(".forgot-password");
        let btnResetPassword = document.querySelector(".reset-password");
        let btnResendLinkVerification = document.querySelector(
            ".resend-link-verification"
        );

        toggleButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const input = this.parentElement.querySelector("input");
                const icon = this.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("bi-eye-slash-fill");
                    icon.classList.add("bi-eye-fill");
                } else {
                    input.type = "password";
                    icon.classList.remove("bi-eye-fill");
                    icon.classList.add("bi-eye-slash-fill");
                }
            });
        });

        form.addEventListener("submit", function () {
            if (btnRegistration) {
                btnRegistration.classList.toggle("d-none");
                btnLoading.classList.toggle("d-none");
            } else if (btnForgotPassword) {
                btnForgotPassword.classList.toggle("d-none");
                btnLoading.classList.toggle("d-none");
            } else if (btnResetPassword) {
                btnResetPassword.classList.toggle("d-none");
                btnLoading.classList.toggle("d-none");
            } else if (btnResendLinkVerification) {
                btnResendLinkVerification.classList.toggle("d-none");
                btnLoading.classList.toggle("d-none");
            }
        });
        break;
}
