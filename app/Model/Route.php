<?php

class Route extends AppModel {

    public $name = 'Route';
 
    public $validate = array(
        'bus_id' => array(
            'bus_id' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter bus number.',
            ),
        ),
		'title' => array(
            'title' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter stop name.',
            ),
        )
    );
	
}
