<?php

define('DB_NAME', 'wokandy');
define('DB_USER', 'wokandy');
define('DB_PASSWORD', 'CVXUJGaJwzeVAyC9');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('PASS_COST', 11);
define('PASS_SALT', 'BRMH??Nk}!GY#3:5^s?Q@=p\h-cvqF,-.MC^3DANG2.!k(_;k*/V[x-uR/;{XRU+w');

$options_pass = [
		'cost' => PASS_COST,
		'salt' => PASS_SALT
];