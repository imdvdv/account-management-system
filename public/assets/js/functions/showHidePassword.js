export function showHidePassword() {

    if (document.querySelector('.form__input-icon_eye')){
        const eyeIcons = document.querySelectorAll('.form__input-icon_eye');

        eyeIcons.forEach((eyeIcon) => {
            
            eyeIcon.addEventListener('click', () => {
                const inputPassword = eyeIcon.parentElement.querySelector('.form__input'); 

                if (inputPassword.type === 'password') {
                    eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
                    return (inputPassword.type = 'text');
                }

                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
                inputPassword.type = 'password';
            });

        });

    }

}