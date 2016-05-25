<?php

class PluginActionTest extends WP_UnitTestCase
{
    public function testPluginAction()
    {
        $expected = '<p id="wp-plugin">Lorem ipsum dolor...</p>';
        $this->expectOutputString($expected);
        wp_plugin_function();
    }
}
