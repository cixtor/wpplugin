<?php

define('WP_TEST_DIR', __DIR__ . '/../wordpress');
define('WP_INSTALLER', WP_TEST_DIR . '/tests/phpunit/includes/install.php');

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

        printf("@ Improve installation script\n");
        $installer = @file(WP_INSTALLER, FILE_IGNORE_NEW_LINES);
        $new_installer = array();

        foreach ($installer as $line) {
            if (strpos($line, 'Installing...') !== false) {
                $new_installer[] = $line;
                $new_installer[] = 'if (isset($_SERVER["WP_TRUNCATE_DB"])) {';
                $new_installer[] = '$start_time = microtime(true);';
                continue;
            }

            if (strpos($line, 'wp_install(') !== false) {
                $new_installer[] = $line;
                $new_installer[] = '$total = (microtime(true) - $start_time);';
                $new_installer[] = 'printf("Execution time %s secs\n", $total);';
                $new_installer[] = '} /* Skip database truncate */';
                continue;
            }

            $new_installer[] = $line;
        }

        $new_installer_text = implode("\n", $new_installer) . "\n";
        file_put_contents(WP_INSTALLER, $new_installer_text);
        printf("  By default the database is truncated every time PHPUnit \n"
            .  "  is executed. The installer script has been modified to \n"
            .  "  speed up the execution time for simple test cases, you \n"
            .  "  set the WP_TRUNCATE_DB=true environment variable to run \n"
            .  "  the original behavior: WP_TRUNCATE_DB=true phpunit\n");

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
