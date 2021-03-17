<?php
session_start();

require_once('../Models/User.php');
$user = new UserLogic();
$result = $user->checkLogin();

if (!$result){
    header('Location: login_form.php');
    return;
}else{
    require_once('../Models/Product.php');
    $product = new Product();
    $params = $product->findByID($_GET['id']);
    
    // DBからいいねを取得
	$dbPostGoodNum = count($product->getGood($_GET['id']));
}

function h($str){
   return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>作品詳細｜【ほいくの箱】保育のアイデア共有サイト</title>
        <link rel="SHORTCUT ICON" href="../images/favicon.png" type="image/png">
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/product_detail.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="../js/favorite.js"></script>
    </head>
    
    <body>
        <div class="all_wrapper">
            <?php require("header.php"); ?>
            
            <div class="container">
                
                <div class="detail_wrap">

                    <div class="detail_left"><!--（投稿写真、作成者など）　画面の左側-->
                             
                         <div class="d_content d_author">
                             <div class="author_icon">
                                 <img src="<?= $params['user_img'] ?>">
                             </div>
                             <div class="author_name">
                                 <a href="<?php if($_SESSION['login_user']['id'] === $params['user_id']){
                                        echo "mypage.php";
                                    }else{
                                        echo "user_detail.php";
                                    } ?>"> <?= $params['user_name'] ?>
                                 </a>
                             </div>
                        </div>

                        <div class="d_content d_img">
                            <img src="<?= $params['image'] ?>">
                        </div>
                       
                        <!--　いいねボタン　-->
                        <section class="post" data-postid="<?php echo $_GET['id'] ?>">
                            <div class="btn-good <?php if($product->isGood($_SESSION['login_user']['id'], $params['id'])) echo 'active'; ?>">
                                <!-- 自分がいいねした投稿にはハートのスタイルを常に保持する -->
                                <i class="fa-heart fa-lg px-16
                                <?php
                                    if($product->isGood($_SESSION['login_user']['id'],$params['id'])){
                                        echo ' active fas';
                                    }else{
                                        echo ' far';
                                    }; ?>"></i><span><?php echo $dbPostGoodNum; ?></span>
                            </div>
                        </section>
                         
                        
                    </div><!-- detail_left -->

                    <div class="detail_right"><!--（タイトル、本文など）　画面の右側-->
                        <div class="d_content d_title">
                            <h2>【 <?= $params['title'] ?> 】</h2>
                        </div>

                        <div class="select_wrap">
                            <div class="d_content d_category">
                                <p class="s1 category">カテゴリー</p>
                                <p class="s2"><?= $params['category'] ?></p>
                            </div>

                            <div class="d_content d_target">
                                <p class="s1 target">対象年齢</p>
                                <p class="s2"><?= $params['target'] ?></p>
                            </div>
                        </div><!-- select_wrap -->

                        <div class="d_content d_text">
                            <p><?= nl2br(h($params['text'])); ?></p>
                        </div>

                        <?php if($_SESSION['login_user']['id'] === $params['user_id']): ?>
                        <div class="btn_wrap">
                            <a class="btn" href="edit_post_form.php?id=<?= $params['id'] ?>"><i class="fa fa-edit"></i> 編集</a>
                            <a class="btn" href="delete_post_comp.php?id=<?= $params['id'] ?>" onclick="return confirm('作品データを削除します。よろしいですか？')"><i class="fa fa-trash"></i> 削除</a>
                        </div>
                        <?php endif; ?>
                        
                    </div><!-- detail_right -->

                </div><!-- detail_wrap -->

            </div><!-- container -->
            
            <?php require("footer.php"); ?>
        </div><!--all_wrapper-->
    </body>
</html>