<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
// use 文を名前空間宣言のすぐ下に追加
// Text クラス
use Cake\Utility\Text;
// Query クラスをインポートします
use Cake\ORM\Query;
// Validator クラスをインポートします。
use Cake\Validation\Validator;
// Collection クラスをインポートします
use Cake\Collection\Collection;


class CommentsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsTo('Articles'); // Articles テーブルの参照
        //$this->belongsTo('Users'); // Users テーブルの参照
    }
}

?>