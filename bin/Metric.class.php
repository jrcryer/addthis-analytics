<?php
/**
 * Respresents an API metric
 *
 * @author James Cryer(j.r.cryer@gmail.com)
 */
class Metric {

    /**
     * @var string
     */
    protected $name;

    /**
     * Constructor
     * 
     * @param string $name
     */
    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * Returns the parameter name
     * 
     * @return string
     */
    public function __toString() {
        return $this->name;
    }
}