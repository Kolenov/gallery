<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/collection.php';

class CommentCollection extends Collection
{
    private $totalItems;
    public $currentItem;

    public function __construct( $collectionID, $itemsPerCollection, $currentItem )
    {
        parent::__construct( $collectionID, $itemsPerCollection );
        $this->currentItem = $currentItem;
        $this->setTotalItems();
    }

    public static function create( $collectionID, $itemsPerCollection, $currentItem )
    {
        $collection = new self( $collectionID, $itemsPerCollection, $currentItem );
        //$maxNumPages = ceil( $collection->totalItems / $collection->itemsPerCollection );

        $dsn = "mysql:host=localhost; dbname=gallery; charset=utf-8";
        $pdo = new PDO( $dsn, "root", "" );

        $query = "SELECT * "
                . "FROM comments"
                . " WHERE id in"
                . "(SELECT cid FROM relations WHERE fid=" . $collection->currentItem . ")"
                ." LIMIT " . $collection->getStart() . "," . $collection->itemsPerCollection;

        $result = $pdo->query( $query );
        $result->setFetchMode( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Comment' );

        while ( $obj = $result->fetch() ) {
            $collection->attach( $obj );
        }
        return $collection;
    }

    public function getTotalItems()
    {
        return $this->totalItems;
    }

    private function setTotalItems()
    {
        $dsn = "mysql:host=localhost; dbname=gallery; charset=utf-8";
        $pdo = new PDO( $dsn, "root", "" );
        $result = $pdo->prepare( "SELECT count(cid) FROM relations WHERE fid=" . $this->currentItem );
        $result->execute();
        $this->totalItems = $result->fetchColumn();
    }

}
