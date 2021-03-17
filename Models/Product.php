<?php
require_once('../Models/Db.php');

class Product extends Db {

    public function __construct($dbh = null){
        parent::__construct($dbh);
    }

 
    /*productsテーブルにデータを挿入
    *
    * @param 引数なし
    * @return 返り値なし
    */
    public function create($post,$session,$files){
        $path = $this->save_image($files);
        $sql = 'INSERT INTO 
        products(image, title, text, user_id, category_id, target_id, created_at) 
        VALUES 
        (:image, :title, :text, :user_id, :category_id, :target_id, :created_at)';

        $this->dbh->beginTransaction();
        try{
            $date = date("Y-m-d H:i:s");
            $stmt = $this->dbh->prepare($sql);
            
            $params = array(
                ':image'=>$path,
                ':title'=>$post['title'],
                ':text'=>$post['text'],
                ':user_id'=>$session['login_user']['id'],
                ':category_id'=>$post['category'],
                ':target_id'=>$post['target'],
                ':created_at'=>$date
            );
            
            $stmt->execute($params);
            $this->dbh->commit();
            
            //リロード時の多重登録防止
            //$url = $_SERVER['REQUEST_URI'];
            //header("Location: {$url}");
            //exec;

        } catch(PDOException $e){
            $this->dbh->rollback();
            exit($e);
        }
    }
    

