<!-- File: src/Template/Articles/edit.ctp -->

<h1>記事の編集</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('user_id', ['type' => 'hidden']);
    //echo $this->Form->control('user_id');
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    // 仮想/計算フィールド 'tag_string' を利用して現在のタグを表示する
    echo $this->Form->control('tag_string', ['type' => 'text']);
    // tagsテーブルからタグ一覧の選択リストを表示する
    echo $this->Form->control('tags._ids',['options' => $tags]); 
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>