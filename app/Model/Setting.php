<?php
App::uses('AppModel', 'Model');
/**
 @Setting Model
 */
class Setting extends AppModel {

    public $validate = array(
		'category' => array(
				'rule' => array('notEmpty'),
				'required'=>true,
				'message'=> 'This field is required.'
		),
		'key' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'required'=>true,
				'message'=> 'This field is required.'
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'required'=>true,
				'message'=> 'The field key is already exists.'
			),
		),
		'label' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'required'=>true,
				'message'=> 'This field is required.'
			),
		),
		'value' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'required'=>true,
				'message'=> 'This field is required.'
			),
		),
		'input_type' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'required'=>true,
				'message'=> 'This field is required.'
			),
		),
	);
	
	public function afterSave($created,$options=array()){
		$this->updateYaml();
	}
	 
	public function writeConfiguration(){
		$settings = $this->find('all', array(
			'fields' => array(
				'Setting.key',
				'Setting.value',
			),
			'cache' => array(
				'name' => 'setting_write_configuration',
				'config' => 'setting_write_configuration',
			),
		));
		
		foreach($settings AS $setting) {
			Configure::write($setting['Setting']['key'], $setting['Setting']['value']);
		}
	} 
	public function updateYaml(){
		$list = $this->find('list', array('fields' => array('key','value',),'order' => array('Setting.key' => 'ASC')));
		App::uses('File', 'Utility');
		$filePath = APP.'Config'.DS.'settings.yml';
		$file = new File($filePath, true);
		$listYaml = Spyc::YAMLDump($list, 4, 60);
		$file->write($listYaml);
    } 
}