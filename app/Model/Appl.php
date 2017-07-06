<?php


class Appl extends AppModel {

    public $name = 'Appl';
    //public $actsAs = array('Tree');
	public $useTable = 'apps';
	
	
	
	 public function identical($check) {
       if (isset($this->data['User']['password'])) {
            if ($this->data['User']['password'] == $check['confirm_password']) {
                return true;
            } else {
                return __('Confirm password did not match. Please, try again.');
            }
        }
        return true;
    }	
	
	
	
	
	
}