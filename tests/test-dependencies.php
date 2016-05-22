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
}
