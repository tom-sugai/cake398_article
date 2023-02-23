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

class DataController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        //$this->loadComponent('Security');
        $this->loadComponent('Flash');
        //$this->loadComponent('Cookie');
        //$this->loadComponent('Csrf');
        $this->Auth->allow(['index', 'data']);
    }

    public function beforeFilter(Event $event)
    {
        //$this->Security->setConfig('unlockedActions', ['tom']);
        //$this->Cookie->config('path', '/');
        //$this->eventManager()->off($this->Csrf);
         
        if($this->request->action == 'add'){
            //$this->getEventManager()->off($this->Csrf);
        }
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
        $this->set('ajax_name','send_data.js');
    }
}
?>