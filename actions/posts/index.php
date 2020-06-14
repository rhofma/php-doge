<?php

title('index');

$where = authenticated() ? '' : 'WHERE published = true ';

$pagination = select('posts', $where . 'ORDER BY created_at DESC', [], true);

render('posts/index', compact('pagination'));
