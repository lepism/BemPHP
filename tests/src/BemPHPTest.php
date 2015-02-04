<?php

namespace BemPHP\Tests;

use BemPHP\BemPHP;

class BemPHPTest extends \PHPUnit_Framework_TestCase
{
    public function testSample ()
    {
        $bem = new BemPHP();
        $this->assertInstanceOf('BemPHP\\BemPHP', $bem);
    }
} 