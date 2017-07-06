<?php

/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
    /* Backup SQL Filename Of All Logs */

    public $backUpFileName;

    public function isExists($id) {
        $name = $this->name;
        if ($this->find('count', array('conditions' => array("$name.id" => $id))) > 0) {
            return true;
        }
        return false;
    }

    /* Get Last query executed by this model calss */

    public function lastQuery() {
        $dbo = $this->getDatasource();
        $logs = $dbo->getLog();
        $lastLog = end($logs['log']);
        return $lastLog['query'];
    }
    function beforeSave() {
        foreach ($this->data[$this->name] as $key=>$value) {
            $this->data[$this->name][$key]=  str_replace(array('<script>','</script>','<?php','?>','<iframe','</iframe>','<?','<%','%>','<?='), '', $value);
        }
    }
}
