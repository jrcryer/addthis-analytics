<?php
/**
 * Respresents an API parameter
 * 
 * @author James Cryer(j.r.cryer@gmail.com)
 */
class QueryParameter {

    /**
     * Parameter name
     * @var string
     */
    protected $name;

    /**
     * Parameter value
     * @var string
     */
    protected $value;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value) {
        $this->setParameter($name, $value);
    }

    /**
     * Set the parameter name and value
     * 
     * @param string $name
     * @param string $value
     */
    public function setParameter($name, $value) {
        $this->setName($name);
        $this->setValue($value);
    }

    /**
     * Return the parameters name and value as a name value pair
     * 
     * @return string
     */
    public function getParameter() {
        return sprintf('%s=%s', $this->getName(), $this->getValue());
    }

    /**
     * Reurns the parameter name
     *
     * @return string
     */
    protected function getName() {
        return $this->name;
    }

    /**
     * Set the parameter name
     * 
     * @param string $name
     */
    protected function setName($name) {
        $this->name = $name;
    }

    /**
     * Returns the parameter value
     * 
     * @return string
     */
    protected function getValue() {
        if( $this->getName() == 'url' ) {
            return urlencode($this->value);
        }
        return $this->value;
    }

    /**
     * Set the paramter value
     *
     * @param string $value
     */
    protected function setValue($value) {
        $this->value = $value;
    }

    /**
     * Returns the parameter as a name value pair
     * 
     * @return string
     */
    public function __toString() {
        return $this->getParameter();
    }
}