<?php

auth();

action(fn () => destroy('posts', params()['id']));

back();
