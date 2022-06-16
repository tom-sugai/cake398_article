<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title><?= h($this->fetch('title')) ?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<!-- 外部ファイルとスクリプトファイルがここに入ります (詳しくは HTML ヘルパーを参照。) -->
<?= $this->Html->css('MyTheme.style-1') ?>
<?= $this->Html->css('MyTheme.style-2') ?>
<?= $this->Html->script('jquery-3.6.0.min.js') ?>
<?= $this->Html->script('MyTheme.hbg-menu.js') ?>
<?php
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>
</head>
<body>
  <!-- もしすべてのビューでメニューを表示したい場合、ここに入れます -->
  <div class="topmenu">
    <p class="menubtn"><?= $this->Html->image('MyTheme.piece.png') ?></p>
      <nav>
          <ul>
              <li><a href="">アバウト></a></li>
              <li><a href="">メイン</a></li>
              <li><a href="">ポリシー</a></li>
          </ul>  
      </nav>
  </div>
  <p><?= h($this->fetch('title')) ?></p>
  <div id="header">  
    <!-- <p>...header block</p> -->
    <ul>
      <li><a href="">menu1</a></li>
      <li><a href="">menu2</a></li>
      <li><a href="">menu3</a></li>
    </ul>
    <!-- <p>...end header</P> -->
  </div>
  <!-- ここがビューで表示されるようにしたい場所です -->
  <?= $this->fetch('content') ?>
  <!-- 表示される各ページにフッターを追加します -->
  <div id="footer">
  <!--  <p>...footer block</p>
    <p>...footer...</p>
    <p>...end footer</p>
  -->
  </div>
</body>
</html>