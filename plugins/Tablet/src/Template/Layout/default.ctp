<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title><?= h($this->fetch('title')) ?></title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<!-- 外部ファイルとスクリプトファイルがここに入れます (詳しくは HTML ヘルパーを参照。) -->
<?= $this->Html->css(['style']) ?>
<?php
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>
</head>
<body>
  <!-- もしすべてのビューでメニューを表示したい場合、ここに入れます -->
  <p><?= h($this->fetch('title')) ?></p>
  <div id="header">  
    <p>...header block</p>
      <ul>
        <li><a href="">menu1</a></li>
        <li><a href="">menu2</a></li>
        <li><a href="">menu3</a></li>
      </ul>
  </div>
<!-- ここがビューで表示されるようにしたい場所です -->
<?= $this->fetch('content') ?>

<!-- 表示される各ページにフッターを追加します -->
<div id="footer">...footer block</div>

</body>
</html>