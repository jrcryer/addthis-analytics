<?php
/**
 * Responsible for storing API authentication
 *
 * @author James Cryer(j.r.cryer@gmail.com)
 */
class Authentication {

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * Constructor requires AddThis username and password
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password) {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    /**
     * Returns the username
     * 
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Sets the username
     * 
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Returns the password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Sets th password
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * Returns the username and password in the query string format for the
     * API call. For example:
     *
     * username=myname&password=mypass
     * 
     * @return string
     */
    public function __toString() {
        return sprintf(
            'username=%s&password=%s',
            $this->getUsername(), $this->getPassword()
        );
    }
}