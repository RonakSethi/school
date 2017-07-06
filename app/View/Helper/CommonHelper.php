<?php

/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class CommonHelper extends AppHelper {
    /* Format Date To Show IN View */

    public function formatDateForView($date) {
        $dateFormate = Configure::read('Site.defaultDateFormat');
        return date($dateFormate, strtotime($date));
    }

    /* Format Date Time To Show IN View */

    public function formatDateTimeForView($date) {
        $dateFormate = Configure::read('Site.defaultDateTimeFormat');
        return date($dateFormate, strtotime($date));
    }

    /* Format Date To SQL Format */

    public function sqlFormatDate($date) {
        $dateFormate = Configure::read('Site.defaultDateFormat');
        return date('Y-m-d', strtotime($date));
    }

    /* Format Value Of Field 'active' For View */

    public function getActiveInactiveValueForView($value) {
        if ($value == ACTIVE) {
            $viewValue = "<i class='fa fa-check-square' title='Active'></i>";
        } else {
            $viewValue = "<i class='fa fa-minus-square' title='Deactive'></i>";
        }
        return $viewValue;
    }

    /* Membership Period Options */

    public function getMembershipPeriodOptions() {
        $periodOptionArr = array();
        $periodOptionArr['F'] = "Free";
        $periodOptionArr['M'] = "Monthly";
        $periodOptionArr['Y'] = "Yearly";
        $periodOptionArr['L'] = "Life Time";
        return $periodOptionArr;
    }

    /* Exercise Sets */

    public function showMembershipPeriod($period) {
        $periodOptionArr = $this->getMembershipPeriodOptions();
        $periodName = $periodOptionArr[$period];
        return $periodName;
    }

    /* Show formated price */

    public function showPrice($priceValue) {
        $symbol = PriceFormatSymbol;
        $price = PriceFormatSymbol . " " . $priceValue;
        return $price;
    }

    /* User Role Options */

    public function getRoleOptions() {
        $roleOptionsArr = array();
        $roleOptionsArr[1] = "Adminstrator";
        $roleOptionsArr[2] = "Site User";
        return $roleOptionsArr;
    }

    /* Show Role of Users */

    public function showRole($role) {
        $roleOptionsArr = $this->getRoleOptions();
        $roleName = $roleOptionsArr[$role];
        return $roleName;
    }

    /* Function To Sub String Data With Provided Length */

    public function checkCharLimit($data, $len = 30) {
        if (strlen($data) > $len) {
            return substr($data, 0, $len) . '...';
        } else {
            return $data;
        }
    }
	
	public function sessionNoty() {
        $messages = $this->Session->read('Message');//pr($messages);die;
        if(!empty($messages)){
			$output = '';
			if( is_array($messages) ) {
				foreach(array_keys($messages) AS $key) {
					$output .= $this->Session->flash($key);
				}
			}
        
			$class=(isset($messages['flash']['params']['class']))?$messages['flash']['params']['class']:'error';
			$msg=(isset($messages['flash']['message']))?$messages['flash']['message']:$messages['auth']['message'];
			//return $output;
            echo '<script>
            $(function()
            {
            noty({text: "' . $msg . '" ,timeout:5000,type:"' . $class . '",killer: true});
            });
            </script>';
        }
	}
			
	function get_content($type) {
		$data = ClassRegistry::init("Content")->find('first', array('conditions' => array("Content.slug" => $type), 'fields' => array("Content.body")));
		return $data['Content']['body'];
	}
	
    function get_filter_data($id) {
              $this->Category=ClassRegistry::init('Category');
              $this->Category->recursive = 3;
            $categories = $this->Category->find('first', array('conditions' => array('Category.status' => 1, 'Category.id' => $id)));
            $temp = $subArr = $subArr2 = $subArr3 = $subArr4 = array();
            if (isset($categories['SubCategory']) && !empty($categories['SubCategory'])) {
                foreach ($categories['SubCategory'] as $category) {
                    $subArr = $subArr3 = $subArr4 = array();
                    if (!empty($category['SubCategory'])) {
                        foreach ($category['SubCategory'] as $value) {
                            $subArr4 == array();
                            $subArr4[$value['id']] = $value['name'];
                        }
                        $subArr2[$category['name']] = $subArr4;
                    }else{
                        $subArr2[$category['id']]=$category['name'];
                    }
                    
                }
            } 
            return $subArr2;
    }
	
	function checkSelected($businessID,$serviceID){
		$data = ClassRegistry::init('BusinessService')->find('first',array('conditions'=>array('BusinessService.business_id'=>$businessID,'BusinessService.service_id'=>$serviceID))); 
		
		if(!empty($data)){
			return true;
		}
		return false;
	}
	
	function checkFilledval($businessID,$serviceID){
		$data = ClassRegistry::init('BusinessService')->find('first',array('conditions'=>array('BusinessService.business_id'=>$businessID,'BusinessService.service_id'))); 
		
		$str = '';
		if(!empty($data)){
			$str = $data['BusinessService']['field_value'];
		}
		
		return $str;
	}
	
	function getAllCategory(){
		$data = ClassRegistry::init('Category')->find('all',array('fields'=>array('Category.id','Category.name'),'conditions'=>array('Category.status'=>1,'Category.is_services'=>0))); 
		
		return $data;
	}
	
	function getAllParent($id = 0, $recursive = 1){
		
		$data = ClassRegistry::init('Category')->find('first',array('fields'=> array('id','slug','parent_id','name'),'conditions'=> array('Category.id'=>$id ),'recursive'=>0 ) );
		
		$parentArr = array();
		if( count($data) > 0 ){
			$ids 		= $data['Category']['id'];
			$name 		= $data['Category']['name'];
			$parent_id 	= $data['Category']['parent_id'];
			
			$parentArr[] = $data['Category'];
			if($recursive!=0){
				$parentArr = array_merge($parentArr,$this->getAllParent($parent_id,1));
			}
			
		}
		return $parentArr;
	}
	
	function getCountItem($item_id = null ){
		$data = '0';
		if($item_id != null){
			$data = ClassRegistry::init('Item')->find('count',array('conditions'=>array('Item.category_id'=>$item_id))); 
		}
		return $data;
	}
	
	function getSchoolName($id = null){
		$data = ClassRegistry::init('User')->find('first',array('fields'=>array('User.id','User.first_name'),'conditions'=>array('User.id'=>$id))); 
		
		return $data['User']['first_name'];
	}
	function getSchoolNamebybus($id = null){
		$data = ClassRegistry::init('Bus')->find('first',array('fields'=>array('Bus.id','Bus.school_id'),'conditions'=>array('Bus.id'=>$id))); 
		$data = ClassRegistry::init('User')->find('first',array('fields'=>array('User.id','User.first_name','User.last_name'),'conditions'=>array('User.id'=>$data['Bus']['school_id']))); 
		
		return $data['User']['first_name'].' '.$data['User']['last_name'];
	}
	
	function getTripName($id = null){
		$data = ClassRegistry::init('Trip')->find('first',array('fields'=>array('Trip.id','Trip.title'),'conditions'=>array('Trip.id'=>$id))); 
		
		return $data['Trip']['title'];
	}
	function getBusData($id = null){
		$getlivedata = ClassRegistry::init('Bus')->query("SELECT * FROM `positions` where deviceid=".$id." order by id desc limit 1"); 
		
		return $getlivedata[0]['positions']['latitude'].','.$getlivedata[0]['positions']['longitude'];
	}
}

