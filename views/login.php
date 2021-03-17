<?php
session_start();
require_once('../Models/User.php');

$err = [];

if(!$email = filter_input(INPUT_POST,'mail')){
    $err['mail'] = '*メールアドレスを入力してください';
}
if(!$password = filter_input(INPUT_POST,'password')){
    $err['password'] = '*パスワードを入力してください';
}

if(count($err) > 0){
    //エラーがあった場合は戻す
    $_SESSION = $err;
    header('Location: login_form.php');
    return;
    
}
//ログイン成功時
$user = new UserLogic();
$result = $user->login($_POST['mail'],$_POST['password']);
header('Location: main.php');

//ログイン失敗時 
if(!$result){
    header('Location: login_form.php');
    return;
}

?>