$(function(){
    var $good = $('.btn-good'),　goodPostId;

    $good.on('click',function(){
        var $this = $(this);
        goodPostId = $this.parents('.post').data('postid'); //投稿ID取得
        $.ajax({
                url:'favorite.php',
                type:'POST',
                data: { postId: goodPostId}
        }).done(function(data){
                // いいねの総数を表示
                $this.children('span').html(data);
                // いいね取り消しのスタイル
                $this.children('i').toggleClass('far'); //空洞ハート
                // いいね押した時のスタイル
                $this.children('i').toggleClass('fas'); //塗りつぶしハート
                $this.children('i').toggleClass('active');
                $this.toggleClass('active');
        }).fail(function(msg) {
                //console.log('Ajax Error');
        });
    });
});