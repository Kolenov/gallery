<?php
session_start();
$_SESSION['back'] = $_SERVER['REQUEST_URI'];
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/image.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/imagecollection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/paginator.php';

if ( isset( $_GET['page'] ) ) {
    $currentPage = $_GET['page'];
}

$imageSet = ImageCollection::create( $currentPage, 9 );
$imagePaginator = Paginator::create( $imageSet );

$uri.= strtok( $_SERVER['REQUEST_URI'], "?" ) . "item.php?";
unset( $_GET['page'] );
if ( $_GET ) {
    $uri .= http_build_query( $_GET ) . "&";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <link type="text/css" rel="stylesheet" href="style.css" />
        <title>Галлерея</title>
    </head>
    <body>
        <div id='main'>
            <div id="pagination">
                <?php $imagePaginator->displayPaginator(); ?>
            </div>
            <div id='matrix'>
                <?php
                foreach ( $imageSet as $val ) {
                    print '<div class="picture">';
                    print '<a href=' . $uri . 'id=' . $val->id . '>' . $val . '</a>';
                    print '</div>';
                }
                ?>
            </div>
        </div>
    </body>
</html>