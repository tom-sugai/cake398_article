<!-- File: src/Template/Articles/add.ctp -->

<h1>記事の追加</h1>
<?php
    // 生成する HTML <form method="post" action="/articles/add">
    // URL オプションなしで create() を呼び出したので、フォームを現在のアクションに戻したいと仮定
    echo $this->Form->create($article);
    // control() は、指定されたモデルフィールドにもとづいて異なるフォーム要素を出力
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    // 今はユーザーを直接記述
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    // 仮想/計算フィールドを利用する
    // old  echo $this->Form->control('tags._ids',['options' => $tags]);
    echo $this->Form->control('tag_string', ['type' => 'text']);
    echo $this->Form->control('tags._ids',['options' => $tags]);
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>