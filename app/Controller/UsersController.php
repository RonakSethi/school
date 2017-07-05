<?php

App::uses('Sanitize', 'Utility');

class UsersController extends AppController {

    public $name = 'Users';
    public $uses = array('User', 'EmailTemplate');
    public $helpers = array('Html', 'Form', 'Session', 'Common');
    public $components = array('Cookie', 'Email', 'Json', 'Upload');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('admin_login', 'admin_forgot', 'verify_email', 'admin_signup', 'admin_facebooklogin');
    }

    public function admin_login() {
        $title_for_layout = 'Login';

        $this->layout = 'admin_login';
        if ($this->Session->read('Auth.User')) {
            $this->redirect(array('controller' => 'products', 'action' => 'index'));
        }

        if ($this->request->is('post')) {

            $userData = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));

            if (count($userData) < 1) {
                $this->Session->setFlash(__('You are not authorusized'), 'error');
            } elseif ($userData['User']['role_id'] != 1 && $userData['User']['is_approved'] == 0) {

                $this->Session->setFlash(__('Your account is not approved by admin yet. '), 'warning');
            } else {

                if ($this->Auth->login()) {
                    if (isset($this->request->data['User']['remmber_me']) && $this->request->data['User']['remmber_me'] == 1) {
                        $this->Cookie->delete('Auth');
                        $cookie = array();
                        $cookie['username'] = $this->request->data['User']['email'];
                        $cookie['password'] = $this->request->data['User']['password'];
                        $this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
                        unset($this->request->data['User']['remember_me']);
                    } else {
                        $this->Cookie->delete('Auth');
                    }
                    $this->redirect(array('controller' => 'products', 'action' => 'index'));
                } else {
                    $this->Session->setFlash(__('Invalid username or password.'), 'error');
                }
            }
        }
        $cookie = $this->Cookie->read('Auth');
        if (!empty($cookie)) {
            $this->request->data['User']['email'] = $cookie['User']['username'];
            $this->request->data['User']['password'] = $cookie['User']['password'];
            $this->request->data['User']['remmber_me'] = 1;
        }

        $this->set(compact('title_for_layout'));
    }

    public function admin_logout() {
        $this->Session->setFlash('Logout Successfully.', 'success');
        $this->Auth->logout();
        $this->redirect(array('admin' => true, 'controller' => 'users', 'action' => 'login'));
    }

    public function admin_dashboard() {
        if ($this->Auth->User('role_id') != 1) {
            $this->redirect(array('controller' => 'products', 'action' => 'index'));
        }
        $leftnav = "dashboard";
        $title_for_layout = $pageTitle = "Dashboard";
        $totalStudiosOwner = $this->User->find('count', array('conditions' => array('role_id' => 2)));
        $totalCustomer = $this->User->find('count', array('conditions' => array('role_id' => 3)));
        $totalStudios = $this->Product->find('count');


        $this->set(compact('leftnav', 'pageTitle', 'title_for_layout', 'totalStudiosOwner', 'totalCustomer', 'totalStudios'));
    }

    public function admin_index() {
        $leftnav = "users";
        $subleftnav = "user-list";
        $pageTitle = $pageHeading = "Users";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'pageHeading'));
        $condition = array('User.role_id' => array('3', '4'));
        if (!empty($this->request->data)) {
            if (isset($this->request->data['User']['keyword']) && $this->request->data['User']['keyword'] != '') {
                $keyword = trim($this->data['User']['keyword']);
            }
            if (isset($keyword) && $keyword != '') {
                $condition[] = "(
					User.first_name like '%" . $keyword . "%' OR 
					User.last_name like '%" . $keyword . "%' OR 
					User.email like '%" . $keyword . "%'
				)";
            }
        }

        $this->paginate = array(
            'conditions' => $condition,
            'limit' => 10,
            'order' => 'User.id DESC',
        );

        $user = $this->paginate('User');
        $this->set('users', $user);
    }

    public function admin_schools() {
        $leftnav = "schools";
        $subleftnav = "schoolList";
        $pageTitle = $pageHeading = "Schools";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'pageHeading'));
        $condition = array('User.role_id' => array('2'));
        if (!empty($this->request->data)) {
            if (isset($this->request->data['User']['keyword']) && $this->request->data['User']['keyword'] != '') {
                $keyword = trim($this->data['User']['keyword']);
            }
            if (isset($keyword) && $keyword != '') {
                $condition[] = "(
					User.first_name like '%" . $keyword . "%' OR 
					User.last_name like '%" . $keyword . "%' OR 
					User.email like '%" . $keyword . "%'
				)";
            }
        }

        $this->paginate = array(
            'conditions' => $condition,
            'limit' => 10,
            'order' => 'User.id DESC',
        );

        $user = $this->paginate('User');
        $this->set('users', $user);
    }

    public function admin_parents() {
        $leftnav = "parents";
        $subleftnav = "parentsList";
        $pageTitle = $pageHeading = "Parents";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'pageHeading'));
        if($this->Auth->user('role_id') == 1){
         $condition = array('User.role_id' => array('3'));   
        }else{
            $condition = array('User.role_id' => array('3'),'school_id'=>$this->Auth->user('id'));
        }
        
        if (!empty($this->request->data)) {
            if (isset($this->request->data['User']['keyword']) && $this->request->data['User']['keyword'] != '') {
                $keyword = trim($this->data['User']['keyword']);
            }
            if (isset($keyword) && $keyword != '') {
                $condition[] = "(
					User.first_name like '%" . $keyword . "%' OR 
					User.last_name like '%" . $keyword . "%' OR 
					User.email like '%" . $keyword . "%'
				)";
            }
        }

        $this->paginate = array(
            'conditions' => $condition,
            'limit' => 10,
            'order' => 'User.id DESC',
        );

        $user = $this->paginate('User');
        $this->set('users', $user);
    }
    
     public function admin_add_parent() {
        $this->layout = 'admin';
         $leftnav = "parents";
        $subleftnav = "parentsList";
        $pageTitle = $title_for_layout = "Add Parent";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'title_for_layout'));
        $this->set('pageHeading', 'Add user');

        if ($this->request->is('post') || $this->request->is('put')) {
           
             $this->request->data['User']['school_id'] = $this->Auth->user('id');
            $this->request->data['User']['role_id'] = 3;
            $this->request->data['User']['parent_id'] = 0;
           
           
                    //pr($this->request->data); die;
             if ($this->User->save($this->request->data)) {
                  echo $this->User->lastQuery();
                    $this->Session->setFlash('Parent add successfully', 'success');
                    $this->redirect(array('controller' => 'users', 'action' => 'admin_parents'));
                } else {
                    $msg = "";
                    foreach ($this->User->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__($msg));
                }
        }
    }

    public function admin_students($parentId = null) {
        if (empty($parentId) && empty($this->request->data)) {
            $this->Session->setFlash('Invalid user', 'error');
            $this->redirect(array('controller' => 'users', 'action' => 'admin_parents'));
        }
        $leftnav = "students";
        $subleftnav = "studentList";
        $pageTitle = $pageHeading = "Students";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'pageHeading'));
        if($this->Auth->user('id') == 1){
            $condition = array('User.role_id' => array('4'));
        }else{
            $condition = array('User.role_id' => array('4'),'parent_id'=>$parentId);
        }
     
        if (!empty($this->request->data)) {
            if (isset($this->request->data['User']['keyword']) && $this->request->data['User']['keyword'] != '') {
                $keyword = trim($this->data['User']['keyword']);
            }
            if (isset($keyword) && $keyword != '') {
                $condition[] = "(
					User.first_name like '%" . $keyword . "%' OR 
					User.last_name like '%" . $keyword . "%' OR 
					User.email like '%" . $keyword . "%'
				)";
            }
        }

        $this->paginate = array(
            'conditions' => $condition,
            'limit' => 10,
            'order' => 'User.id DESC',
        );

        $user = $this->paginate('User');
        $this->set('users', $user);
    }
    
