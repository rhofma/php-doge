<?php

auth();

validate($_POST, [
    'title' => 'required',
    'body' => 'required'
]);

$post = [
    'title' => $_POST['title'],
    'body' => $_POST['body'],
    'slug' => slug($_POST['title']),
    'published' => (int)isset($_POST['published'])
];

action(fn () => update('posts', params()['id'], $post, true));

back();
