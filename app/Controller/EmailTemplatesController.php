<?php

class EmailTemplatesController extends AppController {

    public $name = 'EmailTemplates';
    public $uses = array('EmailTemplate');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display');
    }

    public function admin_index($status = null) {
        $this->layout = 'admin';
        $condition = array();
        $separator = array();
        $leftnav = "email_templates";
        $subleftnav = "view_emails";
        $this->set(compact('leftnav', 'subleftnav'));
        $this->set('title_for_layout', 'Email Templates');
        if (!empty($this->request->data)) {

            if (isset($this->request->data['EmailTemplate']['keyword']) && $this->request->data['EmailTemplate']['keyword'] != '') {
                $keyword = trim($this->data['EmailTemplate']['keyword']);
            }
        } elseif (!empty($this->request->params)) {

            if (isset($this->request->params['named']['keyword']) && $this->params['named']['keyword'] != '') {
                $keyword = trim($this->request->params['named']['keyword']);
                $this->request->data['EmailTemplate']['keyword'] = $keyword;
            }

            if (isset($this->request->params['named']['sort']) && $this->params['named']['sort'] != '') {
                $this->Session->write('email_template_list.sort', $this->request->params['named']['sort']);
            }

            if (isset($this->request->params['named']['direction']) && $this->params['named']['direction'] != '') {
                $this->Session->write('email_template_list.direction', $this->request->params['named']['direction']);
            }
        }




        $emails = $this->EmailTemplate->find('all');
        $this->set('templates', $emails);
    }

    public function admin_edit_templates($id = null) {

        $this->layout = 'admin';
        $msgString = "";

        $leftnav = "email_templates";
        $subleftnav = "edit";
        $this->set(compact('leftnav', 'subleftnav'));

        $this->set('title_for_layout', 'Edit Email Templates');
        if (empty($id) && empty($this->request->data)) {
            $this->Session->write('msg_type', 'error');
            $this->Session->setFlash(__('Invalid Template'));
            $this->redirect(array('admin' => true, 'controller' => 'email_templates', 'action' => 'index'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

//			if(empty($this->request->data["EmailTemplate"]["sender_name"])){
//				$msgString .="Sender name is required field.<br>";
//			}
//			elseif(trim($this->request->data["EmailTemplate"]["sender_name"]) == "" && $this->request->data["EmailTemplate"]['email_type'] != 'share_via_email'){
//				$msgString .= "Please enter valid sender name.<br>";
//			}
//			if(empty($this->request->data["EmailTemplate"]["sender_email"])){
//				$msgString .="Sender email is required field.<br>";
//			}
//			elseif($this->Page->checkEmail($this->request->data["EmailTemplate"]["sender_email"]) == false && $this->request->data["EmailTemplate"]['email_type'] != 'share_via_email')
//			{
//				$msgString .="Please enter valid sender email.<br>";
//			}
//			if(empty($this->request->data["EmailTemplate"]["subject"])){
//				$msgString .="Subject is required field.<br>";
//			}
//			elseif(trim($this->request->data["EmailTemplate"]["subject"]) == "" ){
//				$msgString .= "Please enter valid subject.<br>";
//			}
//			if(empty($this->request->data["EmailTemplate"]["message"])){
//				$msgString .="Message is required field.<br>";
//			}
//			elseif(trim($this->request->data["EmailTemplate"]["message"]) == "" ){
//				$msgString .= "Please enter valid message.<br>";
//			}

            if (isset($msgString) && $msgString != '') {
                $this->Session->write('msg_type', 'error');
                $this->Session->setFlash($msgString);
            } else {
                $html = $this->request->data['EmailTemplate']['message'];
                $html = preg_replace('/\&nbsp\;/', '', $html);
                $this->request->data['EmailTemplate']['message'] = $html;
                if ($this->EmailTemplate->save($this->request->data)) {
                    $this->Session->write('msg_type', 'confirm');
                    $this->Session->setFlash(__('The email template has been saved'));
                    $this->redirect(array('admin' => true, 'controller' => 'email_templates', 'action' => 'index'));
                }
            }
        } else {

            $this->EmailTemplate->id = $id;

            if (!$this->EmailTemplate->exists()) {
                $this->Session->write('msg_type', 'error');
                $this->Session->setFlash(__('Invalid Template'));
                $this->redirect(array('admin' => true, 'controller' => 'email_templates', 'action' => 'index'));
            }

            $this->request->data = $this->EmailTemplate->read(null, $id);
        }
    }

}
