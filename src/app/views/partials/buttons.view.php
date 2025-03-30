<div class="buttons " <?= $class ?? '' ?>>

    <?php foreach ($items as $item):

        if (isset($item['tag']) && $item['tag'] == 'a'): ?>

            <a href="<?= $item['href'] ?? BASE_URL ?>" class="button <?= $item['class'] ?? '' ?>"
                style="background: <?= $item['bg_color'] ?? '' ?>"><?= $item['text'] ?? 'Cancel' ?></a>

        <?php else:

            if (isset($item['action'])): ?>

                <form action="<?= $item['action'] ?>" method="post" class="button__action">
                    <input type="hidden" name="_method" value="<?= $item['method'] ?? 'post' ?>">

                <?php endif; ?>

                <button type="<?= $item['type'] ?? 'submit' ?>" class="button <?= $item['class'] ?? '' ?>"
                    style="background: <?= $item['bg_color'] ?? '' ?>"><?= $item['text'] ?? 'Submit' ?></button>

                <?= isset($item['action']) ? '</form>' : ''; ?>

            <?php endif;

    endforeach; ?>

</div>