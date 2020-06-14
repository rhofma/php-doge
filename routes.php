<?php

get('/login', 'login');

get('/', 'posts/index');
get('/posts/(\d+)/edit', 'posts/edit', ['id']);
get('/posts/create', 'posts/create');

post('/posts', 'posts/store');
patch('/posts/(\d+)', 'posts/update', ['id']);
delete('/posts/(\d+)', 'posts/destroy', ['id']);

post('/posts/(\d+)/comments', 'comments/store', ['post_id']);
delete('/comments/(\d+)', 'comments/destroy', ['id']);

get('/search', 'posts/search');

get('/posts/(\w+)', 'posts/show', ['slug']);
