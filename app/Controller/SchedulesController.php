<?php
App::uses('Sanitize', 'Utility');
class SchedulesController extends AppController {

    public $name = 'Schedules';
    public $uses = array('Schedules');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Cookie', 'Email');

    public function beforeFilter() {
        parent::beforeFilter();
		$this->Auth->allow('cronset');
    }

    public function admin_index() {
		if($this->request->data){
			//pr($this->request->data);die;
			$this->request->data['Schedules']['date'] = date('Y-m-d:H:i:s');
			if ($this->Schedules->save($this->request->data)) {
				    $this->Session->write('msg_type', 'alert-success');
                    $this->Session->setFlash(__('Schedules Saved successfully'));
                    $this->redirect(array('controller' => 'schedules', 'action' => 'index'));
                } 
		}
        $leftnav = "schedulesettings";
        $subleftnav = "index";
        $this->set(compact('leftnav', 'subleftnav'));
		$this->set('pageHeading','Schedule Manager');
		
    }
	
	public function admin_cronset(){
		$this->loadModel('User');
		$this->loadModel('Schedules');
		$current_date = date('Y-m-d');
		$fetchdays = $this->Schedules->find('all');
		$currentDay = strtolower(date('l'));
		foreach($fetchdays as $dayData){
			if($currentDay == $dayData['Schedules'][$currentDay]){
				
				$users = $this->User->find('all',array('fields' => array('User.email'),'conditions'=>array('User.role_id'=>2)));
				$header='form : mymeetingdesk@gmail.com';
				$subject = "This is a test email";
				$body = "This is a test email for testing cron";
				foreach($users as $key => $list){
					$list = $list['User']['email'];
					mail($list,$subject,$body,$header);
				} 
					$this->Session->write('msg_type', 'alert-success');
					$this->Session->setFlash(__('Cron run successfully'));
					$this->redirect(array('controller' => 'schedules', 'action' => 'index'));
			}
		}
	}
    
     
    
	
	
	
    
}
