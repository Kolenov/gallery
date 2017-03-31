<?php
abstract class Entity
{
    public $id;
    public function __construct($id = NULL)
    {
        $this->id=$id;
    }
   abstract public function __toString ();
}