<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

// exercise for Mobile check
class SampleController extends AppController {
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Security');
        $this->Auth->allow(['tom','conn','fumiko','fumiko2']);
    }

    public function beforeRender(Event $event)
    {       
        if ($this->request->isMobile()) {

            if ($this->request->isTablet()) {
                //debug("タブレットです");
                $this->viewBuilder()->setTheme('Tablet'); // ←これを追加
                //debug("PCです");
                //$this->viewBuilder()->setTheme('MyTheme'); // ←これを追加

            } else {
                // debug("スマホです");
                $this->viewBuilder()->setTheme('Mobile'); // ←これを追加
                //debug("PCです");
                //$this->viewBuilder()->setTheme('MyTheme'); // ←これを追加
            }

        } else {
            //debug("PCです");
            $this->viewBuilder()->setTheme('MyTheme'); // ←これを追加
        }
        
    } 
    
    public function index() {
        $this ->autoLayout = true;
        $this->autoRender = true;

        $msg = "Mobile check !!";
        $this->set('message',$msg);

    }
}
?>