<?php
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/db.php';
$db = MySQLDB::setDbConnection();

$dir = $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/files/';
$files = scandir($dir);


//foreach($files as $item) { 
//    if(($item != ".") && ($item != "..") ){
//        $query = "INSERT
//                  INTO `" . PICTURE_TABLE . "`(`filename`, `uri`)
//                  VALUES ('" . $item . "','" . DEFAULT_URI . "')";
//        mysql_query($query);
//        echo $db->insert_id()." ". $item ."<br>";
//    }
//}

$source = $_SERVER[ 'DOCUMENT_ROOT' ]."/tools/comments.txt";
$file = new SplFileObject($source);


foreach ($file as $line_num => $line) {
    $query = "INSERT
                  INTO `" . COMMENTS_TABLE . "`(`comment`, `author`)
                  VALUES ('" . $line . "','Guest')";
    mysql_query($query);
}


?>