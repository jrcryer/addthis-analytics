<?php
/**
 * Cache interface for storing responses from AddThis Analytics API.
 *
 * @author James Cryer(j.r.cryer@gmail.com)
 */
Interface Cache {

    public function isCached($key);
    public function getContent($key);
    public function putContent($key, $content);
}