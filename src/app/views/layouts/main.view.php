<!DOCTYPE html>
<html>
    <head>
        <base href="<?= BASE_URL . '/'; ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= APP_TITLE ?? 'App'; ?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="<?= BASE_URL . '/assets/css/' . ($style ?? 'style.css'); ?>">
    </head>
    <body>
        <?= $content ?? ''; ?>
        <script type="module" src="<?= BASE_URL . '/assets/js/' . ($script ?? 'main.js'); ?>"></script>
    </body>
</html>