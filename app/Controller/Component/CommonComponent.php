<?php

/* Common function used very frequently */

class CommonComponent extends Component {
    /* Function to get all locations for drop down */

    public function locationDropDown($settings = NULL) {
        $locations = ClassRegistry::init('Location')->find('list', array('fields' => array('Location.id', 'Location.name'), 'conditions' => array('Location.status' => ACTIVE)));
        return $locations;
    }

    /* Function to get all templates for drop down */

    public function templatesDropDown($settings = NULL) {
        $templates = ClassRegistry::init('Template')->find('list', array('fields' => array('Template.id', 'Template.name'), 'conditions' => array('Template.status' => ACTIVE)));
        return $templates;
    }

    /* Index Of Weight For Complementary Exercises W.R.T Set */
    public function getSetWeightIndex($set) {
        $tempWeight = 'wt1';
        if ($set == 1) {
            $tempWeight = 'wt1';
        } elseif ($set == 2) {
            $tempWeight = 'wt2';
        } elseif ($set == 3) {
            $tempWeight = 'wt3';
        }
        return $tempWeight;
    }

    /* Index Of Repeations For Complementary Exercises W.R.T Set */
    public function getSetRepsIndex($set) {
        $tempReps = 'rep1';
        if ($set == 1) {
            $tempReps = 'rep1';
        } elseif ($set == 2) {
            $tempReps = 'rep2';
        } elseif ($set == 3) {
            $tempReps = 'rep3';
        }
        return $tempReps;
    }
    
    public function sqlDateFormat($date){
        return date('Y-m-d',  strtotime($date));
    }
    function get_category_with_child($id) {
        $this->Category=ClassRegistry::init('Category');
        $this->Category->recursive=3;
        $categories=$this->Category->find('first',array('conditions'=>array('Category.status'=>1,'Category.id'=>$id)));
        $temp=$subArr=$subArr2=$subArr3=$subArr4=array();       
        if(isset($categories['SubCategory']) && !empty($categories['SubCategory'])){
        foreach ($categories['SubCategory'] as $category) {
           $subArr=$subArr3=$subArr4=array();           
           if(!empty($category['SubCategory'])){
            foreach ($category['SubCategory'] as $value) {
                 $subArr4==array();                
                 $subArr4[$value['id']]=$value['name'];                 
            } 
            $subArr2[$category['name']]=$subArr4;
           }else{
             $subArr2[$category['id']]=$category['name'];  
           }
           
           
        }
        }
        return $subArr2;
    }
}

?>