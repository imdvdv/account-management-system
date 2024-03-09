<?php

function showAvatar (string|null $path, int $size): void {
    if($path){ ?>
        <img class="avatar__image" src="<?=$path?>" width="<?=$size?>px" height="<?=$size?>px" alt="avatar">
    <?php } else{ ?>
        <i class="avatar__image fa-solid fa-circle-user" style="font-size: <?=$size?>px"></i>
    <?php }
}