<?php
namespace App\Controller;

use Cake\Error\Debugger;
use Cake\Event\Event;
use Cake\ORM\Tableregistry;
use Cake\Datasource\ConnectionManager;
use Cake\Database\Schema\TableSchema;
use Cake\Database\Schema\Collection;
use Cake\Routing\Router;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\CsrfComponent;

// exercise for ajax request => database write
class DataController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        //$this->loadComponent('Security');
        $this->loadComponent('Flash');
        //$this->loadComponent('Cookie');
        //$this->loadComponent('Csrf');
        $this->Auth->allow(['index', 'data','add']);
    }

    public function beforeFilter(Event $event)
    {
        //$this->Security->setConfig('unlockedActions', ['tom']);
        //$this->Cookie->config('path', '/');
        //$this->eventManager()->off($this->Csrf);
        /**
        if($this->request->action == 'add'){
            //$this->getEventManager()->off($this->Csrf);
        }
        */
    }

    public function afterFilter(Event $event)
    {
        parent::afterFilter($event);

    }

    public function add(){
        $data = $this->request->data('request');
        $connection = ConnectionManager::get('default');
        $connection->insert('data', [ 'text' => $data ]);
    }

    public function index(){
        $this ->autoLayout = false;
        $this->autoRender = true;
        //$this->viewBuilder()->setLayout('ajax');

        $params = $this->request->getAttribute('params');
        //debug($params);
        
        /** 
        $this->response->cors($this->request)
        ->allowOrigin(['*.localhost'])
        ->allowMethods(['GET', 'POST'])
        ->allowHeaders(['X-CSRF-Token'])
        ->allowCredentials()
        ->exposeHeaders(['Link'])
        ->maxAge(300)
        ->build();
        */

        $this->set('ajax_name','send_data.js');
    }
}
?>