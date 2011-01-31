<?php

class MetricTest extends PHPUnit_Framework_TestCase {

    protected $oMet;

    public function setUp() {
        $this->oMet = new Metric('shares');
    }

    public function tearDown() {
        $this->oMet = null;
    }

    public function testConstruction() {
        $this->assertTrue(is_a($this->oMet, 'Metric'));
    }

    public function testToStringReturnsMetricName() {
        $this->assertEquals('shares', $this->oMet->__toString());
    }
}