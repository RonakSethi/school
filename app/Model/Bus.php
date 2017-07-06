<?php

class Bus extends AppModel {

    public $name = 'Bus';
 
    public $validate = array(
        'bus_number' => array(
            'bus_number' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter bus number.',
            ),
        ),
		'bus_number' => array(
            'bus_number' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter bus number.',
            ),
        ),
		 'iemi' => array(
            'iemi' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter iemi number.',
            ),
        ),
		 'driver_name' => array(
            'driver_name' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter Driver Name.',
            ),
        )
		
    );
	
}
