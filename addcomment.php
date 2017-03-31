<?php
// коннектимся к базе
$dsn = "mysql:host=localhost; dbname=gallery; charset=utf-8";
$pdo = new PDO( $dsn, "root", "" );

//добавление комментария
if (isset($_POST[ 'author' ])) {
	$author = $_POST[ 'author' ];
} else $author = 'Guest';

if (isset($_POST[ 'comment' ])) {
	$comment = $_POST[ 'comment' ];
}

if (isset($_POST[ 'fid' ])) {
	$fid = $_POST[ 'fid' ];
}

$query = "INSERT 
          INTO `comments` (`author`, `comment`) 
          VALUES ('" . $author . "','" . $comment . "')";
$sth = $pdo->prepare($query);
$sth->execute();
$lastId = $pdo->lastInsertId();
$query = "INSERT
          INTO `relations` (`fid`, `cid`)
          VALUES ('" . $fid . "','" . $lastId . "')";
$sth = $pdo->prepare($query);
$sth->execute();
header('Location: '. $_SERVER['HTTP_REFERER']);