    /*productsテーブルから全てデータを取得
    *
    * @param integer $page ページ番号
    * @return Array $result 全作品データ
    */
    public function findAll($page = 0):Array {
        $sql = 'SELECT p.*, u.name AS user_name, u.image AS user_img  FROM products p 
        LEFT JOIN users u ON u.id = p.user_id ORDER BY created_at DESC';
        $sql .= ' LIMIT 20 OFFSET '.(20 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function findByNew(){
        $sql = 'SELECT p.*, u.name AS user_name, u.image AS user_img  FROM products p 
        LEFT JOIN users u ON u.id = p.user_id 
        ORDER BY id DESC LIMIT 5';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($result);
        return $result;
        
    }

    /*
    *productsテーブルから指定idに一致する作品データを取得
    *
    *@param integer $id 作品のid
    *@return Array $result 指定の作品データ
    */
    public function findByID($id):Array {
        $sql = 'SELECT p.*, c.name AS category, t.age AS target, u.name AS user_name, u.image AS user_img 
        FROM products p 
        LEFT JOIN categories c ON c.id = p.category_id 
        LEFT JOIN targets t ON t.id = p.target_id 
        LEFT JOIN users u ON u.id = p.user_id 
        WHERE p.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        //var_dump($result);
        return $result;
    }

    /*
    *テーブルから全データ数を取得
    *
    *@return Int $count 全選手の件数
    */
    public function countAll():Int {
        $sql = 'SELECT count(*) as count FROM products';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }
    
    //個人の投稿履歴
    public function findByHistory($id):Array {
        $sql = 'SELECT * FROM products WHERE user_id = :user_id ORDER BY created_at DESC';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    

    public function delete($id) {
        $sql = 'DELETE FROM products Where id = :id';

        $this->dbh->beginTransaction();
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $this->dbh->commit();

        } catch(PDOException $e){
            $this->dbh->rollback();
            exit($e);
        }
    }

    public function update($post,$files) {
        $path = $this->save_image($files);
        $sql = 'UPDATE products SET
        image = :image, title = :title, category_id= :category_id, target_id= :target_id, text= :text, updated= :updated WHERE id= :id';

        try{
            $date = date("Y-m-d H:i:s");
            $stmt = $this->dbh->prepare($sql);
            
            $params = array(
                ':image'=>$path,
                ':title'=>$post['title'],
                ':category_id'=>$post['category'],
                ':target_id'=>$post['target'],
                ':text'=>$post['text'],
                ':updated'=>$date,
                ':id'=>$post['id']
            );
            $stmt->execute($params);
            //echo "更新しました";

        } catch(PDOException $e){
            echo "更新失敗".$e->getMessage() ."\n";
            exit();
        }
    }
    

    //　カテゴリー　セレクトボックス用
    public function selectCategory():Array {
        $sql = 'SELECT * FROM categories;';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    //　対象年齢　セレクトボックス用
    public function selectTarget():Array {
        $sql = 'SELECT * FROM targets;';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    //　投稿後、詳細画面確認用
    public function toDetail(){
        $sql = 'SELECT MAX(id) AS id FROM products';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;   
    }
    
    //　キーワード検索
    public function search($input_keyword):Array {
        
        $keywords = preg_split('/[\s|\x{3000}]+/u',$input_keyword);
        
        $keywordCondition = [];
        foreach ($keywords as $keyword) {
            $key_title[] = 'p.title LIKE "%'.$keyword.'%"';
            $key_text[] = 'p.text LIKE "%'.$keyword.'%"';
            $key_category[] = 'c.name LIKE "%'.$keyword.'%"';
            $key_target[] = 't.age LIKE "%'.$keyword.'%"';
        }
        
        $key_title = implode(' AND ', $key_title);
        $key_text = implode(' AND ', $key_text);
        $key_category = implode(' AND ', $key_category);
        $key_target = implode(' AND ', $key_target);
        
        $sql = 'SELECT p.*, u.name AS user_name, u.image AS user_img, c.name, t.age FROM products p 
        LEFT JOIN users u ON u.id = p.user_id 
        LEFT JOIN categories c ON c.id = p.category_id 
        LEFT JOIN targets t ON t.id = p.target_id';
        $sql .= ' WHERE '.$key_title.' OR '.$key_text.' OR '.$key_category.' OR '.$key_target;
        
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    
    public function favorite($u_id,$p_id){
        try{
            $sql = 'SELECT * FROM favorites WHERE product_id = :p_id AND user_id = :u_id';
            $stmt = $this->dbh->prepare($sql);
            
            $params = array(
                ':u_id'=>$u_id,
                ':p_id'=>$p_id
            );
            
            $stmt->execute($params);
            $resultCount = $stmt->rowCount();
            
            // レコードが1件でもある場合
            if(!empty($resultCount)){
                // レコードを削除する
                $sql = 'DELETE FROM favorites WHERE product_id = :p_id AND user_id = :u_id';
                $stmt = $this->dbh->prepare($sql);
                $params = array(
                    ':u_id'=>$u_id,
                    ':p_id'=>$p_id
                );
            
                $stmt->execute($params);
                echo count($this->getGood($p_id));
            }else{
                // レコードを挿入する
                $sql = 'INSERT INTO favorites (product_id, user_id) VALUES (:p_id, :u_id)';
                $stmt = $this->dbh->prepare($sql);
                $params = array(
                    ':p_id'=>$p_id,
                    ':u_id'=>$u_id
                );
                
                $stmt->execute($params);
                echo count($this->getGood($p_id));
            }
            

        } catch(PDOException $e){
            exit($e);
        }
    }
    
    //いいねを取得
    function getGood($p_id){
        try {
            $sql = 'SELECT * FROM favorites WHERE product_id = :p_id';
            $stmt = $this->dbh->prepare($sql);
            $params = array(':p_id' => $p_id);
            $stmt->execute($params);
            return $stmt->fetchAll();
            
        }catch(Exception $e) {
            error_log('エラー発生：'.$e->getMessage());
        }
    }
   
    
    //いいねした情報があるか確認
    function isGood($u_id, $p_id){

        try {
            $sql = 'SELECT * FROM favorites WHERE product_id = :p_id AND user_id = :u_id';
            $data = array(':u_id' => $u_id, ':p_id' => $p_id);
            $stmt = $this->dbh->prepare($sql);
            
            $params = array(
                ':u_id'=>$u_id,
                ':p_id'=>$p_id,
            );
            $stmt->execute($params);

            if($stmt->rowCount()){
                //debug('お気に入りです');
                return true;
            }else{
                //debug('特に気に入ってません');
                return false;
            }

        } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
        }
    }
    
    // いいねした投稿を取得
    function getUserGood($u_id){
        try {
            $sql = 'SELECT p.*, u.name AS user_name, u.image AS user_img FROM products p 
            INNER JOIN users u ON u.id = p.user_id 
            INNER JOIN favorites f ON p.id = f.product_id 
            WHERE f.user_id = :u_id ORDER BY p.created_at DESC';
            $params = array(':u_id' => $u_id);
            
            $sth = $this->dbh->prepare($sql);
            $sth->execute($params);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            
        } catch (Exception $e) {
            error_log('エラー発生：'.$e->getMessage());
        }
    }


}
?>