<h1><?= $msg; ?></h1>
<!-- <h2><?= "from DB 'cake_cms' 'Articles' table ----" . "<br/>" ?></h2>; -->
<h2><?= "from DB 'sampledb' 'posts' table ----" . "<br/>" ?></h2>
<?php
    //debug($results); // クエリー結果の確認

    // 1行読み込んだ場合
    /** 
    echo $results['id'] . "<br/>";
    echo $results['title'] . "<br/>";
    echo $results['body'] . "<br/>";
    echo $results['created'] . "<br/>";
    echo $results['modified'] . "<br/>";
    echo $results['user_id'] . "<br/>";
    */

    // 全行読み込んだ場合 
    $i = 0;
    foreach ($results as $row) {
        //debug($row);
        //echo $i . " : " . $row->title . "<br/>"; //$row->title　はエラー
        echo $i . " : " . $row['title'] . "<br/>";
        $i += 1;
    }
?>
<?= "rowCount : $rowCount" . "<br/>"; ?>
<?= "code : $code" . "<br/>"; ?> 
<?= "info : $info[0]" . "<br/>"; ?> 