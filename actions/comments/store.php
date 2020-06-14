<?php

fu();

validate($_POST, [
    'name' => 'required',
    'message' => 'required'
], [
    'name' => 'Name ist ein Pflichtfeld.',
    'message' => 'Nachricht ist ein Pflichtfeld.'
]);

$comment = [
    'name' => $_POST['name'],
    'message' => $_POST['message'],
    'post_id' => params()['post_id'],
];

action(fn() => insert('comments', $comment, true), 'wow thx 4 comment');

back();
