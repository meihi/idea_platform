<?php
session_start();
$err = $_SESSION;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>メール送信フォーム｜【ほいくの箱】保育のアイデア共有サイト</title>
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/send_mail.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    
    <body>
        <div class="all_wrapper">
            <?php require("header.php"); ?>
            
            <div class="container">
                
                <div class="user_form">
                    <h2>パスワード再設定画面のURLを送信します。</h2>
                        <p class="send_p">ご登録頂いているメールアドレスを入力してください。</p>
                    <form action="send_mail_comp.php" method="post">

                        <?php if(isset($err['msg'])): ?>
                        <p class="red"><?php echo $err['msg']; ?></p>
                        <?php endif; ?>

                         <div class="form_content">
                             <input class="mail" name="mail" type="text" placeholder="メールアドレス"/>

                             <p class="red required_mail"></p>
                             <p class="red error_mail"></p>
                             <?php if(isset($err['mail'])): ?>
                             <p class="red"><?php echo $err['mail']; ?></p>
                             <?php endif; ?>
                             
                             <?php if(isset($err['false'])): ?>
                             <p class="red"><?php echo $err['false']; ?></p>
                             <?php endif; ?>
                         </div>

                        <input type="submit" class="submit" value="メール送信">
                    </form>
                </div>
            </div><!--container-->
            
            <?php require("footer.php"); ?>
        </div><!--all_wrapper-->
    </body>
</html>