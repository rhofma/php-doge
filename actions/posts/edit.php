<?php

auth();

$post = find('posts', params()['id']);

title('edit ' . $post['title'] . ' post');

render('posts/edit', compact('post'));
