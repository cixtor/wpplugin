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

    if ($return_var === 0 && file_exists(WP_TEST_DIR)) {
        printf("@ Creating configuration file\n");
        $config = file_get_contents('wordpress/wp-tests-config-sample.php');

        printf("  Setting database name (will be truncated every time)\n");
        $config = str_replace('youremptytestdbnamehere', 'wordpress', $config);

        printf("  Setting database username\n");
        $config = str_replace('yourusernamehere', 'root', $config);

        printf("  Setting database password\n");
        $config = str_replace('yourpasswordhere', 'password', $config);

        printf("  Setting website hostname\n");
        $config = str_replace('example.org', 'wordpress.test', $config);

        file_put_contents('wordpress/wp-tests-config.php', $config);
        printf("@ Finished\n");
        exit(0);
    }

    print_r($output);
    exit(1);
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
