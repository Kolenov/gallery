<?php
session_start();
$back = $_SESSION['back'];

require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/image.php';
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/comment.php';
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/commentcollection.php';
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/paginator.php';

if ( isset( $_GET[ 'id' ] ) ){
	$currentItem = $_GET[ 'id' ];
}
if ( isset( $_GET[ 'page' ] ) ){
	$currentPage = $_GET[ 'page' ];
}

// коннектимся к базе, получаем картинку
$dsn = "mysql:host=localhost; dbname=gallery; charset=utf-8";
$pdo = new PDO( $dsn, "root", "" );
$query = "SELECT id, filename, uri FROM picture WHERE id='" . $currentItem . "'";
$result = $pdo->query( $query );
$result->setFetchMode( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Image' );
$obj = $result->fetch();

$commentSet = CommentCollection::create( $currentPage, 9, $currentItem);
$commentPaginator = Paginator::create( $commentSet );
?>

<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link type="text/css" rel="stylesheet" href="style.css" />
<title>Картинка</title>
</head>
<body>
	<div id='main'>
	<a href="<?php echo $back; ?>">В галлерею</a><br><hr>
		
		<div id='pict'>
		  <?php print $obj;?>
		</div>
        
        <div id="pagination">
	       <?php $commentPaginator->displayPaginator();?>
		</div>
		
		<form name="addcomment" action="/addcomment.php" method="post">
		    <input type="hidden" name="fid" value="<?php echo $currentItem; ?>">
        	<p>Имя</p>
        	<input type="text" id="author" name="author" placeholder="Введите имя">
        	<p>Комментарий</p>
        	<textarea name="comment" cols="30" rows="5" ></textarea><br>
        	<input type="submit" value="Отправить">
        	<input type="reset" value="Очистить">
        </form>
        
        <div id="comments">
        <?php
			foreach( $commentSet as $val ){
				print $val;
			}
		?>
		</div>

	</div>
</body>
</html>