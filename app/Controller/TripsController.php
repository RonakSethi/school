<?php
App::uses('Sanitize', 'Utility');
class TripsController extends AppController {

    public $name = 'Trips';
    public $uses = array('Bus','User','Route','Trip');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Cookie', 'Email');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('admin_login');
    }

    
    public function admin_index($parent_id=null) {
        $leftnav = "trips";
        $subleftnav = "view_route";
        $pageTitle = "Trips";
        $this->set(compact('leftnav', 'subleftnav','pageTitle'));
     	$condition=array('Trip.id >'=>0);
		 if(!empty($this->params->query['title']))
		{
			$name = Sanitize::clean($this->params->query['title'], array('encode' => false));
			$condition['AND']=array('Trip.title like "%'.$name.'%"');
			$this->request->data['search'] = $this->request->query;
        }
		
		$this->set('pageHeading','Routes');
        
        $this->paginate=array('conditions'=>$condition,'limit'=>10);
        $trips = $this->paginate('Trip');
        $this->set('categories', $trips);
     }
	
	
	 public function admin_add() {
        
        $leftnav = "trips";
        $subleftnav = "add";
        $pageTitle = "Add Trip";
        $this->set(compact('leftnav', 'subleftnav','pageTitle'));
        $this->set('pageHeading','Add Routes');
          
		if ($this->request->is('post') || $this->request->is('put')) {
            try {
                 
				 //$this->request->data['Trip']['title']=$_REQUEST['title'];
  				
				 if ($this->Trip->save($this->request->data)) {
                    $this->Session->write('msg_type', 'alert-success');
                    $this->Session->setFlash(__('Route added successfully'));
                    $this->redirect(array('controller' => 'trips', 'action' => 'index'));
                } else {
                    $msg = "";
                    foreach ($this->Trip->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__($msg));
                }
            } catch (Exception $e) {
                $this->log($e, "debug");
            }
        }
       
    }

    public function admin_edit($id = null) {
        $this->layout = 'admin';
        $leftnav = "trips";
        $subleftnav = "view_route";	
		$pageTitle = "Edit Trip";
        $this->set(compact('leftnav', 'subleftnav','pageTitle'));
		$this->set('pageHeading','Edit Routes');
  		 
        if (empty($id) && empty($this->request->data)) {
            $this->Session->write('msg_type', 'alert-danger');
            $this->Session->setFlash(__('INVALID_USER'));
            $this->redirect(array('controller' => 'trips', 'action' => 'index'));
        }

        try {
            if ($this->request->is('post') || $this->request->is('put')) {
                
				 //$this->request->data['Trip']['title']=$_REQUEST['title'];
				 
				 
				if ($this->Trip->save($this->request->data)) {
                    $this->Session->write('msg_type', 'alert-success');
                    $this->Session->setFlash(__('Route updated successfully'));
                    $this->redirect(array('controller' => 'trips', 'action' => 'index'));
                } else {
                    $msg = "";
                    foreach ($this->Trip->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__($msg));
                }
            } else {
                $this->Trip->id = $id;
                if (!$this->Trip->exists()) {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('INVALID_CATEGORY'));
                    $this->redirect(array('controller' => 'trips', 'action' => 'index'));
                }
                $this->request->data = $this->Trip->read(null, $id);
					
            }
        } catch (Exception $e) {
            $this->log($e, "debug");
        }
      
    }

    public function admin_delete($id = null) {
        $this->layout = false;
        try {
			
			if($this->Session->read('Auth.User.role_id')!=1)
			{
				
				$GetMyRoutes = $this->Trip->find('count',array('conditions'=>array('Trip.id'=>$id)));
				if($GetMyRoutes>0)
				{
					$this->Trip->delete($id);
					$this->Session->write('msg_type', 'alert-success');
            		$this->Session->setFlash(__('Route deleted successfully'));
				}
				else
				{
					$this->Session->write('msg_type', 'alert-danger');
            		$this->Session->setFlash(__('Route cannot be deleted.'));
				}
				
 			}
			else
			{
            	$this->Trip->delete($id);
				$this->Session->write('msg_type', 'alert-success');
            	$this->Session->setFlash(__('Route deleted successfully'));
			}
			
        } catch (Exception $e) { 
            $this->log($e, 'debug');
            $this->Session->write('msg_type', 'alert-danger');
            $this->Session->setFlash(__('DELETE_RECORD_EXCEPTION_MSG'));
        }
        $this->redirect(array('controller' => 'trips', 'action' => 'index'));
    }
	

}