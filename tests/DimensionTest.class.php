<?php

require '../bin/Dimension.class.php';

class DimensionTest extends PHPUnit_Framework_TestCase {

    protected $oDim;

    public function setUp() {
        $this->oDim = new Dimension('country');
    }

    public function tearDown() {
        $this->oDim = null;
    }

    public function testConstruction() {
        $this->assertTrue(is_a($this->oDim, 'Dimension'));
    }

    public function testToStringReturnsDimensionName() {
        $this->assertEquals('country', $this->oDim->__toString());
    }
}