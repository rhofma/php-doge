<?= template('header') ?>

<?php if (authenticated()): ?>
    <a href="/posts/create">NEW POST</a>
<?php endif; ?>

<?php foreach ($pagination['items'] as $post): ?>
    <div class="post-item">
        <h2><?= $post['title'] ?></h2>
        <p><?= $post['body'] ?></p>
        <a href="/posts/<?= $post['slug'] ?>">OPEN</a>
        <?php if (authenticated()): ?>
            <a href="/posts/<?= $post['id'] ?>/edit">EDIT</a>
            <form action="/posts/<?= $post['id'] ?>" method="post">
                <input type="hidden" name="_method" value="DELETE">
                <button class="delete">DELETE</button>
            </form>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?= template('footer') ?>
