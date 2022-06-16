<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\Debugger;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Database\Schema\TableSchema;
use Cake\Database\Schema\Collection;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\CsrfComponent;

class ExcViewController extends AppController{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Security');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        //$this->loadComponent('Csrf');
        $this->Auth->allow(['tom','fumiko1','fumiko2','fumiko3','fumiko4','csrf','setCookie','getCookie']);
    }

    public function beforeFilter(Event $event)
    {
         //$this->Security->setConfig('unlockedActions', ['tom']);
         $this->Cookie->config('path', '/');
         //$this->eventManager()->off($this->Csrf);
    }

    public function afterFilter(Event $event)
    {
        parent::afterFilter($event);
        //debug($this->response);
    }

    public function setCookie() {
        if ($this->request->isPost()) {
            if (!empty($this->request->data['mycookie'])) {
                $val = $this->request->data['mycookie'];
                $this->Cookie->write('mykey',$val);
                $this->Flash->success('ok cookie');
            } else {
                $this->Flash->error('bad...');
            }
        } else {
            $this->Flash->info('please input form:');
        }    
    }

    public function getCookie() {
        $data = $this->Cookie->read('mykey');
        $this->set('data',$data);
    }

    public function csrf() {
        $token = $this->request->getParam('_csrfToken');
        debug($token);
        if ($this->request->isPost()){
            if (!empty($this->request->data['name']) && !empty($this->request->data['password'])){
                $this->Flash->success('OK');
            } else {
                $this->Flash->error('bad...');
            }
        } else {
            $this->Flash->info('please input form:');
        }
    }

    public function fumiko4() {
        $this ->autoLayout = true;
        $this->autoRender = true;

        $this->viewBuilder()->setLayout('fmlayout-4');
        $this->Flash->set('---- Flash test from /fumiko4() ----');
        $this->set('msg',"fumichan !!");  
    }

    public function fumiko3(){
        $this ->autoLayout = true;
        $this->autoRender = true;

        $this->viewBuilder()->setLayout('fmlayout-3');
        $this->Flash->set('---- Flash test from /fumiko3() ----');
        $this->set('msg',"fumichan !!"); 
        
    }

    public function fumiko2(){
        $this ->autoLayout = true;
        $this->autoRender = true;
        $this->viewBuilder()->setLayout('fmlayout-2');
        $this->Flash->set('---- Flash test from /fumiko2() ----');
        $this->set('msg',"fumichan !!");
    }

    public function fumiko1(){
        $this ->autoLayout = true;
        $this->autoRender = true;

        //$this->set('title', 'Layout Test');
        $this->viewBuilder()->setLayout('fmlayout-1');
        $msg = "fumichan";
        $this->set('msg',$msg);
        //$this->Flash->set('---- Flash test from /fumiko1()----');
        //$this->Flash->success('---- Flash success from /fumiko1()----');
        //$this->Flash->error('---- Flash error from /fumiko1()----');
        //$this->Flash->info('hello! message from info methode ......');
        $this->Flash->set('Flash test useing message key',
            [
            'element' => 'info',
            'key' => 'info'
            ]
        );
    }

    public function tom() {

        $this ->autoLayout = true;
        $this->autoRender = true;

        // リクエストから受けっとったデータを取り出す
        //$params = $this->request->getAttribute('params');
        //debug($params);

        // クッキーの値、またはクッキーが存在しない場合 null を取得
        $rememberMe = $this->request->getCookie('CAKEPHP');
        //debug($rememberMe);
        // ハッシュとして全てのクッキーを取得
        $cookies = $this->request->getCookieParams();
        //debug($cookies);

        $accepts = $this->request->accepts();
        //debug($accepts);

        // 文字列としてヘッダーを取得
        $userAgent = $this->request->getHeaderLine('User-Agent');
        //debug($userAgent);

        $this->set('method',$this->request->getMethod());

        $this->set('domain', $this->request->domain());

        $isPost = $this->request->is('post');
        //debug($isPost);

        $env = $this->request->getServerParams();
        //debug($env);

        // ホストの取得
        $host = $this->request->env('HTTP_HOST');
        //debug($host);

        $params = $this->request->getData();
        //debug($params);

        //debug($this->response);

        // 渡された引数
        //$passedArgs = $this->request->getParam('pass');
        //debug($passedArgs);

        //　取り出したデータをテンプレートに渡す（ $tiis->set(.....) ）
        $this->set('params', $params);

    }

    public function index(){

        $this ->autoLayout = true;
        $this->autoRender = true;

        /** 
        $userAgent = $this->request->getHeaderLine('User-Agent');
        debug($userAgent);
        $acceptHeader = $this->request->getHeader('Accept');
        debug($acceptHeader);
        */

        $this->Flash->set('---- Flash test from /index() ----');
        $this->set('msg', '---- /index() ----');
  
    }
}
?>