<?php

require('../dibi/src/loader.php');
session_start();

dibi::connect([
    'driver'   => 'mysqli',
    'host'     => 'localhost',
	'database'     => 'eva',
	//zmente prihlasovaci udaje na udaje vasi databaze
    'username' => 'eva',
    'password' => 'eshop',
]);
