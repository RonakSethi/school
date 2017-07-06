<?php
class Message extends AppModel {

    public $name = 'Message';
  
    public $validate = array(
        'title' => array(
            'title' => array(
                'rule' => 'notEmpty',
                'message' => 'Please Enter Title.',
            ),
        ),
		'message_body' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please Enter Description.',
			),
		),
		
    );
    
}
