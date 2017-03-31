<?php
require_once $_SERVER[ 'DOCUMENT_ROOT' ] . '/config.php';
class MySQLDB
{
    private $host;
    private $user;
    private $password;
    private $db_name;
    private $id_connection;

    public function __construct ($h = SERVER, $u = USERNAME, $p = PASSWORD, $dbn = DBNAME)
    {
        $this->host = $h;
        $this->user = $u;
        $this->password = $p;
        $this->db_name = $dbn;
    }

    public function connect_db ()
    {
        $this->id_connection = mysql_connect( $this->host, $this->user, $this->password );
        if ( ! $this->id_connection) {
            exit( 'Ошибка подключения к серверу ' .$this->host );
        }
        if ( ! mysql_select_db( $this->db_name )) {
            exit( 'Ошибка подключения к базе данных ' .$this->db_name );
        }
    }

    public function disconnect_db ()
    {
        if ($this->id_connection) {
            mysql_close( $this->id_connection );
            unset( $this->id_connection );
        }
    }

    public static function setDbConnection ()
    {
        $db = new MySQLDB();
        $db->connect_db();
        return $db;
    }

    public function insert_id ()
    {
        return @mysql_insert_id( $this->id_connection );
    }

    public function __destruct ()
    {
        if ($this->id_connection) {
            mysql_close( $this->id_connection );
            unset( $this->id_connection );
        }
    }
}
/*
$pdo = new PDO("mysql:host=localhost;dbname=gallery", "root", "");
$query = "SELECT fid, filename, uri FROM picture LIMIT 0,9";
$result = $pdo->query($query);
$result->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Image');
while ($img = $result->fetch()) {
    var_dump($img);
}

class Base {
    static $DB;
    static $stmts = array();
     
    function __construct($dsn) {
        if ( is_null( $dsn ) ) {
            throw new Exception( "No DSN" );
        }

        self::$DB = new PDO( $dsn );
        self::$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function prepareStatement( $stmt_s ) {
        if ( isset( self::$stmts[$stmt_s] ) ) {
            return self::$stmts[$stmt_s];
        }
        $stmt_handle = self::$DB->prepare($stmt_s);
        self::$stmts[$stmt_s]=$stmt_handle;
        return $stmt_handle;
    }

    protected function doStatement( $stmt_s, $values_a ) {
        $sth = $this->prepareStatement( $stmt_s );
        $sth->closeCursor();
        $db_result = $sth->execute( $values_a );
        return $sth;
    }
}
*/





















?>