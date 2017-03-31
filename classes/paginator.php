<?php
class Paginator implements SeekableIterator
{
    private $_itemsPerPageCount;
    private $_totalItemsCount;
    private $_totalPagesCount;
    private $_currentPageNumber;
    private $_elements = array();
    private $_position;

    private function __construct ($itemsPerPage, $totalItems, $currentPage)
    {
        $this->_itemsPerPageCount = $itemsPerPage;
        $this->_totalItemsCount = $totalItems;
        $this->setTotalPagesCount();
        $this->_currentPageNumber = $currentPage;
        $this->populatePaginator();
    }

    public static function create (Collection $obj)
    {
        $itemsPerPage = $obj->itemsPerCollection;
        $totalItems = $obj->getTotalItems();
        $currentPage = $obj->collectionID;
        $paginator = new Paginator( $itemsPerPage, $totalItems, $currentPage );
        return $paginator;
    }

    private function populatePaginator ()
    {
        $uri = strtok( $_SERVER[ 'REQUEST_URI' ], "?" ) . "?";
        unset( $_GET[ 'page' ] );
        if ( $_GET ){
            $uri .= http_build_query( $_GET ) . "&";
        }
            for( $i = 1; $i <= $this->_totalPagesCount; $i++ ){
                $this->_elements[] = $uri . "page=" . $i;
            }
    }

    public function seek ($position)
    {
        if ( !isset( $this->_elements[ $position ] ) ){
            throw new OutOfBoundsException( "invalid seek position ($position)" );
        }
        
        $this->_position = $position;
    }

    public function rewind ()
    {
        $this->_position = 0;
    }

    public function last ()
    {
        $this->_position = count( $this->_elements ) - 1;
    }

    public function current ()
    {
        return $this->_elements[ $this->_position ];
    }

    public function key ()
    {
        return $this->_position;
    }

    public function next ()
    {
        return ++$this->_position;
    }

    public function prev ()
    {
        return --$this->_position;
    }

    public function valid ()
    {
        return isset( $this->_elements[ $this->_position ] );
    }

    public function displayPaginator ()
    {
        if ( $this->_totalPagesCount > 1 ){
            $current_key = ($this->_currentPageNumber) - 1;
            
            if ( $current_key != 0 ){
                // выводим ссылку первая
                $this->rewind();
                echo "<a href='" . $this->current() . "'>Первая</a>";
                
                // выводим ссылку назад
                $this->seek( $current_key );
                $this->prev();
                echo "<span class='arrow'><a href='" . $this->current() . "'> ← </a></span>";
            }
            
            foreach( $this as $key => $val ){
                $num = $key;
                $str = "<a href='" . $val . "'>" . ++$num . "</a>";
                if ( $key == $current_key )
                    echo "<span class='current'>" . $str . "</span>";
                else
                    echo $str;
            }
            
            if ( $current_key != count( $this->_elements ) - 1 ){
                
                // выводим ссылку вперед
                $this->seek( $current_key );
                $this->next();
                echo "<span class='arrow'><a href='" . $this->current() . "'> → </a></span>";
                
                // выводим ссылку последняя
                $this->last();
                echo "<a href='" . $this->current() . "'>Последняя</a>";
            }
        } else echo "";
    }

    public function displayJumpMenu ()
    {}

    /**
     *
     * @return the $_totalPageCount
     */
    public function getTotalPagesCount ()
    {
        return $this->_totalPagesCount;
    }

    /**
     *
     * @param field_type $_totalPageCount            
     */
    public function setTotalPagesCount ()
    {
        $num_pages = ceil( $this->_totalItemsCount / $this->_itemsPerPageCount );
        $this->_totalPagesCount = $num_pages;
    }
}
