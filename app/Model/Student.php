<?php

class Student extends AppModel {

    public $name = 'Student';
 
    public $validate = array(
        'bus_id' => array(
            'bus_id' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter bus number.',
            ),
        ),
		'name' => array(
            'name' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter name.',
            ),
        ),
		'mobile' => array(
            'mobile' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter mobile number.',
            ),
		'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Mobile number already in use.'
            ),
			
        )
		
    );
	
}
