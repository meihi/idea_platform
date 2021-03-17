<?php
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
if (!parse_url($referer, PHP_URL_HOST) == 'signup_form.php'){
     header('Location: main.php');
    return;
}

session_start();

require_once('../Models/User.php');
 $user = new UserLogic();

$err = [];

if(!$name = filter_input(INPUT_POST,'name')){
    $err['name'] = 'ニックネームを入力してください';
}

$pattern_add = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
if(!$email = filter_input(INPUT_POST,'mail')){
    $err['mail'] = '*メールアドレスを入力してください';
}else if(!preg_match($pattern_add, $email)){
    $err['mail'] = '*メールアドレスは正しい形式で入力してください';
}else if($user->findUserMail($email) === true){
    $err['mail'] = '*入力いただいたメールアドレスは既にご登録済みです';
}

$password = filter_input(INPUT_POST,'password');
if(!preg_match("/^(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}$/i", $password)){
    $err['password'] = '*パスワードは半角英字と半角数字を含む8文字以上の文字列にしてください';
}

$password_conf = filter_input(INPUT_POST,'pass_conf');
if($password !== $password_conf){
    $err['pass_conf'] = '*確認用パスワードが異なっています';
}

if(count($err) > 0){
    $_SESSION = $err;
    header('Location: signup_form.php');
    return;
    
}else {
    //ユーザ登録処理
    $hasCreated = $user->createUser($_POST);
    
    if(!$hasCreated){
        $err[] = '登録に失敗しました';
    }else{
        $user = new UserLogic();
        $hasCreated = $user->createUser($_POST);
    
        if(!$hasCreated){
            $err[] = '登録に失敗しました';
        }else{
            $result = $user->getUser($_POST['mail']); 
            $_SESSION['login_user'] = $result;
        } 
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>新規会員登録完了｜【ほいくの箱】保育のアイデア共有サイト</title>
        <link rel="SHORTCUT ICON" href="../images/favicon.png" type="image/png">
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/comp.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    
    <body>
        <div class="all_wrapper">
            <?php require("header.php"); ?>
            
            <div class="container">
                <div class="comp_form_wrap">
                    <h2 class="comp_h2">新規会員登録が完了しました</h2>
                    <p class="comp_a"><a href="mypage.php?id=<?= $_SESSION['login_user']['id'] ?>">マイページを見る</a></p>
                    <p class="comp_a"><a href="main.php">トップページへ</a></p>
                </div>
                
            </div><!--container-->
            
            <?php require("footer.php"); ?>
        </div><!--all_wrapper-->
    </body>
</html>