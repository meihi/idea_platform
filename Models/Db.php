<?php
require_once('../database.php');

class Db {
    protected $dbh;
    
    public function __construct($dbh = null) {
        if(!$dbh){
            try{
                $this->dbh = new PDO(
        
                    'mysql:dbname='.DB_NAME.
                    ';host='.DB_HOST,DB_USER,DB_PASSWD
                );
                //echo "接続成功１";
                
            }catch (PDOException $e){
                echo "接続失敗".$e->getMessage() ."\n";
                exit();
            }
        }else {
            $this->dbh = $dbh;
            //echo "接続成功２";
        }
    }
    
    public function get_db_handler() {
        return $this->dbh;
    }
    
    
    public function save_image($files) {
        if (empty($files['img']['tmp_name'])) {
            return '';
        }
        $file = $files['img'];
        $dir = dirname(__FILE__) . './../post_images/';
        $urlbase = './../post_images/';

        $tmp = preg_split('#/#', $file['type']);
        $type =  array_pop($tmp);

        $name = md5_file($file['tmp_name']) . '.' . $type;
        $path = $dir . $name ;
        
        move_uploaded_file($file['tmp_name'], $path);
        return $urlbase . $name;
    }
    
}
?>