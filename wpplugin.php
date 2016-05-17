<?php

/*
Version: 0.0.1
Plugin Name: WordPress Plugin
Plugin URI: https://github.com/cixtor/wpplugin
Description: Scaffold for a WordPress plugin with unit-tests.
Author URI: https://cixtor.com/
Author: Yorman (cixtor)
*/

/**
 * Plugin dependencies.
 *
 * List of required functions for the execution of this plugin, we are assuming
 * that this site was built on top of the WordPress project, and that it is
 * being loaded through a pluggable system, these functions must be defined
 * before to continue.
 *
 * @var array
 */
$_dependencies = array(
    'wp',
    'wp_die',
    'add_action',
    'remove_action',
    'wp_remote_get',
    'wp_remote_post',
);

/**
 * Disguise existence of the plugin.
 *
 * Any dependency associated to one of more built-in WordPress functions must be
 * satisfied, otherwise the code will break. Assuming a normal installation if
 * any of the dependencies does not exists we can assume that the file was
 * accessed directly by a suspicious client, in which case we want not only to
 * stop the execution of the rest of the code but also to hide the existence of
 * the file sending a 404 Not Found HTTP status code.
 *
 * Note that people can still try to access static files like images, CSS, and
 * JavaScript files if they are included in the same directory and the path is
 * publicly available. Make sure to add a fallback to prevent this using the
 * access control module of your favorite web server.
 */
foreach ($_dependencies as $dependency) {
    if (!function_exists($dependency)) {
        header('HTTP/1.1 404 Not Found');
        exit(0);
    }
}
