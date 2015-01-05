<?php

use wataridori\ChatworkSDK\Helper\Text;

class TextHelperTest extends PHPUnit_Framework_TestCase
{
    public function testSnakeToCamelCase()
    {
        $input = 'this_is_a_snake_case';
        $output = Text::snakeToCamel($input);
        $this->assertEquals($output, 'thisIsASnakeCase');
    }

    public function testCamelToSnake()
    {
        $input = 'thisIsACamelCase';
        $output = Text::camelToSnake($input);
        $this->assertEquals($output, 'this_is_a_camel_case');
    }
}