<?php

auth();

action(fn() => destroy('comments', params()['id']));

back();
