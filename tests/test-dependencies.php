<?php

class DependenciesTest extends WP_UnitTestCase
{
    public function testDependencyWp()
    {
        $this->assertTrue(
            function_exists('wp'),
            'WordPress built-in function does not exists'
        );
    }

    public function testDependencyWpDie()
    {
        $this->assertTrue(
            function_exists('wp_die'),
            'WordPress built-in function does not exists'
        );
    }

    public function testDependencyAddAction()
    {
        $this->assertTrue(
            function_exists('add_action'),
            'WordPress built-in function does not exists'
        );
    }

    public function testDependencyRemoveAction()
    {
        $this->assertTrue(
            function_exists('remove_action'),
            'WordPress built-in function does not exists'
        );
    }

    public function testDependencyWpRemoteGet()
    {
        $this->assertTrue(
            function_exists('wp_remote_get'),
            'WordPress built-in function does not exists'
        );
    }

    public function testDependencyWpRemotePost()
    {
        $this->assertTrue(
            function_exists('wp_remote_post'),
            'WordPress built-in function does not exists'
        );
    }
}
