<?php

require_once config()['path']['vendor'] . '/Parsedown.php';

$post = find_by_slug('posts', params()['slug']);

$post['body'] = (new Parsedown())->text($post['body']);

title($post['title']);

$pagination = select('comments', 'WHERE post_id = :post_id', ['post_id' => $post['id']], true);

render('posts/show', compact('post', 'pagination'));
