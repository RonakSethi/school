<?php
App::uses('AppController', 'Controller');
class PagesController extends AppController {
	public $uses = array('Content');

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('landing');
    }
	
	public function landing() {
		$this->layout = 'default' ;
			
	}
	public function admin_index() {
	$leftnav = "static";
	$pageTitle = "Static Pages";
       	
        $staticContent =$this->Content->find('all',array('conditions'=>array('status'=>1)));
	 $this->set(compact('leftnav','pageTitle','staticContent'));
	}
	public function admin_edit($id = null) {
	$title_for_layout = 'Edit Content';	
	$this->set('title_for_layout',$title_for_layout);
        
        
        if (empty($id) && empty($this->request->data)) {
            $this->Session->setFlash('invalid content','error');
            $this->redirect(array('controller' => 'pages', 'action' => 'index'));
        }

            if ($this->request->is('post') || $this->request->is('put')) {
              
                if ($this->Content->save($this->request->data)) {
                   $this->Session->setFlash('Content update successfully', 'success');
                    $this->redirect(array('controller' => 'pages', 'action' => 'index'));
                } else {
                    $msg = "";
                    foreach ($this->Content->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__($msg));
                }
            } else {
                $this->Content->id = $id;
                $this->request->data = $this->Content->read(null, $id);
              
              
            }
	}
}
