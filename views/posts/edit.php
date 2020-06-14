<?= template('header') ?>
<form action="/posts/<?= $post['id'] ?>" method="post">
    <input type="hidden" name="_method" value="PATCH">
    <?= template('posts/form', compact('post')) ?>
</form>
<?= template('footer') ?>