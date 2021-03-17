<?php
require_once('Db.php');
    
class UserLogic extends Db{
    private $table = 'users';
    
    
    //ユーザーを登録する
    public function createUser($userData){
        $result = false;
        $sql = 'INSERT INTO users(name,mail,password,created_at) 
        VALUES (:name, :mail, :password, :created_at)';
        
        try{
             $date = date("Y-m-d H:i:s");
            $params = array(
                ':name' => $userData['name'],
                ':mail' => $userData['mail'],
                ':password' => password_hash($userData['password'], PASSWORD_DEFAULT),
                ':created_at'=>$date
            );
            $sth = $this->dbh->prepare($sql);
            $result = $sth->execute($params);
            return $result;
            //echo "登録完了";
        } catch(\Exception $e){
            return $result;
            echo "登録失敗";
        }   
    }
    
    
    //　ログイン
    public function login($mail,$password){
        $result = false;
        //ユーザーをemailから検索して取得
        $user = $this->getUserByEmail($mail);
        
        if(!$user){
            $_SESSION['msg'] = 'emailが一致しません';
            return $result;
        }
        
        //パスワード照会
        if(password_verify($password,$user['password'])){
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        } 
        
        $_SESSION['msg'] = '*パスワードが間違っています';
        return $result;
        
        //var_dump($user);
        //return;
    }
    
    
    // emailからユーザーを取得
    public function getUserByEmail($mail){
        $sql = 'SELECT * FROM users WHERE mail = ?';
        
        //emailを配列に入れる
        $arr = [];
        $arr[] = $mail;
        
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->execute($arr);
            //SQLの結果を返す
            $user = $sth->fetch();
            return $user;
        } catch(\Exception $e){
            return false;
        }   
    }
    
    // 指定idのプロフィール情報表示
    public function findByID($id):Array {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        //var_dump($result);
        return $result;
    }
    
    // プロフィール編集
    public function updateUser($post,$files) {
        $path = $this->save_image($files);
        $sql = 'UPDATE users SET
        image= :image, name= :name, mail= :mail, updated= :updated WHERE id= :id';

        try{
            $date = date("Y-m-d H:i:s");
            $stmt = $this->dbh->prepare($sql);
            
            $params = array(
                ':image'=>$path,
                ':name'=>$post['name'],
                ':mail'=>$post['mail'],
                ':updated'=>$date,
                ':id'=>$post['id']
            );
            $stmt->execute($params);
            var_dump($files);
            //echo "更新しました";

        } catch(PDOException $e){
            echo "更新失敗".$e->getMessage() ."\n";
            exit();
        }
    }
    
    //　パスワードリセット
    public function passReset($id,$pass) {
        $sql = 'UPDATE users SET 
        password = :password, updated= :updated WHERE id= :id';

        try{
            $date = date("Y-m-d H:i:s");
            $stmt = $this->dbh->prepare($sql);
            
            $params = array(
                ':password'=>password_hash($pass, PASSWORD_DEFAULT),
                ':updated'=>$date,
                ':id'=>$id
            );
            $stmt->execute($params);
            //echo "更新しました";

        } catch(PDOException $e){
            echo "更新失敗".$e->getMessage() ."\n";
            exit();
        }
    }
    
    
    public function deleteUser($id) {
        $sql = 'DELETE FROM users WHERE id = :id';

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
    
    public function deleteUserP($id) {
        $sql = 'DELETE FROM products WHERE user_id = :id';

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
    
    
    
    /**
    *ログインチェック
    *@param void
    *@return bool $result
    */
    public function checkLogin(){
        $result = false;
        
        //セッションにログインユーザーが入っていなかったらfalse
        if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
            return $result = true;
        }
        return $result;
        if (!$result){
            $_SESSION['login_err'] = '*ページを閲覧するにはログインが必要です';
            header('Location: login_form.php');
            return;
        }
    }
    
    public function findUserMail($mail){
        $sql = 'SELECT * FROM users WHERE mail = ?';
        
        //emailを配列に入れる
        $arr = [];
        $arr[] = $mail;
        
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->execute($arr);
            
            $user = $sth->fetch();
            if(!$user){
                return false;
            }else{
                return true;
            }
        } catch(\Exception $e){
            return false;
        }   
    }
    
    //メール送信用
    public function getUser($mail){
        try{
            $sql = 'SELECT * FROM users WHERE mail = :mail';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':mail', $mail, PDO::PARAM_STR);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            //var_dump($result);
            return $result;
            
        }catch(\Exception $e){
            return false;
        }
    }
    
    
}
?>