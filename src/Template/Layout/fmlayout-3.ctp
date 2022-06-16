<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?></title>
    <!-- 外部ファイルとスクリプトファイルがここに入れます (詳しくは HTML ヘルパーを参照。) -->
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('style-3.css') ?>
    <?= $this->Html->css('hbg-menu.css') ?>
    <?= $this->Html->script('jquery-3.6.0.min.js') ?>
    <?= $this->Html->script('hbg-menu.js') ?>
    <script type="text/javascript">
    <!-- 
        function onClick()
        {
            if ($('message').className == 'type1'){
                $('message').className = 'type2';
            } else {
                $('message').className = 'type1';
            }
        }
    //-->
    </script>
    <?php
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?> 
</head>
<body>
    <h1><?= h($this->fetch('h1')) ?></h1>
    <!-- もしすべてのビューでメニューを表示したい場合、ここに入れます -->
    <div id="header">
        <p class="menubtn"><img src="/cake_cms/img/piece.png" alt="menu"></p>
        <nav>
            <ul>
                <li>アバウト</li>
                <li>メイン</li>
                <li>ポリシー</li>
            </ul>  
        </nav>
        <?= $this->element('headerbox'); ?>  
    </div>
    <!-- ここがビューで表示されるようにしたい場所です -->
    <?= $this->Flash->render() ?>
    <div class="content "><?= $this->fetch('content') ?></div>
        <div>
            <div class="type1" id="message">message</div>
            <input type="button" onclick="onClick()" value="背景の変更">
        </div> 
    <!-- 表示される各ページにフッターを追加します -->
    <div id="footer"><?= $this->element('footerbox'); ?></div>
</body>
</html>