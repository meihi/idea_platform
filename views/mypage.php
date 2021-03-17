<?php
session_start();

require_once('../Models/User.php');
$user = new UserLogic();
$result = $user->checkLogin();

if (!$result){
    header('Location: login_form.php');
    return;
}else{
    $params = $user->findByID($_SESSION['login_user']['id']);   
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>マイページ｜【ほいくの箱】保育のアイデア共有サイト</title>
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/mypage.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    
    <body>
        <div class="all_wrapper">
            <?php require("header.php"); ?>
            
            <div class="container">
                 <div class="form_wrap">
                    <h2>マイページ</h2>
                     
                    <div class="user_wrap">
                         <div class="prof_icon">
                             <img src="<?= $params['image'] ?>">
                         </div>
                         <div class="prof_name">
                             <h2><?= $params['name'] ?></h2>
                         </div>
                    </div>

                    <!--<div class="follow_wrap">
                        <a class="follow" href="follow.php"><?//= ?> フォロー中</a>
                        <a class="follower" href="follower.php"><?//=  ?> フォロワー</a>
                    </div>-->

                    <div class="mypage_btn_wrap">
                        <div class="mypage_btn">
                            <a href="my_post_history.php?id=<?= $_SESSION['login_user']['id'] ?>"><button>あなたの投稿履歴</button></a>
                        </div>
                        <div class="mypage_btn">
                            <a href="my_favorite_post.php?id=<?= $_SESSION['login_user']['id'] ?>"><button>いいねした投稿</button></a>
                        </div>
                        <div class="mypage_btn">
                            <a href="edit_pf_form.php?id=<?= $_SESSION['login_user']['id'] ?>"><button>会員情報変更</button></a>
                        </div>
                        <div class="mypage_btn">
                            <a class="logoff" href="login_form.php" onclick="return confirm('ログアウトしてよろしいですか？')">ログアウト</a>
                        </div>
                    </div>
                </div><!--form_wrap-->
    
            </div><!--container-->
            
            <?php require("footer.php"); ?>
        </div><!--all_wrapper-->
    </body>
</html>