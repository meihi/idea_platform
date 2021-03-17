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
    $params = $product->getUserGood($_GET['id']);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>お気に入り投稿一覧｜【ほいくの箱】保育のアイデア共有サイト</title>
        <link rel="SHORTCUT ICON" href="../images/favicon.png" type="image/png">
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/ichiran.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    
    <body>
        <div class="all_wrapper">
            <?php require("header.php"); ?>
            
            <div class="container">
                
                <div class="post_wrapper">
                   
                    <h3>お気に入り投稿一覧</h3>
                    
                    <div class="newpost_flex">
                        <?php foreach($params as $value): 
                        
                        ?>
                        <div class="product_wrap">
                            <a href="product_detail.php?id=<?= $value['id'] ?>"><img class="product_img" src="<?= $value['image'] ?>"></a>
                            <div class="author_wrap">
                                <img class="author_icon" src="<?= $value['user_img'] ?>">
                                <a class="author_name" href="user_detail.php?id=<?= $value['user_id'] ?>"><?= $value['user_name'] ?></a>
                            </div>
                            
                            
                        </div>
                        <?php endforeach; ?>
                        
                        
                    </div><!-- newpost_flex -->
            
                </div><!-- newpost_wrapper -->

            </div><!--container-->
            
            <?php require("footer.php"); ?>
        </div><!--all_wrapper-->
    </body>
</html>