<?php
class Broadcast extends AppModel {

    public $name = 'Broadcast';
    
    
   

    public function beforeSave($options = array()) {
		
       
		if($this->data['Category']['parent_id']=='' && $this->params['action'] != 'status'){
			//$this->data['Category']['parent_id']=0;
		}
    }
    
    
}
