<?php
// src/Controller/ArticlesController.php

namespace App\Controller;
use Cake\Error\Debugger;
use Cake\Event\Event;
use Cake\ORM\Tableregistry;

class ArticlesController extends AppController
{
    //private $article;

    public $paginate = ['limit' => 10, 'order' => ['created' => 'ASC']
    
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('DataArray');
        $this->Auth->allow(['tags','list']);
    }

    public function beforeRender(Event $event)
    { }
    
    public function list() {
        $this ->autoLayout = false;
        $this->autoRender = false;
        //$this->viewBuilder()->setLayout('fmlayout-4');
         
        $articles = $this->paginate($this->Articles);
        //debug($articles);
        $this->set(compact('articles'));
        $this->set('count',$articles->count());
        
        // 単一の article を取得する
        $id = 99;
        $article = $this->Articles->get($id);
        //$article = $this->Articles->get($id,['contain' => 'Tags']);
        //echo $article->tags[0]->title . "<br/>";
        //echo $article->tags[1]->title . "<br/>";
        //debug($article);
        echo $article->title . "<br/>";
        echo "******" . "<br/>";

        $users = TableRegistry::getTableLocator()->get('Users');
        //$id = 5;
        //$user = $users->get($id);             // エンティティを返す
        //echo $user->email . "<br/>";
        //$query = $users->findById($id)->all();        // クエリーを返す
        //$data = $query->all();   // resultsetを返す
        //debug($data);
        //$user = $query->first();
        //debug($user);
        //echo $user->email . "<br/>";

        /**
        $query = $users->find('all');
        $results = $query->all();
        //debug($results);
        foreach($results as $row){
            //echo $row->email . "<br/>"; 
        }
        $data = $results->toList();
        //debug($data);
        echo $data[0]->email . "<br/>";
        echo $data[1]->email . "<br/>";
        echo $data[2]->email . "<br/>";

        $row = $query->first();
        //debug($row);
        echo "****" . $row->email;

        $query = $users->find('list', [
            keyField => 'id',
            valueField => 'email'
        ]);
        $data = $query->toArray();
        //debug($data);
        */

        //$query = $this->Articles->find('all');
        //$number = $query->count();
        //debug($number);
        //$query = $this->Articles->find('list');

        // contain を用いた関連データのイーガーロード
        /** 
        $query = $this->Articles->find('list', [
            'keyField' => 'title',
            'valueField' => 'user.email'
        ])->contain(['Users']);
        $data = $query->toArray();
        //$data = $query->toList();
        debug($data);
        */
  
        //$users = TableRegistry::getTableLocator()->get('Users');
        //$query = $users->findByEmail('tom.sugai@gmail.com');
        //$user = $users->get(6);
        //debug($user);
        //echo $user->email . "<br>";
        
        //$results = $query->all();
        //debug($results);
        //foreach($results as $key => $article){
            //echo "key : $key" . ":"  . $article->id . ":" . $article->title . "<br/>";
        //}
        //$data = $results-> toList();
        //$data = $results-> toArray();
        //debug($data);
        //foreach($data as $key => $article){
            //echo "$key" . ":"  . $article->id . ":" . $article->title . "<br/>";
        //}
        
        // contain に条件を渡す
        $query = $this->Articles->find();
        $query->contain('Users', function (Query $q) {
            return $q
                ->select(['title', 'user_id'])
                ->where(['Users.email' => 'tom.sugai@gmail.com']);
        });
        $results = $query->all();
        debug($results);

        /**
        $query = $this->Articles->find()
            ->select(['id', 'title'])
            ->select($this->Articles->Users)
            ->contain(['Users']);
        debug($query->all());

        $query = $this->Articles->findByUser_id('9');
        echo "query sucsess";
        $results = $query->all();
        $data = $results->toList();
        debug($data);

        $query = $users->find('all',['contain' => 'Articles']);
        $results = $query->all();
        debug($results);
        */
        /**
        // matching と joins を用いた関連データによるフィルタリング
        $query = $this->Articles->find();
        $query->matching('Tags', function ($q) {
            return $q->where(['Tags.title' => 'bare']);
        });
        $results = $query->all();
        debug($results);
        */
    }

    public function index() {
        $this->autoRender = true;
        $articles = $this->paginate($this->Articles);
        //debug($articles);
        $this->set(compact('articles'));
        $this->set('loginname', $this->Auth->user('email'));
        //$this->Flash->set('flash test');

    }

    // 既存の src/Controller/ArticlesController.php ファイルに追加

    public function view($slug = null)
    {
        //Debugger::dump($slug);
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        $this->set(compact('article'));
        $uid = $article->user_id;
        /** 
        debug($uid);
        $user = $this->Users->findById($uid)->firstOrFail();
        $author = $user->email;
        debug($author);
        */
    }

    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData(),['validate' => true]);
            // user_id の決め打ちは一時的なもので、あとで認証を構築する際に削除されます。
            //$article->user_id = 1;
         
            // 変更: セッションから user_id をセット
            $article->user_id = $this->Auth->user('id');
            // save process
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }

        // タグのリストを取得
        $tags = $this->Articles->Tags->find('list');
        //debug($tags);
        // ビューコンテキストに tags をセット
        $this->set('tags', $tags);

        $this->set('article', $article);
    }

    public function edit($slug)
    {
        $article = $this->Articles
            ->findBySlug($slug)
            ->contain('Tags') // 関連づけられた Tags を読み込む
            ->firstOrFail();
        //debug($article);
        if ($this->request->is(['post', 'put'])) {
            //$this->Articles->patchEntity($article, $this->request->getData());
            //$this->Articles->patchEntity($article, $this->request->getData(),['validate' => true]);
            $this->Articles->patchEntity($article, $this->request->getData(),[
                // 追加: user_id の更新を無効化
                'accessibleFields' => ['user_id' => false],'validate' => true
            ]);

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }
    
        // タグのリストを取得
        $tags = $this->Articles->Tags->find('list');
        //debug($tags);

        // ビューコンテキストに tags をセット
        $this->set('tags', $tags);
    
        $this->set('article', $article);
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} article has been deleted.', $article->title));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function tags()
    {
    // 'pass' キーは CakePHP によって提供され、リクエストに渡された
    // 全ての URL パスセグメントを含みます。
    $tags = $this->request->getParam('pass');
    //debug($tags);

    // ArticlesTable を使用してタグ付きの記事を検索します。
    $articles = $this->Articles->find('tagged', [
        'tags' => $tags
    ]);

    // 変数をビューテンプレートのコンテキストに渡します。
    $this->set([
        'articles' => $articles,
        'tags' => $tags
    ]);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // add および tags アクションは、常にログインしているユーザーに許可されます。
        if (in_array($action, ['add', 'tags'])) {
            return true;
        }

        // 他のすべてのアクションにはスラッグが必要です。
        $slug = $this->request->getParam('pass.0');
        if (!$slug) {
            return false;
        }

        // 記事が現在のユーザーに属していることを確認します。
        $article = $this->Articles->findBySlug($slug)->first();

        return $article->user_id === $user['id'];
    }
}
?>