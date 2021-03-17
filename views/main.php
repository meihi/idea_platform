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
    $params = $product->findByNew();
    //var_dump($params);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>【ほいくの箱】保育のアイデア共有サイト</title>
        <link rel="SHORTCUT ICON" href="../images/favicon.png" type="image/png">
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="../js/favorite.js"></script>
    </head>
    
    <body>
        <div class="all_wrapper">
            <?php require("header.php"); ?>
            
            <div class="container">
                
                
                <div class="newpost_wrapper">
                    <div class="newpost_flex">
                        <h3>新着投稿</h3>
                        <a class="more" href="search_results.php">すべて見る ></a>
                    </div>
                    
                    <div class="newpost_flex">
                        <?php foreach($params as $value): 
                        
                        ?>
                        <div class="new_post">
                            <a href="product_detail.php?id=<?= $value['id'] ?>"><img class="product_img" src="<?= $value['image'] ?>"></a>
                            
                            <div class="favorite_flex">
                                <div class="author_wrap">
                                    <img class="author_icon" src="<?= $value['user_img'] ?>">
                                    
                                    <!-- マイページ or 他ユーザーページへ　-->
                                    <a class="author_name" href="<?php if($_SESSION['login_user']['id'] === $value['user_id']){ echo "mypage.php"; }else{ echo "user_detail.php?id=".$value['user_id']; } ?>"><?= $value['user_name'] ?></a>
                                </div>
                               
                                
                            </div><!-- favorite_flex -->

                        </div><!-- new_post -->
                        <?php endforeach; ?> 
                    </div><!-- newpost_flex -->
                </div><!-- newpost_wrapper -->
                
                <div class="category_search">
                    <h3>カテゴリー別で探す</h3>
                    <ul class="c_search_btn_wrap">
                        <li><a href="#"><img class="c_search_btn" src="../images/category_btn_red.png" alt="壁面のはこ"></a></li>
                        <li><a href="#"><img class="c_search_btn" src="../images/category_btn_orange.png" alt="製作のはこ"></a></li>
                        <li><a href="#"><img class="c_search_btn" src="../images/category_btn_yellow.png" alt="あそびのはこ"></a></li>
                        <li><a href="#"><img class="c_search_btn" src="../images/category_btn_green.png" alt="出し物のはこ"></a></li>
                        <li><a href="#"><img class="c_search_btn" src="../images/category_btn_blue.png" alt="保育士のはこ"></a></li>
                    </ul>
                </div><!-- category_search -->
                
                <div class="keyword_search">
                    <h3>キーワードで探す</h3>
                    <form action="search_results.php" method="post">
                        <input id="search_form"  id="s" name="keysearch" type="text" placeholder="春　壁面"/>
                        <button type="submit" id="search_btn"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="popular_keyword">
                        <p>＜人気のキーワード＞</p>　
                        <ul>
                            <li><a href="#">壁面</a></li>
                            <li><a href="#">卒園式</a></li>
                            <li><a href="#">ひなまつり</a></li>
                            <li><a href="#">春</a></li>
                            <li><a href="#">手形</a></li>
                            <li><a href="#">年長</a></li>
                            <li><a href="#">桜</a></li>
                            <li><a href="#">新年度</a></li>
                        </ul>
                    </div>
                </div><!-- keyword_search -->
                
            </div><!--container-->
            
            <?php require("footer.php"); ?>
        </div><!--all_wrapper-->
    </body>
</html>