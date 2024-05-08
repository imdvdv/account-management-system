<?php

include_once __DIR__ . "/../src/config/includes.php";
include_once __DIR__ . "/../src/helpers/get-user.php";
include_once __DIR__ . "/../src/helpers/show-avatar.php";
session_start();

if (isAuthorized()){
    $userID = $_SESSION["user"]["id"];
    $userData = getUser($userID);

    if (!$userData) {
        if (isset($_COOKIE["token"])){
            setcookie("token", "", time() - ONE_HOUR, "/"); 
        }
        unset($_SESSION["user"]);
        header("Location:/pages/login.php");
        exit;
    }
    $userName = $userData["name"];
    $userEmail = $userData["email"];
    $userAvatar = $userData["avatar_path"];
?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . "/../components/head.html";?>
<body>
    <div class="container container_profile">
        <h3 class="title">Profile editor</h3>
        <div class="message">
            <p class="message-text"></p>
        </div>
        <div class="profile profile_editor">
            <div class="profile__layout">
                <div class="avatar">
                    <div class="avatar__content">
                        <?php showAvatar($userAvatar, 100);?>
                        <ul class="dropdown">
                            <li class="dropdown__option dropdown__option_update">
                                <button role="button" class="dropdown__button dropdown__button_update-avatar">
                                    <i class="fa-solid fa-pen-to-square"></i> Update photo
                                </button>
                                <?php if($userAvatar){ ?>
                                    <button role="button" class="dropdown__button dropdown__button_delete-avatar">
                                        <i class="fa-solid fa-trash"></i> Delete photo
                                    </button>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="profile__info">
                    <form  name="form_editor" class="form form_editor" id="form_editor">
                        <div class="form__field form__field_name">
                            <div class="form__input form__input_name">
                                <label for="name" class="form__label">Name</label>
                                <input type="text" class="form__input-value" id="name" name="name" value="<?=$userName?>" autocomplete="off">
                            </div>
                            <div class="form__error form__error_name">
                                <i class="form__error-icon form__error-icon_name fa-solid fa-circle-exclamation"></i>
                                <span class="form__error-text form__error-text_name"></span>
                            </div>
                        </div>
                        <div class="form__field form__field_email">
                            <div class="form__input form__input_email">
                                <label for="email" class="form__label">Email</label>
                                <input type="text" class="form__input-value" id="email" name="email" value="<?=$userEmail?>" autocomplete="off">
                            </div>
                            <div class="form__error form__error_email">
                                <i class="form__error-icon form__error-icon_email fa-solid fa-circle-exclamation"></i>
                                <span class="form__error-text form__error-text_email"></span>
                            </div>
                        </div>
                        <button type="submit" class="form__button form__button_editor" name="button_editor">Save</button>
                    </form>
                    <button role="button" class="profile__button profile__button_change-password">
                        <i class="fa-solid fa-pen-to-square"></i> Change password
                    </button>
                    <button role="button" class="profile__button profile__button_logout">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </div>
                <button role="button" class="profile__button profile__button_delete" name="profile__button_delete">
                    <i class="fa-solid fa-trash"></i> Delete profile
                </button>
            </div>
        </div>
    </div>
    <?php include_once __DIR__ . "/../components/popup/popup-layout.html";?>
</body>
<?php include_once __DIR__ . "/../components/scripts.html";?>
</html>
<?php
} else {
	header("Location:/pages/login.php");
} ?>