//    ADMIN ADD STUDENT
    
     public function admin_add_students() {
        $this->layout = 'admin';
         $leftnav = "parents";
        $subleftnav = "parentsList";
        $pageTitle = $title_for_layout = "Add Student";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'title_for_layout'));
        $this->set('pageHeading', 'Add user');

        if ($this->request->is('post') || $this->request->is('put')) {
           
             $this->request->data['User']['school_id'] = $this->Auth->user('id');
            $this->request->data['User']['role_id'] = 4;
        
                    //pr($this->request->data); die;
             if ($this->User->save($this->request->data)) {
                  echo $this->User->lastQuery();
                    $this->Session->setFlash('Student add successfully', 'success');
                    $this->redirect(array('controller' => 'users', 'action' => 'admin_students',$this->request->data['User']['parent_id']));
                } else {
                    $msg = "";
                    foreach ($this->User->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__($msg));
                }
        }
    }

    function admin_view($id = null) {
        $leftnav = "users";
        $subleftnav = "";
        $pageTitle = $pageHeading = 'View Users';
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'pageHeading'));
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->redirect(array('controller' => 'Users', 'action' => 'index'));
        }
        $UserData = $this->User->read(null, $id);
        $this->set(compact('UserData'));
    }

    public function admin_signup() {
        $this->layout = 'admin_login';
        $leftnav = "users";
        $subleftnav = "add";
        $pageTitle = $title_for_layout = "Add User";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'title_for_layout'));
        $this->set('pageHeading', 'Add user');

        if ($this->request->is('post') || $this->request->is('put')) {
            try {
                $this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
                $this->request->data['User']['status'] = 0;
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('SignUp successfully, Please wait for admin approval.', 'success');
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                } else {
                    $msg = "";
                    foreach ($this->User->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__($msg));
                }
            } catch (Exception $e) {
                $this->log($e, "debug");
            }
        }
    }

    public function admin_edit($id = null) {
        $this->layout = 'admin';
        $leftnav = "users";
        $subleftnav = "user-list";
        $pageTitle = $title_for_layout = "Edit User";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'title_for_layout'));

        if (empty($id) && empty($this->request->data)) {
            $this->Session->setFlash('Invalid user', 'error');
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }

        try {
            if ($this->request->is('post') || $this->request->is('put')) {
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('User update successfully', 'success');
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                } else {
                    $msg = "";
                    foreach ($this->User->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__($msg));
                }
            } else {
                $this->User->id = $id;
                if (!$this->User->exists()) {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('INVALID_USER'));
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                }
                $this->request->data = $this->User->read(null, $id);
                unset($this->request->data['User']['password']);
            }
        } catch (Exception $e) {
            $this->log($e, "debug");
        }
    }

    public function admin_studio_owner_edit($id = null) {
        $this->layout = 'admin';
        $leftnav = "users";
        $subleftnav = "user-list";
        $pageTitle = $title_for_layout = "Edit User";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'title_for_layout'));

        if (empty($id) && empty($this->request->data)) {
            $this->Session->setFlash('Invalid user', 'error');
            $this->redirect(array('controller' => 'users', 'action' => 'index'));
        }

        try {
            if ($this->request->is('post') || $this->request->is('put')) {
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash('User update successfully', 'success');
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                } else {
                    $msg = "";
                    foreach ($this->User->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $this->Session->setFlash($msg, 'error');
                }
            } else {
                $this->User->id = $id;
                if (!$this->User->exists()) {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('INVALID_USER'));
                    $this->redirect(array('controller' => 'users', 'action' => 'index'));
                }
                $this->request->data = $this->User->read(null, $id);
                unset($this->request->data['User']['password']);
            }
        } catch (Exception $e) {
            $this->log($e, "debug");
        }
    }

    public function admin_delete($id = null) {
        $this->layout = false;
        try {
            $this->User->delete($id);
            $this->Session->write('msg_type', 'alert-success');
            $this->Session->setFlash(__('User Deleted successfully'));
        } catch (Exception $e) {
            $this->log($e, 'debug');
            $this->Session->write('msg_type', 'alert-danger');
            $this->Session->setFlash(__('Error while deleting user'));
        }
        $this->redirect(array('controller' => 'users', 'action' => 'index'));
    }

    public function admin_forgot() {
        $this->layout = 'admin_login';
        $leftnav = "users";
        $pageTitle = "Forgot Password";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle'));

        if ($this->request->is('post') || $this->request->is('put')) {
            $email = $this->request->data['User']['email'];
            if (!empty($email)) {
                $email_template_detail = $this->EmailTemplate->find('first', array('conditions' => array('EmailTemplate.email_type ' => 'forgot_password')));

                $email_template = nl2br($email_template_detail['EmailTemplate']['message']);
                $sender_email = $email_template_detail['EmailTemplate']['sender_email'];
                $subject = $email_template_detail['EmailTemplate']['subject'];
                $sender_name = $email_template_detail['EmailTemplate']['sender_name'];

                $Userr = $this->User->find('first', array('conditions' => array('User.email' => $email)));
                if (!empty($Userr)) {
                    $newpassword = $this->__generatePassword();
                    //$Userr['User']['org_pass'] = $newpassword;
                    $Userr['User']['password'] = $this->Auth->password($newpassword);
                    $Userr['User']['id'];


                    $name = $Userr['User']['first_name'] . " " . $Userr['User']['last_name'];
                    $email = $Userr['User']['email'];
                    $pass = $newpassword;

                    $email_template = str_replace('[site_title]', Configure::read('Site.title'), $email_template);
                    $email_template = str_replace('[username]', $name, $email_template);
                    $email_template = str_replace('[email]', $email, $email_template);
                    $email_template = str_replace('[password]', $pass, $email_template);

                    try {
                        $this->sendEmail($this->request->data['User']['email'], $sender_email, $subject, 'common', $email_template);
                        if ($this->User->Save($Userr['User'])) {
                            $this->Session->setFlash(__('Please check your email for reset password.'), 'success');
                            $this->redirect(array('admin' => true, 'controller' => 'users', 'action' => 'login'));
                        } else {
                            $this->Session->setFlash(__('unable to send email'), 'error');
                            $this->redirect(array('admin' => true, 'controller' => 'users', 'action' => 'login'));
                        }
                    } catch (Exception $e) {
                        pr($e);
                    }
                } else {
                    $this->Session->setFlash(__('Invalid email.'));
                }
            } else {
                $this->Session->setFlash(__('Invalid email.'));
            }
        }
    }

    public function admin_setting() {

        $leftnav = "setting";
        $subleftnav = "setting";
        $title_for_layout = $pageTitle = "Change Password";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'title_for_layout'));

        $this->loadModel('Setting');
        $id = $this->Auth->user('id');

        if (!$id && empty($this->request->data)) {
            $this->Session->write('msg_type', 'alert-danger');
            $this->Session->setFlash(__('Invalid User'));
            $this->redirect(array('action' => 'setting'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            //validate data
            $this->User->set($this->request->data);
            if ($this->User->validates()) {

                if ($this->request->data['User']['password'] != $this->request->data['User']['re_password']) {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('Please enter confirm password'));
                    $this->redirect(array('action' => 'setting'));
                }

                $this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
                $this->request->data['User']['id'] = $this->Auth->user('id');
                if ($this->User->save($this->request->data)) {
                    $this->Session->write('msg_type', 'alert-success');
                    $this->Session->setFlash(__('Password has been reset.'));
                    $this->redirect(array('action' => 'setting'));
                } else {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('Password could not be reset. Please, try again.'));
                }
            }
        }

        if (empty($this->request->data)) {
            $this->request->data = $this->User->read(null, $id);
            $this->request->data['User']['password'] = '';
            $this->request->data['User']['old_image'] = $this->request->data['User']['image'];
        }
        //$this->set('settings', $this->Setting->find('all', array('conditions' => array('status' => 1))));
    }

    public function admin_setting_update() {
        $leftnav = "sitesettings";
        $subleftnav = "index";
        $this->loadModel('Setting');
        $this->set(compact('leftnav', 'subleftnav'));
        if ($this->request->is(array('post', 'put'))) {

            if ($this->Setting->saveAll($this->request->data['Setting'], array('validate' => false))) {
                $this->Setting->writeConfiguration();
                $this->Session->setFlash('Site Settings saved successfully.', 'default', array('class' => 'success'));
                $this->redirect(array('controller' => 'users', 'action' => 'setting'));
            } else {
                $this->Session->setFlash('Site Settings could not be saved. Please try again.', 'default', array('class' => 'error'));
                $this->redirect(array('controller' => 'users', 'action' => 'setting'));
            }
        } else {
            $this->Session->setFlash('Site Settings could not be saved. Please try again.', 'default', array('class' => 'error'));
            $this->redirect(array('controller' => 'users', 'action' => 'setting'));
        }
    }

    /* general settings */

    public function admin_general_settings() {
        $leftnav = "setting";
        $subleftnav = "view_user";

        $pageTitle = "Settings";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle'));
        $id = $this->Auth->user('id');
        $this->layout = 'admin';
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__('Invalid User'), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'setting'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            //validate data
            $this->User->set($this->request->data);
            if ($this->User->validates()) {

                $destination = realpath('../../app/webroot/uploads/user_pictures/') . '/';
                $file = $this->request->data['User']['image'];

                if ($file['name'] != "") {
                    $this->Upload->upload($file, $destination, null);
                    $errors = $this->Upload->errors;

                    if (empty($errors)) {
                        $this->request->data['User']['image'] = $this->Upload->result;
                        $this->Session->write('Auth.User.image', $this->request->data['User']['image']);
                    } else {
                        if (is_array($errors)) {
                            $errors = implode("<br />", $errors);
                        }

                        $this->Session->write('msg_type', 'alert-danger');
                        $this->Session->setFlash($errors);
                        return;
                    }

                    $destination = realpath('../../app/webroot/uploads/user_pictures/') . '/';
                    $userfile = $this->request->data['User']['old_image'];
                    if ($userfile != "") {
                        if (file_exists($destination . $userfile)) {
                            unlink($destination . $userfile);
                        }
                    }
                } else {
                    $this->request->data['User']['image'] = $this->request->data['User']['old_image'];
                }

                if ($this->User->save($this->request->data)) {
                    $this->Session->write('Auth.User.full_name', $this->request->data['User']['full_name']);
                    $this->Session->setFlash(__('General settings saved succesfully'), 'default', array('class' => 'success'));
                    $this->redirect(array('action' => 'setting'));
                }
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->User->read(null, $id);
        }
    }

    public function verify_email($code = '') {
        $this->layout = false;
        $leftnav = "users";
        $subleftnav = "add";
        $pageTitle = "Verify Email-Id";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle'));
        try {
            $users = $this->User->find('first', array('conditions' => array('User.verifiy_code' => $code, 'role_id' => 2), 'fields' => array('id')));
            if (count($users) > 0) {
                //$userid = $users['User']['id'];
                $users['User']['verifiy_code'] = "";
                $users['User']['email_verified'] = 1;
                //pr($users);
                if ($this->User->save($users)) {
                    $msg = "You have succesfully verified your account.";
                    //$this->Session->write('msg_type', 'alert-success');
                    //$this->Session->setFlash(__('USER_UPDATED'));
                    //$this->redirect(array('controller' => 'users', 'action' => 'index'));
                } else {
                    $msg = "";
                    foreach ($this->User->validationErrors as $value) {
                        $msg .=$value[0] . "<br/>";
                    }
                    $msg = "Something Error in your request.";
                }
            } else {
                $msg = "Your Code is not Corret Or already Expired.";
            }
        } catch (Exception $e) {
            $this->log($e, "debug");
        }
        $this->set('message', $msg);
    }

    public function admin_profile() {
        $leftnav = "";
        $subleftnav = "";
        $title_for_layout = $pageTitle = 'Profile';
        $pageHeading = 'Profile';
        $session_id = $this->Session->read('Auth.User.id');
        $data = $this->User->find('first', array('conditions' => array('User.id' => $session_id)));

        if (!empty($this->request->data)) {
            $this->User->id = $session_id;
            if ($this->User->save($this->request->data, false)) {
                $this->Session->write('msg_type', 'alert-success');
                $this->Session->setFlash('Profile updated successfully');
            }
        } else {
            $this->User->id = $session_id;
            $this->request->data = $this->User->read();
        }

        $this->set(compact('leftnav', 'subleftnav', 'pageTitle', 'pageHeading', 'data', 'title_for_layout'));
    }

    public function admin_upload_image() {
        if ($this->request->is('ajax')) {
            $session_id = $this->Session->read('Auth.User.id');
            $result['status'] = 0;
            $result['image'] = '';
            if (!empty($this->request->data['image'])) {
                $destination = realpath('../../app/webroot/uploads/users/');
                $file_name = $this->base64toimage($this->request->data['image'], $destination);
                if (!empty($file_name)) {
                    $this->User->id = $session_id;
                    $this->User->save(array('image' => $file_name), false);
                    $result['status'] = 1;
                    $result['image'] = WEBSITE_URL . 'uploads/users/' . $file_name;
                    if ($this->Session->check('Auth.User.image') && $this->Session->read('Auth.User.image') != '' && file_exists($destination . '/' . $this->Session->read('Auth.User.image'))) {
                        unlink($destination . '/' . $this->Session->read('Auth.User.image'));
                    }
                    $this->Session->write('Auth.User.image', $file_name);
                }
            }
            echo json_encode($result);
            die;
        }
    }

    public function base64toimage($imagecode, $destination) {
        // Image upload /
        if (strpos($imagecode, "png;base64,") != 0)
            $filename = md5(rand()) . ".png";
        else
            $filename = md5(rand()) . ".jpeg";

        $dirpath = $destination;
        $mainImgDirPath = $dirpath . DS . $filename;
        $data_new = $imagecode;
        $pos = strpos($data_new, "base64,");
        if (isset($pos) && $pos != "") {
            $img = substr($data_new, $pos + 7, strlen($data_new));
        } else {
            $img = $data_new;
        }
        $img = str_replace(' ', '+', $img);
        $svdata = base64_decode($img);

        $fp = fopen($mainImgDirPath, 'w');
        if (fwrite($fp, $svdata)) {
            fclose($fp);
        } else {
            $mainImgDirPath = '';
        }
        return $filename;
        // Image upload End /
    }

    public function verification($code = null) {
        if (!empty($code)) {
            $user_data = $this->User->find('first', array('conditions' => array('User.verification_code' => $code), 'fields' => array('User.id')));
            if (!empty($user_data)) {
                $data['User']['id'] = $user_data['User']['id'];
                $data['User']['status'] = 1;
                $data['User']['verification_code'] = '';

                if ($this->User->save($data)) {
                    $this->Session->setFlash(__('You are successfully verified you account, Please login'));
                    $this->redirect(array('admin' => true, 'controller' => 'users', 'action' => 'login'));
                }
            } else {
                $this->Session->setFlash(__('Invalid token'));
                $this->redirect(array('admin' => true, 'controller' => 'users', 'action' => 'login'));
            }
        }
    }

