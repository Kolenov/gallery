<?php
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/entity.php';
class Image extends Entity
{
    public $id;
    public $filename;
    public $uri;

    public function __construct ($filename = "", $uri = DEFAULT_URI)
    {
        $this->filename = $filename;
        $this->uri = $uri;
    }

    public function __toString ()
    {
        return "<img src='" . $this->uri . $this->filename . "' alt='" . $this->filename . "'>";
    }
}