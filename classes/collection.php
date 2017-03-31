<?php
class Collection extends SplObjectStorage
{
    public $itemsPerCollection;
    public $collectionID;
    protected $_items;
    protected $_start;

    protected function __construct ($currentSetCount=1, $perCollectionCount=3)
    {
        $this->itemsPerCollection = $perCollectionCount;
        
        if ( is_null( $currentSetCount ) || $currentSetCount == 0 || $currentSetCount < 0 )
        {
        	 $this->collectionID = 1;
        } else $this->collectionID = $currentSetCount;

        $this->_items = new SplObjectStorage();
        $this->setStart();
    }
    
    protected function setStart ()
    {
        $this->_start = $this->collectionID * $this->itemsPerCollection - $this->itemsPerCollection;
    }

    protected function getStart ()
    {
        return $this->_start;
    }

    protected function getAll ()
    {
        return $this->_items;
    }
} 