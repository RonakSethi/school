<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
        'Session',
		'Paginator',
		'RequestHandler',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email','password' => 'password'),
                    'scope' => array('User.status' => ACTIVE)
                )
            )
        )
    );
    public $uses = array('User');
    public $helpers = array('Form', 'Html', 'Js');
    public $recordPerPage = 10; 

    //public $uses = array('NotificationSetting', 'NotificationAlert');
    public function beforeRender()
    {
	   $this->set('site_url',  'http://' . $_SERVER['HTTP_HOST'] . '/jamspot/');
    }
    public function beforeFilter() {
        parent::beforeFilter();

		if($this->params['admin']){
			$this->layout = 'admin';
		}else{
			
		}

		//Layout for ajax call
		if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
        }
	}
     public  function delTree($dir) {
            $this->layout = false;
            $this->autoRender = false;
         if(is_dir($dir)){
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
         }
        return '';
    }
	
	function sendEmail($to, $from, $subject, $template, $message,$layout=null,$attachments = array()) {
        
        /* $this->Email->smtpOptions = array(
            'port'=>'587',  // 25
            'timeout'=>'30',
            'host' => 'smtp.mandrillapp.com',
            'username'=>'App Innovators',
            'password'=>'m7EcEOSoRHBIKgnrYFE2hA'  
        ); */

        $this->Email->delivery = 'smtp'; 
        $this->Email->to = $to;
        $this->Email->from = 'Fund Raiser Admin' . '<' . $from . '>';
        $this->Email->subject = $subject;
        $this->Email->sendAs = 'html';

        if($layout != null ){
            $this->Email->layout = $layout;
        }
        
        if($attachments){
            $this->Email->attachments = $attachments;
        }
        
        $this->Email->template = $template;
        $this->set('message', $message);
        
        try{
            $result = $this->Email->send();
            return $result;
        }catch(Exception $e){

        }   
        
    }
	
	function __generatePassword($length = 8) {
        // initialize variables
        $password = "";
        $i = 0;
		$possible = "123456789abcdfghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ";
        // add random characters to $password until $length is reached
        while ($i < $length) {
            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);

            // we don't want this character if it's already in the password
            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }
        return $password;
    }
}
