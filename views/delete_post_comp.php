<?php
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
if (!parse_url($referer, PHP_URL_HOST) == 'product_detail.php'){
     header('Location: main.php');
    return;
}

session_start();

require_once('../Models/Product.php');
$product = new Product();
$product->delete($_GET['id']);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>投稿削除完了｜【ほいくの箱】保育のアイデア共有サイト</title>
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/comp.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    
    <body>
        <div class="all_wrapper">
            <?php require("header.php"); ?>
            
            <div class="container">
                <div class="comp_form_wrap">
                    <h2 class="comp_h2">投稿を削除しました</h2>
                    <p class="comp_a"><a href="mypage.php">マイページに戻る</a></p>
                    <p class="comp_a"><a href="main.php">トップページへ</a></p>
                </div>   
            </div><!--container-->
            
            <?php require("footer.php"); ?>
        </div><!--all_wrapper-->
    </body>
</html>