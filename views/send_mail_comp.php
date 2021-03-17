<?php
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
if (!parse_url($referer, PHP_URL_HOST) == 'send_mail_form.php'){
     header('Location: main.php');
    return;
}

session_start();
require_once('../Models/User.php');

$err = [];

if(!$email = filter_input(INPUT_POST,'mail')){
    $err['mail'] = '*メールアドレスを入力してください';
    $_SESSION = $err;
    header('Location: send_mail_form.php');
    return;
}

$user = new UserLogic();
$result = $user->findUserMail($_POST['mail']);

//メールアドレスが登録されてない場合
if($result == false){
    header('Location: send_mail_form.php');
    $err['false'] = '*ご入力いただいたメールアドレスでのご登録はありません';
    $_SESSION = $err;
    return;
}else{
    //受信者の登録情報を取得
    $params = $user->getUser($_POST['mail']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>メール送信完了｜【ほいくの箱】保育のアイデア共有サイト</title>
        <link rel="stylesheet" href="../css/base.css">
        <link rel="stylesheet" href="../css/comp.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    
    <body>
        <div class="all_wrapper">
            <?php require("header.php"); ?>
            
            <div class="container">
                <div class="comp_form_wrap">
                    <h2 class="comp_h2">メールの送信が完了しました</h2>
                    <p class="comp_a">パスワード再設定用のURLをご登録頂いているメールアドレス宛に送信しました。</p>
                    <p class="comp_a">URLよりパスワード再設定画面へ進んでください。</p>
                </div>
                
            </div><!--container-->
            
            <?php require("footer.php"); ?>
        </div><!--all_wrapper-->
    </body>
</html>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// 設置した場所のパスを指定する
require('../PHPMailer/src/PHPMailer.php');
require('../PHPMailer/src/Exception.php');
require('../PHPMailer/src/SMTP.php');

// 文字エンコードを指定
mb_language('uni');
mb_internal_encoding('UTF-8');

// インスタンスを生成（true指定で例外を有効化）
$mail = new PHPMailer(true);

// 文字エンコードを指定
$mail->CharSet = 'utf-8';

try {
  // デバッグ設定
  // $mail->SMTPDebug = 2; // デバッグ出力を有効化（レベルを指定）
  // $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str<br>";};

  // SMTPサーバの設定
  $mail->isSMTP();                          // SMTPの使用宣言
  $mail->Host       = 'smtp.gmail.com';   // SMTPサーバーを指定
  $mail->SMTPAuth   = true;                 // SMTP authenticationを有効化
  $mail->Username   = 'hkds.brg40@gmail.com';   // SMTPサーバーのユーザ名
  $mail->Password   = 'officekengmail';           // SMTPサーバーのパスワード
  $mail->SMTPSecure = 'false';  // 暗号化を有効（tls or ssl）無効の場合はfalse
  $mail->Port       = 587; // TCPポートを指定（tlsの場合は465や587）

  // 送受信先設定（第二引数は省略可）
  $mail->setFrom('hkds.brg40@gmail.com', '【ほいくの箱】保育アイデア共有サイト'); // 送信者
  $mail->addAddress($_POST['mail'], $params['name'].'様');   // 宛先
  //$mail->addReplyTo('replay@example.com', 'お問い合わせ'); // 返信先
  //$mail->addCC('cc@example.com', '受信者名'); // CC宛先
  $mail->Sender = 'hkds.brg40@gmail.com'; // Return-path

  // 送信内容設定
  $mail->Subject = '【ほいくの箱】パスワード再設定用URLの送付'; 
  $mail->Body    = 
      '
      ※このメールはシステムからの自動返信です。
      
      ＜'.$params['name'].'＞様
      
      お世話になっております。
      パスワード再設定の申請を受け付けました。

      以下URLよりパスワード再設定ページにアクセスの上、パスワードの再設定を行ってください。
      
      http://localhost/php_selfmade/views/reset_pass_form.php?id='.$params['id'];  

  // 送信
  $mail->send();
} catch (Exception $e) {
  // エラーの場合
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
