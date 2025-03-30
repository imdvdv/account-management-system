<ul class="dropdown">

    <?php foreach ($items as $item): ?>

        <li class="dropdown__option">

            <?php if (isset($item['href'])): ?>

                <a href="<?= $item['href'] ?? '' ?>" class="dropdown__button"
                    style="color:<?= $item['color'] ?? '' ?>"><?= $item['text'] ?? '' ?></a>

            <?php elseif (isset($item['action'])): ?>

                <form action="<?= $item['action'] ?? '' ?>" class="dropdown__form" method="post">
                    <input type="hidden" name="_method" value="<?= $item['method'] ?? 'post' ?>">
                    <button role="submit" class="dropdown__button" name="dropdown__button"
                        style="color:<?= $item['color'] ?? '' ?>"><?= $item['text'] ?? '' ?></button>
                </form>

            <?php elseif (isset($item['text'])): ?>

                <span><?= $item['text'] ?></span>

            <?php endif; ?>

        </li>

    <?php endforeach; ?>

</ul>