import {validationParams, popupParams} from "./params.js";
import {formHandler} from "./form-handler.js";
import {showMessage} from "./messages-funcs.js";
import {serverRequest} from "./server-request.js";
import {showHideDropdown} from "./show-hide-dropdown.js";
import {renderPopup} from "./popup-funcs.js";

// SIGNUP PAGE
if (document.querySelector(".form_signup")) {
    const signupForm = document.querySelector(".form_signup");
    if (!formHandler(signupForm,"register")){
        showMessage(false, "Please fill in all fields correctly");
    }
}

// LOGIN PAGE
if (document.querySelector(".form_login")) {
    const loginForm = document.querySelector(".form_login");
    if (!formHandler(loginForm,"authorize", validationParams.loginFields)){
        showMessage(false, "Please fill in all fields correctly");
    }
}

// PASSWORD RECOVERY PAGE
if (document.querySelector(".form_recovery")) {
    const recoveryForm = document.querySelector(".form_recovery");
    if (!formHandler(recoveryForm,"access-recovery")) {
        showMessage(false, "Please fill in all fields correctly");
    }
}

// PASSWORD CHANGE PAGE
if (document.querySelector(".form_change-password")) {
    const changePasswordForm = document.querySelector(".form_change-password");
    if (!formHandler(changePasswordForm,"update-password")) {
        showMessage(false, "Please fill in all fields correctly");
    }
}

// PROFILE PAGE
if (document.querySelector(".profile")) {

    // Dropdown menu with avatar actions
    if (document.querySelector(".avatar__content")) {
        const avatar = document.querySelector(".avatar__content");
        showHideDropdown(avatar);

        // Popup for updating user avatar
        if (document.querySelector(".dropdown__button_update-avatar")){
            const updateAvatarButton = document.querySelector(".dropdown__button_update-avatar");
            updateAvatarButton.addEventListener("click", async () => {
                await renderPopup(popupParams.updateAvatar);
            });
        }

        // Button for deleting user avatar
        if (document.querySelector(".dropdown__button_delete-avatar")){
            const deleteAvatarButton = document.querySelector(".dropdown__button_delete-avatar");
            deleteAvatarButton.addEventListener("click", async () => {
                const options = {
                    method: "DELETE",
                };
                await serverRequest("/src/actions/delete-avatar.php", options);
            });
        }
    }

    // Profile editor form
    if (document.querySelector(".form_editor")){
        const profileEditorForm = document.querySelector(".form_editor");
        await formHandler(profileEditorForm,"edit-profile");
    }

    // Popup for changing password
    if (document.querySelector(".profile__button_change-password")){
        const changePasswordButton = document.querySelector(".profile__button_change-password");
        changePasswordButton.addEventListener("click", async () => {
            await renderPopup(popupParams.changePassword);
        });
    }

    // Logout button
    if (document.querySelector(".profile__button_logout")){
        const logoutButton = document.querySelector(".profile__button_logout");
        logoutButton.addEventListener("click", async () => {
            const options = {
                method: "POST",
            };
            await serverRequest("/src/actions/logout.php", options);
        });
    }

    // Popup for deleting a profile
    if (document.querySelector(".profile__button_delete")){
        const deleteProfileButton = document.querySelector(".profile__button_delete");
        deleteProfileButton.addEventListener("click", async () => {
            await renderPopup(popupParams.deleteProfile);
        });
    }
}


