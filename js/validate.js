function validate_signup(){
    //  ユーザーネーム
    $(".submit").on('click',function(){
        if($(".name").val() === ''){ 
            $(".required_name").html('*ニックネームを入力してください');
            return false;
        }else{
            $(".required_name").html('');
        }
        if($(".name").val().length >= 10){
            $(".count_name").html('*10文字以内で入力してください');
            return false;
        }else{
            $(".count_name").html('');
        }
    });
                
    //  メールアドレス
    $(".submit").on('click',function(){   
        if($(".mail").val() === ''){
            $(".required_mail").html('*メールアドレスを入力してください');
            return false;
        }else{
            $(".required_mail").html('');
        }

        if(!$(".mail").val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)){ 
            $(".error_mail").html('*メールアドレスは正しい形式で入力してください');
            return false;
        }else{
            $(".error_mail").html('');
        }
    });

    //  パスワード
    $(".submit").on('click',function(){   
        if($(".pass").val() === ''){
            $(".required_pass").html('*パスワードを入力してください');
            return false;
        }else{
            $(".required_pass").html('');
        }

        if(!$(".pass").val().match(/^(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}$/i)){ 
            $(".error_pass").html('*パスワードは半角英字と半角数字を含む8文字以上の文字列にしてください');
            return false;
        }else{
            $(".error_pass").html('');
        }
    });
    
    //  パスワード（確認用）
    $(".submit").on('click',function(){   
        if($(".pass_conf").val() !== $(".pass").val()){ 
            $(".error_pass_conf").html('*確認用パスワードが一致していません');
            return false;
        }else{
            $(".error_pass_conf").html('');
        }
    });
  
} // validate_signup



function validate_editUser(){
    
    //  ユーザーネーム
    $(".submit").on('click',function(){
        if($(".name").val() === ''){ 
            $(".required_name").html('*ニックネームを入力してください');
            return false;
        }else{
            $(".required_name").html('');
        }
        if($(".name").val().length >= 10){
            $(".count_name").html('*10文字以内で入力してください');
            return false;
        }else{
            $(".count_name").html('');
        }
    });
    
    // メールアドレス
    $(".submit").on('click',function(){   
        if($(".mail").val() === ''){
            $(".required_mail").html('*メールアドレスを入力してください');
            return false;
        }else{
            $(".required_mail").html('');
        }

        if(!$(".mail").val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)){ 
            $(".error_mail").html('*メールアドレスは正しい形式で入力してください');
            return false;
        }else{
            $(".error_mail").html('');
        }
    });
    
} // validate_editUser


function validate_post(){
 
	/*//フォームの中身を検証
	inputCheck();
	//inputフィールドの値が変わったら
	$(".file").change(function(){
		inputCheck();
	});*/
    
    // タイトル
    $(".submit").on('click',function(){
        
        if($(".title").val() === ''){ 
            $(".required_title").html('*タイトルを入力してください');
            return false;
        }else{
            $(".required_").html('');
        }
    });
    
    // カテゴリー
    $(".submit").on('click',function(){
        if($("select").val() === ''){ 
            $(".required_category").html('*該当するカテゴリーを選択してください');
            return false;
        }else{
            $(".required_category").html('');
        }
    });
    
    // 対象年齢
    
    // 本文
    $(".submit").on('click',function(){
        if(!$(".text").val().trim() == ""){
            $(".required_text").html('');

        }else if($(".text").val().trim() == ""){
            $(".required_text").html('*お問い合わせ内容は必須項目です');
            return false;
        }  
    });
    
    
 
}
                
                