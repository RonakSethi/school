<?php

class User extends AppModel {

    // User Roles 1 -> Admin 1 -> Site User
    public $name = 'User';
    //public $virtualFields = array('full_name'=>"CONCAT(User.first_name, ' ', User.last_name)");
    public $validate = array(
        'name' => array(
            'name' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter full name.',
            ),
        ),
        
        'email' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter email address.',
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Please provide a valid email address.',
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Email address already in use.'
            ),
        )
    );

	function generatePassword($length = 8) {

        $password = "";
        $i = 0;
        $possible = "0123456789bcdfghjkmnpqrstvwxyz";

        while ($i < $length) {
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);

            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }

        return $password;
    }

}
