<?php
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
if (!parse_url($referer, PHP_URL_HOST) == 'delete_pf_conf.php'){
     header('Location: main.php');
    return;
}

session_start();

require_once('../Models/User.php');
$user = new UserLogic();
$user->deleteUser($_GET['id']);
$user->deleteUserP($_GET['id']);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>退会完了｜【ほいくの箱】保育のアイデア共有サイト</title>
        <link rel="SHORTCUT ICON" href="../images/favicon.png" type="image/png">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/comp.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    
    <body>
        <div class="all_wrapper">
            <?php require("header.php"); ?>
            
            <div class="container">
                <div class="comp_form_wrap">
                    <h2 class="comp_h2">退会手続きが完了しました</h2>
                    <p>またのご利用をお待ちしております</p>
                    <p class="comp_a"><a href="signup_form.php">新規登録画面へ</a></p>
                </div>
                
            </div><!--container-->
            
            <?php require("footer.php"); ?>
        </div><!--all_wrapper-->
    </body>
</html>