<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="<?= h(CSS_URL); ?>">
        <title>error</title>
    </head>
    <body>
        <div class="content">
            <h1>500 ERROR</h1>
            <p><?= isset($error) ? h($error) : ''; ?></p>
            <p><a href="<?= h(SITE_URL); ?>">戻る</a></p>
        </div>
    </body>
</html>
