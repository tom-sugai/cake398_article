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


class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Tags'); // 記事へのタグ付けの追加
        $this->belongsTo('Users'); // ユーザテーブルの参照
        $this->hasMany('Comments', ['foreignKey' => 'article_id',]); // コメントテーブルの参照
    }

    // シンプルなスラグ生成の追加のために次のメソッドを追加してください。
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->tag_string) {
            $entity->tags = $this->_buildTags($entity->tag_string);
        }
    
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);
            // スラグをスキーマで定義されている最大長に調整
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }

    protected function _buildTags($tagString)
    {
        // タグをトリミング
        $newTags = array_map('trim', explode(',', $tagString));
        // 全ての空のタグを削除
        $newTags = array_filter($newTags);
        // 重複するタグの削減
        $newTags = array_unique($newTags);

        $out = [];
        $query = $this->Tags->find()
            ->where(['Tags.title IN' => $newTags]);

        // 新しいタグのリストから既存のタグを削除。
        foreach ($query->extract('title') as $existing) {
            $index = array_search($existing, $newTags);
            if ($index !== false) {
                unset($newTags[$index]);
            }
        }
        // 既存のタグを追加。
        foreach ($query as $tag) {
            $out[] = $tag;
        }
        // 新しいタグを追加。
        foreach ($newTags as $tag) {
            $out[] = $this->Tags->newEntity(['title' => $tag]);
        }
        return $out;
    }

    // Articles の検証ルールの更新---次のメソッドを追加してください。
    
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmptyString('title', false)
            ->minLength('title', 6)
            ->maxLength('title', 255)

            ->allowEmptyString('body', false)
            ->minLength('body', 6);

        return $validator;
    }
    
    
    // $query 引数はクエリービルダーのインスタンスです。
    // $options 配列には、コントローラーのアクションで find('tagged') に渡した
    // "tags" オプションが含まれています。
    public function findTagged(Query $query, array $options)
    {
        $columns = [
            'Articles.id', 'Articles.user_id', 'Articles.title',
            'Articles.body', 'Articles.published', 'Articles.created',
            'Articles.slug',
        ];

        $query = $query
            ->select($columns)
            ->distinct($columns);

        if (empty($options['tags'])) {
            // タグが指定されていない場合は、タグのない記事を検索します。
            $query->leftJoinWith('Tags')
                ->where(['Tags.title IS' => null]);
        } else {
            // 提供されたタグが1つ以上ある記事を検索します。
            $query->innerJoinWith('Tags')
                ->where(['Tags.title IN' => $options['tags']]);
        }

        return $query->group(['Articles.id']);
    }

    public function findOwnedBy(Query $query, array $options)
    {
        //debug($options);
        $id = $options['id'];
        //debug($id);
        return $query->where(['user_id' => $id]);
    }

    
}
?>