<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title><?= h($this->fetch('title')) ?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<!-- 外部ファイルとスクリプトファイルがここに入ります (詳しくは HTML ヘルパーを参照。) -->
<?= $this->Html->meta('icon') ?>
<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('style.css') ?>
<?= $this->Html->css('style-1') ?>
<?= $this->Html->css('style-2') ?>

<?= $this->Html->script('jquery-3.6.0.min.js') ?>
<?= $this->Html->script('hbg-menu.js') ?>
<?php
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>
</head>
<body>
  <p><?= h($this->fetch('title')) ?></p>

  <!-- もしすべてのビューでメニューを表示したい場合、ここに入れます -->
  <div class="topmenu">
    <p class="menubtn"><?= $this->Html->image('piece.png') ?></p>
      <nav>
          <ul>
              <li><a href="">アバウト></a></li>
              <li><a href="">メイン</a></li>
              <li><a href="">ポリシー</a></li>
          </ul>  
      </nav>
  </div>
  <div id="header"><?= $this->element('headerbox'); ?></div>

  <!-- ここがビューで表示されるようにしたい場所です -->
  <?= $this->Flash->render() ?>
  <div class="content clearfix">
        <?= $this->fetch('content') ?>
  </div>
  
  <!-- 表示される各ページにフッターを追加します -->
  <div id="footer"><?= $this->element('footerbox'); ?></div>
</body>
</html>