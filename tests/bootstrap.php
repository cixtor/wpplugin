<?php

define('WP_TEST_DIR', __DIR__ . '/../wordpress');

if (!file_exists(WP_TEST_DIR)) {
    $output = array();
    $return_var = 255;
    $command = 'svn co https://develop.svn.wordpress.org/trunk/ wordpress';

    printf("@ WordPress unit-test suite\n");
    printf("@ Cloning development repository... ");
    @exec($command, $output, $return_var);
    printf("DONE\n");
    exit(0);
}

require_once(WP_TEST_DIR . '/tests/phpunit/includes/functions.php');

if (function_exists('tests_add_filter')) {
    function _manual_plugin_activation()
    {
        require(WP_TEST_DIR . '/../wpplugin.php');
    }

    tests_add_filter('muplugins_loaded', '_manual_plugin_activation');
}

require_once(WP_TEST_DIR . '/tests/phpunit/includes/bootstrap.php');
