<?php
App::uses('Sanitize', 'Utility');
class RoutesController extends AppController {

    public $name = 'Routes';
    public $uses = array('Bus','User','Route','Trip');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Cookie', 'Email');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('admin_login');
    }

    
    public function admin_index($parent_id=null) {
        $leftnav = "routes";
        $subleftnav = "view_route";
        $pageTitle = "Bus Stops";
        $this->set(compact('leftnav', 'subleftnav','pageTitle'));
    
		$this->set('pageHeading','Bus Stops');
         if($this->Session->read('Auth.User.role_id')==1)
		{
			if(!empty($parent_id) && empty($this->params->query['bus_id']))
			{
				$this->params->query['bus_id'] = $parent_id;
				$catList = $this->Trip->find('list',array('conditions'=>array('Trip.id'=>$parent_id),'fields'=>array('Trip.id','Trip.title')));
				$allcatList = $this->Trip->find('all',array('conditions'=>array('Trip.id'=>$parent_id),'fields'=>array('Trip.id','Trip.title')));
			}
			else
			{
				$catList = $this->Trip->find('list',array('conditions'=>array('Trip.status >'=>0),'fields'=>array('Trip.id','Trip.title')));
				$allcatList = $this->Trip->find('all',array('conditions'=>array('Trip.status >'=>0),'fields'=>array('Trip.id','Trip.title')));
			}
		}
		else
		{
			if(!empty($parent_id) && empty($this->params->query['bus_id']))
			{
				$this->params->query['bus_id'] = $parent_id;
				$catList = $this->Trip->find('list',array('conditions'=>array('Trip.id'=>$parent_id),'fields'=>array('Trip.id','Trip.title')));
				$allcatList = $this->Trip->find('all',array('conditions'=>array('Trip.id'=>$parent_id),'fields'=>array('Trip.id','Trip.title')));
			}
			else
			{
				$catList = $this->Trip->find('list',array('conditions'=>array('Trip.status >'=>0),'fields'=>array('Trip.id','Trip.title')));
				$allcatList = $this->Trip->find('all',array('conditions'=>array('Trip.status >'=>0),'fields'=>array('Trip.id','Trip.title')));
			}

		}
		$allbusids=array();;
		foreach($allcatList as $catList_1)
		{
			$allbusids[]=$catList_1['Trip']['id'];
		}
		$allbusesofuser=implode(',',$allbusids);
		
		$this->set('catList',$catList);
		
		$field= array('Trip.title');
		
		$this->Route->bindModel(array('belongsTo' => array('Trip'=>array('className'=>'Trip', 'foreignKey' => false,'conditions' => array('Trip.id = Route.bus_id'),'fields'=>$field))));
		
		if($this->Session->read('Auth.User.role_id')==1)
		{
	   	 	$condition=array('Route.id >'=>0);
		}
		else
		{
			$condition=array('Route.bus_id IN ( '.$allbusesofuser.' )');
		}
	    if(!empty($this->params->query['title']))
		{
			$name = Sanitize::clean($this->params->query['title'], array('encode' => false));
			$condition['OR']=array('Route.title like "%'.$name.'%"');
			$this->request->data['search'] = $this->request->query;
        }
		
		if(!empty($this->params->query['bus_id']))
		{
			$parent_id = Sanitize::clean($this->params->query['bus_id'], array('encode' => false));
			$condition['OR']=array('Route.bus_id'=>$parent_id);
			$this->request->data['search'] = $this->request->query;
        }
		
		if(!empty($this->params->query['bus_id']) && !empty($this->params->query['title']))
		{
			$parent_id = Sanitize::clean($this->params->query['bus_id'], array('encode' => false));
			$condition['AND']=array('Route.bus_id'=>$parent_id,'Route.title like "%'.$name.'%"');
			$this->request->data['search'] = $this->request->query;
        }
 
        $this->paginate=array('conditions'=>$condition, 'order' => 'Route.oid asc','limit'=>10);
        $category = $this->paginate('Route');
         $this->set('categories', $category);
		 $this->set('parent_id', $parent_id);
     }
	
	
	 public function admin_add() {
        
        $leftnav = "route";
        $subleftnav = "add";
        $title_for_layout = $pageTitle = "Add Bus Stop";
        $this->set(compact('leftnav', 'subleftnav','pageTitle','title_for_layout'));
        $this->set('pageHeading','Add Bus Stop');
         if($this->Session->read('Auth.User.role_id')==1)
		{
		$catList = $this->Trip->find('list',array('conditions'=>array('Trip.status >'=>0),'fields'=>array('Trip.id','Trip.title')));
		}
		else
		{
		$catList = $this->Trip->find('list',array('conditions'=>array('Trip.status >'=>0),'fields'=>array('Trip.id','Trip.title')));
		}
		$this->set('catList',$catList);
		if ($this->request->is('post') || $this->request->is('put')) {
            try {
                 
				 $this->request->data['Route']['name']=$_REQUEST['name'];
				 $this->request->data['Route']['lat']=$_REQUEST['lat'];
				 $this->request->data['Route']['lng']=$_REQUEST['lng'];
				 $this->request->data['Route']['location']=$_REQUEST['location'];
				 $this->request->data['Route']['formatted_address']=$_REQUEST['formatted_address'];
				 $this->request->data['Route']['country_short']=$_REQUEST['country_short'];
				 $this->request->data['Route']['postal_code']=$_REQUEST['postal_code'];
				 $this->request->data['Route']['locality']=$_REQUEST['locality'];
				 $this->request->data['Route']['country']=$_REQUEST['country'];
				 $this->request->data['Route']['administrative_area_level_1']=$_REQUEST['administrative_area_level_1'];
 				
				 if ($this->Route->save($this->request->data)) {
                    $this->Session->write('msg_type', 'alert-success');
                    $this->Session->setFlash(__('Trip added successfully'));
                    $this->redirect(array('controller' => 'routes', 'action' => 'index/'.$this->request->data['Route']['bus_id']));
                } else {
                    $msg = "";
                    foreach ($this->Route->validationErrors as $value) {
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
        $leftnav = "route";
        $subleftnav = "view_route";	
		$pageTitle = "Edit Bus Stop";
        $this->set(compact('leftnav', 'subleftnav','pageTitle'));
		$this->set('pageHeading','Edit Bus Stop');
 		
 		if($this->Session->read('Auth.User.role_id')==1)
		{
		$catList = $this->Trip->find('list',array('conditions'=>array('Trip.status >'=>0),'fields'=>array('Trip.id','Trip.title')));
		}
		else
		{
		$catList = $this->Trip->find('list',array('conditions'=>array('Trip.status >'=>0),'fields'=>array('Trip.id','Trip.title')));
		}
		 $this->set('catList',$catList);
 		 
        if (empty($id) && empty($this->request->data)) {
            $this->Session->write('msg_type', 'alert-danger');
            $this->Session->setFlash(__('INVALID_USER'));
            $this->redirect(array('controller' => 'routes', 'action' => 'index'));
        }

        try {
            if ($this->request->is('post') || $this->request->is('put')) {
                
				 $this->request->data['Route']['name']=$_REQUEST['name'];
				 $this->request->data['Route']['lat']=$_REQUEST['lat'];
				 $this->request->data['Route']['lng']=$_REQUEST['lng'];
				 $this->request->data['Route']['location']=$_REQUEST['location'];
				 $this->request->data['Route']['formatted_address']=$_REQUEST['formatted_address'];
				 $this->request->data['Route']['country_short']=$_REQUEST['country_short'];
				 $this->request->data['Route']['postal_code']=$_REQUEST['postal_code'];
				 $this->request->data['Route']['locality']=$_REQUEST['locality'];
				 $this->request->data['Route']['country']=$_REQUEST['country'];
				 $this->request->data['Route']['administrative_area_level_1']=$_REQUEST['administrative_area_level_1'];
				 
				if ($this->Route->save($this->request->data)) {
                    $this->Session->write('msg_type', 'alert-success');
                    $this->Session->setFlash(__('Trip updated successfully'));
                    $this->redirect(array('controller' => 'routes', 'action' => 'index/'.$this->request->data['Route']['bus_id']));
                } else {
                    $msg = "";
                    foreach ($this->Route->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__($msg));
                }
            } else {
                $this->Route->id = $id;
                if (!$this->Route->exists()) {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('INVALID_CATEGORY'));
                    $this->redirect(array('controller' => 'routes', 'action' => 'index/'.$this->request->data['Route']['bus_id']));
                }
                $this->request->data = $this->Route->read(null, $id);
					
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
				$AllcatList = $this->Bus->find('all',array('conditions'=>array('Bus.status >'=>0,'Bus.school_id'=>$this->Session->read('Auth.User.id')),'fields'=>array('Bus.id','Bus.bus_number')));
				
				$allbusids=array();;
				foreach($AllcatList as $catList_1)
				{
					$allbusids[]=$catList_1['Bus']['id'];
				}
				$allbusesofuser=implode(',',$allbusids);
				
				$GetMyRoutes = $this->Route->find('count',array('conditions'=>array('Route.id'=>$id,'Route.bus_id IN ( '.$allbusesofuser.' )'),'fields'=>array('Route.id')));
				if($GetMyRoutes>0)
				{
					$this->Route->delete($id);
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
            	$this->Route->delete($id);
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
