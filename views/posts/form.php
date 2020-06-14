<label>
    title
    <input type="text" name="title" value="<?= $post['title'] ?? '' ?>">
</label>
<label>
    content
    <textarea name="body"><?= $post['body'] ?? '' ?></textarea>
</label>
<label>
    published
    <input type="checkbox" name="published" <?= isset($post['published']) &&  $post['published'] ? 'checked' : '' ?>/>
</label>
<button>save</button>