<?php
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/classes/entity.php';
class Comment extends Entity
{
	public $id;
	public $author;
	public $comment;

	public function __construct ($comment = "", $author = 'guest', $id = null)
	{
		$this->cid = $id;
		$this->author = $author;
		$this->comment = $comment;
	}

	public function __toString ()
	{
	    return "<div class='author'>". $this->author . "</div><div class='comment'>" . $this->comment . "</div>";
	}
}