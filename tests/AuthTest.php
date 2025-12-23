<?php
require __DIR__ . '/../core/Autoloader.php';

use Core\Env;
use Core\Auth;

Env::load(__DIR__ . '/../.env');

function assertTrue($cond, $msg) {
    if (!$cond) {
        echo "FAIL: $msg\n";
        exit(1);
    }
}

assertTrue(Auth::can('view_admin_dashboard') === false, 'can requires login');
echo "OK\n";

