import {serverRequest} from "./server-request.js";
import {formHandler} from "./form-handler.js";
import {showMessage} from "./messages-funcs.js";
import {closePopup} from "./popup-funcs.js";

export const validationParams = {
    fields: {
        name: {
            pattern: /^([A-Za-z\s]{2,30}|[А-ЯЁа-яё\s]{2,30})$/,
            error: "name must be at least 2 characters and contain only letters",
        },
        email: {
            pattern: /^[^ ]+@[^ ]+\.[a-z]{2,3}$/,
            error: "enter a valid email address",
        },
        password: {
            pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/,
            error: "password must be at least 6 character with number, small and capital letter",
        },
    },
    // Parameters only for login form
    loginFields: {
        email: {
            pattern: /^[^ ]+@[^ ]+\.[a-z]{2,3}$/,
            error: "enter a valid email address",
        },
        password: {
            pattern: /^.{6,}$/,
            error: "password must contain at least 6 characters",
        },
    },
    // Parameters for attached files
    files: {
        avatar: {
            requirements: {
                types: ["image/jpeg", "image/jpg", "image/png", "image/gif"],
                size: 3 // MB
            },
            errors: {
                types: "invalid file type",
                size: "the file should not exceed 3 MB",
            },
        },
    },
}

export const popupParams = {
    updateAvatar: {
        contentPath: "/components/popup/update-avatar-content.html",
        popupAction: async () => {
            if (document.querySelector(".form_avatar ")){
                const avatarForm = document.querySelector(".form_avatar ");
                await formHandler(avatarForm, "change-avatar");
            } else {
                closePopup();
                showMessage(false, "Something went wrong. Please try again later.");
            }
        },
    },
    changePassword: {
        contentPath: "/components/popup/change-password-content.html",
        popupAction: async () => {
            if (document.querySelector(".form_change-password")){
                const changePasswordForm = document.querySelector(".form_change-password");
                const options = {
                    method: "POST"
                };
                await serverRequest("/src/actions/set-reset-session.php", options);
                await formHandler(changePasswordForm, "update-password");
            } else {
                closePopup();
                showMessage(false, "Something went wrong. Please try again later.");
            }
        },
    },
    deleteProfile: {
        contentPath: "/components/popup/delete-profile-content.html",
        popupAction: async () => {
            if (document.querySelector(".confirm-popup")) {
                let confirmButton = document.querySelector(".confirm-popup");
                confirmButton.addEventListener("click", async (e) => {
                    const options = {
                        method: "DELETE",
                    };
                    await serverRequest("/src/actions/delete-profile.php", options);
                });
            } else {
                closePopup();
                showMessage(false, "Something went wrong. Please try again later.");
            }
        },
    },
}


