<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="<?= h(CSS_URL); ?>">
        <title>Example Tool</title>
    </head>
    <body>
        <div class="content">
            <h1>Example Tool</h1>
            <?php foreach ($errors as $key => $error) {?>
                <?php foreach ($error as $value) {?>
                    <p><?= h($value) ?></p>
                <?php } ?>
            <?php } ?>
            <p><?= h($this->string) ?></p>
            <form action="<?= h(SITE_URL . '/example'); ?>" method="post">
                <?= $csrf; ?>
                <p><input type="text" name="post-string" value="<?= isset($old['post-string']) ? $old['post-string'] : ''; ?>"></p>
                <p><input type="submit" value="post"></p>
            </form>
            <form action="<?= h(SITE_URL . '/reset'); ?>" method="post">
                <?= $csrf; ?>
                <p><input type="submit" value="reset"></p>
            </form>
            <p><a href="<?= h(SITE_URL); ?>">戻る</a></p>
        </div>
    </body>
</html>
