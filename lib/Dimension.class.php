<?php
/**
 * Respresents an API metric
 *
 * @author James Cryer(j.r.cryer@gmail.com)
 */
class Dimension {

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
     * Returns the dimension name
     * 
     * @return string
     */
    public function __toString() {
        return $this->name;
    }
}