<?php

class Trip extends AppModel {

    public $name = 'Trip';
 
    public $validate = array(
        'title' => array(
            'title' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter route name.',
            ),
        )
    );
	
}
