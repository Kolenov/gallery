<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/collection.php';

class ImageCollection extends Collection
{
    private $totalItems;

    public function __construct( $currentSetCount, $perCollectionCount )
    {
        parent::__construct( $currentSetCount, $perCollectionCount );
        $this->setTotalItems();
    }

    public static function create( $currentSetCount, $perCollectionCount )
    {
        $collection = new self( $currentSetCount, $perCollectionCount );
        //$maxNumPages = ceil( $collection->totalItems / $collection->itemsPerCollection );

        $dsn = "mysql:host=localhost; dbname=gallery; charset=utf-8";
        $pdo = new PDO( $dsn, "root", "" );
        $query = "SELECT id, filename, uri FROM picture LIMIT " . $collection->getStart() . "," . $collection->itemsPerCollection;
        $result = $pdo->query( $query );
        $result->setFetchMode( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Image' );

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
        $result = $pdo->prepare( "SELECT count(id) FROM picture" );
        $result->execute();
        $this->totalItems = $result->fetchColumn();
    }

}
