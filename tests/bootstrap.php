<?php

define('WP_TEST_DIR', __DIR__ . '/../wordpress');

require_once(WP_TEST_DIR . '/tests/phpunit/includes/functions.php');

if (function_exists('tests_add_filter')) {
    function _manual_plugin_activation()
    {
        require(WP_TEST_DIR . '/../wpplugin.php');
    }

    tests_add_filter('muplugins_loaded', '_manual_plugin_activation');
}

require_once(WP_TEST_DIR . '/tests/phpunit/includes/bootstrap.php');
