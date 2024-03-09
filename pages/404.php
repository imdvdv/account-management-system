<?php

include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/configs/env.php";

?>
<!DOCTYPE html>
<html>
<?php require_once "{$_SERVER["DOCUMENT_ROOT"]}/components/head.html";?>
<body>
    <div class="container">
        <h3 class="title" style="text-decoration-color: #d93025">404</h3>
        <div class="message failure show">
            <p class="message-text">
                <?php
                if(isset($_SESSION["message"]) && !empty($_SESSION["message"])) {
                    echo $_SESSION["message"];
                } else{
                    echo "NOT FOUND";
                }
                unset($_SESSION["message"]);
                ?>
            </p>
        </div>
        <div class="redirect redirect_home">
            <a href="/pages/profile.php" class="redirect__link">Home</a>
        </div>
    </div>
<?php include_once "{$_SERVER["DOCUMENT_ROOT"]}/components/scripts.html";?>
</body>
</html>