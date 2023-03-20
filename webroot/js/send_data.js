$(document).ready(function()
{
    /**
     * 送信ボタンクリック
     */
    $('#send').click(function()
    {
        // Formヘルパーで生成したCSRFトークンの値を取得
        var csrf = $('input[name=_csrfToken]').val();
        var data = { request : $('#textdata').val() };
        alert( $('#textdata').val() );
        /**
         * Ajax通信メソッド
         * @param type  : HTTP通信の種類
         * @param url   : リクエスト送信先のURL
         * @param data  : サーバに送信する値
         */
        $.ajax({
            type: 'POST',
            datatype:'json',
            //url: "http://localhost/cake3/cake398_article/data/add",
            url: '/cake3/cake398_article/data/add',
            data: data,
            // ここが本丸。CSRFトークンをセット
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-Token', csrf);
            },
            success: function(data,dataType)
            {         
                alert('Success');
            },
            /**
             * Ajax通信が失敗した場合に呼び出されるメソッド
             */
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Error : ' + errorThrown);
            }
        });
        return false;
    });
});