//Facebook login	
    function admin_facebooklogin() {
        if (!empty($_POST)) {

            $data = array();
            $this->autoRender = false;
            $data['email'] = $this->request->data['email'];
            $data['password'] = Security::hash(123456, null, true);
            $fbid = $this->request->data['facebook_id'];
            $user_details = $this->User->find('first', array('conditions' => array('OR' => array("User.facebook_id" => $fbid, "User.email" => $data['email']))));

            if (empty($user_details) && !empty($data['email'])) {
                $fb_img = "http://graph.facebook.com/" . $fbid . "/picture?type=large";
                $imagename = "fb_" . time() . "_image.jpg";
                @copy($fb_img, USER_IMAGE_PATH . $imagename);

                $data['User']['image'] = $imagename;
                $data['User']['facebook_id'] = $fbid;
                $data['User']['email'] = $data['email'];
                //$data['User']['password'] = $data['password'];
                $data['User']['status'] = 1;
                $data['User']['step'] = 1;
                $data['User']['fname'] = $this->request->data['first_name'];
                $data['User']['lname'] = $this->request->data['last_name'];
                $data['User']['role_id'] = 2;
                $data['User']['usertype'] = 'facebook';
                if ($this->request->data['gender'] == 'male') {
                    $data['User']['gender'] = "M";
                } else
                if ($this->request->data['gender'] == 'female') {
                    $data['User']['gender'] = "F";
                }
                $this->User->saveAll($data);
                $id = $this->User->getLastInsertId();
                $this->Session->setFlash('User registration successful.', 'success');
                $first_login = true;
                echo "first_login";
            } elseif ($user_details['User']['step'] == 1) {
                $first_login = false;
                echo "first_login";
            } else {
                $user_id = $this->User->find('first', array('conditions' => array('User.facebook_id' => $fbid)));
                if (!empty($user_id)) {
                    $data = array(
                        'id' => $user_id['User']['id'],
                        'email' => $user_id['User']['email'],
                        'password' => $data['password']
                    );
                } elseif (!empty($user_details)) {
                    $data = array(
                        'id' => $user_details['User']['id'],
                        'email' => $user_details['User']['email'],
                        'password' => $user_details['User']['password']
                    );
                }

                if (!empty($user_details)) {
                    $data = array(
                        'id' => $user_details['User']['id'],
                        'email' => $user_details['User']['email'],
                        'password' => $user_details['User']['password']
                    );
                    $this->Session->write('Auth.User', $data);
                    if ($this->Session->read('Auth.User.last_login') == '') {
                        $this->User->id = $this->Session->read('Auth.User.id');
                        $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                        if ($fbid) {
                            $this->User->saveField('facebook_id', $fbid);
                        }

                        $this->Session->write('first_login', true);

                        if ($first_login) {
                            echo 'first_login';
                        } else {
                            echo "User login successfully";
                        }
                    } else {
                        if ($first_login) {
                            echo 'first_login';
                        } else {
                            echo "User login successfully";
                        }
                    }

                    die;
                }
            }
        } else {
            echo 'Unauthorised access';
            die();
        }
    }

    public function admin_studio_listing() {
        $leftnav = "studio_owner";
        $subleftnav = "studio-admin-list";
        $pageTitle = "Studios";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle'));
        $this->set('pageHeading', 'Studios');
        $this->paginate = array('conditions' => array('Studio.is_deleted' => 0), 'limit' => 10);
        $studios = $this->paginate('Studio');
        $this->set('studios', $studios);
    }

}
