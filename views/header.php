<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= title() ?></title>
    <link rel="stylesheet" href="<?= asset('/css/test.css') ?>">
</head>
<body>
    <header>
        <h1>DEMO</h1>
        <?php if (!authenticated()): ?>
            <a href="/login">LOGIN</a>
        <?php endif; ?>
    </header>
    <?php if (has_message()): ?>
        <section class="message">
            <p><?= message() ?></p>
        </section>
    <?php endif; ?>

    <?php if (has_errors()): ?>
        <section class="errors">
            <ul>
            <?php foreach (errors() as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <section class="content">
