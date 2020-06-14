<?php

$term = trim(strip_tags($_REQUEST['term']));

$pagination = select('posts', 'WHERE concat(title, body) like :term', ['term' => '%' . $term . '%'], true);

render('posts/index', compact('pagination'));
