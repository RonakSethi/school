<?php

App::uses('Sanitize', 'Utility');

class BusesController extends AppController {

    public $name = 'Buses';
    public $uses = array('Bus', 'User', 'Device', 'Trip');
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Cookie', 'Email');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('admin_login');
    }

    public function updatebuslat() {

        $listing = $this->Bus->find('all', array('conditions' => array('Bus.status' => 1)));
        foreach ($listing as $buslisting) {
            $getlivedata_1 = $this->Bus->query("SELECT * FROM `positions` where deviceid =" . $buslisting['Bus']['id'] . " order by id desc limit 1");

            $getlivedata = $this->Bus->query("SELECT * FROM `positions` where deviceid =" . $buslisting['Bus']['id'] . " AND speed >0 order by id desc limit 1");

//            if ($getlivedata_1[0]['positions']['speed'] == 0) {
//                $updatespeed = 0;
//            } else {
//                $updatespeed = $getlivedata[0]['positions']['speed'];
//            }
$updatespeed = 0;

            if ($getlivedata) {
                if ($getlivedata[0]['positions']['address'] == NULL || $getlivedata[0]['positions']['address'] == '') {
                    $latitude = $getlivedata[0]['positions']['latitude'];
                    $longitude = $getlivedata[0]['positions']['longitude'];

                    $geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&sensor=false');
                    $output = json_decode($geocodeFromLatLong);
                    $status = $output->status;
                    $address = ($status == "OK") ? $output->results[1]->formatted_address : '';
                    //echo die($address);
                    $this->Bus->query("UPDATE `buses` SET `speed`=" . $updatespeed . ",`address`='" . $address . "',`attributes`='" . $getlivedata[0]['positions']['attributes'] . "' where id =" . $buslisting['Bus']['id'] . "");
                } else {
                    $this->Bus->query("UPDATE `buses` SET `speed`=" . $updatespeed . ",`address`='" . $getlivedata[0]['positions']['address'] . "',`attributes`='" . $getlivedata[0]['positions']['attributes'] . "' where id =" . $buslisting['Bus']['id'] . "");
                }
            }
        }
        return true;
    }

    public function admin_index($parent_id = null) {
        $leftnav = "buses";
        $subleftnav = "view_bus";
        $pageTitle = "Buses";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle'));
        $this->set('pageHeading', 'Buses');
        $this->updatebuslat();
        if ($this->Session->read('Auth.User.role_id') == 1) {
            $condition = array('Bus.school_id >' => 0);
        } else {
            $condition = array('Bus.school_id' => $this->Session->read('Auth.User.id'));
        }

        if (!empty($parent_id) && empty($this->params->query['school_id'])) {
            $this->params->query['school_id'] = $parent_id;
        }

        if (!empty($this->params->query['school_id'])) {
            $parent_id = Sanitize::clean($this->params->query['school_id'], array('encode' => false));
            $condition['OR'] = array('Bus.school_id' => $parent_id);
            $this->request->data['search'] = $this->request->query;
        }

        if (!empty($this->params->query['bus'])) {
            $name = Sanitize::clean($this->params->query['bus'], array('encode' => false));
            $condition['OR'] = array('Bus.bus_number  like "%' . $name . '%"');
            $this->request->data['search'] = $this->request->query;
        }

        if (!empty($this->params->query['school_id']) && !empty($this->params->query['bus'])) {
            $parent_id = Sanitize::clean($this->params->query['school_id'], array('encode' => false));
            $condition['AND'] = array('Bus.bus_number  like "%' . $name . '%"', 'Bus.school_id' => $parent_id);
            $this->request->data['search'] = $this->request->query;
        }

        $catList = $this->User->find('list', array('conditions' => array('User.status' => 1, 'User.role_id' => 2), 'fields' => array('User.id', 'User.first_name')));
        $this->set('catList', $catList);

        $this->paginate = array('conditions' => $condition, 'order' => 'id desc', 'limit' => 10);
        $bus = $this->paginate('Bus');
        $this->set('buses', $bus);
    }

    public function admin_busmap($id = null) {
        $this->layout = 'admin';
        $leftnav = "bus";
        $subleftnav = "view_bus";
        $pageTitle = "Live Map of Bus";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle'));
        $this->set(compact('leftnav', 'subleftnav'));
        $this->set('pageHeading', 'Live Map');
        $getlivedata = $this->Bus->query("SELECT * FROM `positions` where deviceid=" . $id . " order by id desc limit 2");

        $bus_number1 = $this->Bus->find('first', array('fields' => array('Bus.bus_number'), 'conditions' => array('Bus.id' => $id)));
        //print_r($getlivedata); die;
        $this->set('lat2', $getlivedata[0]['positions']['latitude']);
        $this->set('long2', $getlivedata[0]['positions']['longitude']);

        $this->set('lat1', $getlivedata[1]['positions']['latitude']);
        $this->set('long1', $getlivedata[1]['positions']['longitude']);

        $this->set('bus_number', $bus_number1);
        $this->set('id', $id);
    }

    public function admin_busmapreport($id = null, $m = null) {

        $this->layout = 'admin';
        $leftnav = "bus";
        $subleftnav = "view_bus";
        $pageTitle = "Trip Report of Bus";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle'));
        $this->set(compact('leftnav', 'subleftnav'));
        $this->set('pageHeading', 'Trip Report of Bus');
        $start = 0;
        /* if($m=='yesterday')
          {
          $getAlllivedata=$this->Bus->query("SELECT latitude,longitude FROM `positions` WHERE deviceid=".$id." and DATE(convert_tz(`servertime`,'+00:00','+05:30'))=CURDATE()-1 ORDER BY `positions`.`servertime` DESC");
          }
          elseif($m=='weekly')
          {
          $getAlllivedata=$this->Bus->query("SELECT latitude,longitude FROM `positions` WHERE deviceid=".$id." and DATE(convert_tz(`servertime`,'+00:00','+05:30')) > DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY `positions`.`servertime` DESC");
          }
          else
          {
          $getAlllivedata=$this->Bus->query("SELECT latitude,longitude FROM `positions` WHERE deviceid=".$id." and DATE(convert_tz(`servertime`,'+00:00','+05:30'))=CURDATE() ORDER BY `positions`.`servertime` DESC");
          }
          $total_results= count($getAlllivedata);
          $per_page = 16;
          $total_pages = ceil($total_results / $per_page);//total pages we going to have
          //-------------if page is setcheck------------------//
          if (isset($_GET['page']))
          {
          $show_page = $_GET['page']; //current page
          if ($show_page > 0 && $show_page <= $total_pages) {
          $start = ($show_page - 1) * $per_page;
          $end = $start + $per_page;
          } else {
          // error - show first set of results
          $start = 0;
          $end = $per_page;
          }
          }
          else {
          // if page isn't set, show first set of results
          $start = 0;
          $end = $per_page;
          }
          // display pagination
          $page = intval($_GET['page']);
          $tpages=$total_pages;
          if ($page <= 0)
          $page = 1;

          $reload = "/tracker/admin/buses/busmapreport/$id/$m/?tpages=" . $tpages;
          $mappaging= '<div class="pagination"><p>';
          if ($total_pages > 1) {
          $mappaging.= $this->mappaginate($reload, $show_page, $total_pages);
          }
          $mappaging.= "</p></div>"; */
        if ($m == 'yesterday') {

            $getlivedata = $this->Bus->query("SELECT latitude,longitude,address FROM `positions` WHERE deviceid=" . $id . " AND id%4=0 and DATE(convert_tz(`servertime`,'+00:00','+05:30'))=CURDATE()-1 ORDER BY `positions`.`servertime` DESC limit " . $start . ", 8");
            if (count($getlivedata) > 0)
                $getsecdata1 = count($getlivedata) - 1;
            else
                $getsecdata1 = 0;

            $getlivedata6 = $this->Bus->query("SELECT latitude,longitude,address FROM `positions` WHERE deviceid=" . $id . " and DATE(convert_tz(`servertime`,'+00:00','+05:30'))=CURDATE()-1 ORDER BY `positions`.`servertime` DESC limit " . $start . " , 1");
            $getlivedata7 = $this->Bus->query("SELECT latitude,longitude,address FROM `positions` WHERE deviceid=" . $id . " and DATE(convert_tz(`servertime`,'+00:00','+05:30'))=CURDATE()-1 ORDER BY `positions`.`servertime` DESC limit " . $getsecdata1 . ",1");
        }
        elseif ($m == 'weekly') {

            $getlivedata = $this->Bus->query("SELECT latitude,longitude,address FROM `positions` WHERE deviceid=" . $id . " AND id%8=0 and DATE(convert_tz(`servertime`,'+00:00','+05:30')) >DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY `positions`.`servertime` DESC limit " . $start . ", 8");
            if (count($getlivedata) > 0)
                $getsecdata1 = count($getlivedata) - 1;
            else
                $getsecdata1 = 0;

            $getlivedata6 = $this->Bus->query("SELECT latitude,longitude,address FROM `positions` WHERE deviceid=" . $id . " and DATE(convert_tz(`servertime`,'+00:00','+05:30')) > DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY `positions`.`servertime` DESC limit " . $start . " , 1");
            $getlivedata7 = $this->Bus->query("SELECT latitude,longitude,address FROM `positions` WHERE deviceid=" . $id . " and DATE(convert_tz(`servertime`,'+00:00','+05:30'))> DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY `positions`.`servertime` DESC limit " . $getsecdata1 . ",1");
        }
        else {
            $getlivedata = $this->Bus->query("SELECT latitude,longitude,address FROM `positions` WHERE deviceid=" . $id . " AND id%4=0 and DATE(convert_tz(`servertime`,'+00:00','+05:30'))=CURDATE() ORDER BY `positions`.`servertime` DESC limit " . $start . ", 20");
            if (count($getlivedata) > 0)
                $getsecdata1 = count($getlivedata) - 1;
            else
                $getsecdata1 = 0;

            $getlivedata6 = $this->Bus->query("SELECT latitude,longitude,address FROM `positions` WHERE deviceid=" . $id . " and DATE(convert_tz(`servertime`,'+00:00','+05:30'))=CURDATE() ORDER BY `positions`.`servertime` DESC limit " . $start . " ,1");
            $getlivedata7 = $this->Bus->query("SELECT latitude,longitude,address FROM `positions` WHERE deviceid=" . $id . " and DATE(convert_tz(`servertime`,'+00:00','+05:30'))=CURDATE() ORDER BY `positions`.`servertime` DESC limit " . $getsecdata1 . ",1");
        }
        $bus_number1 = $this->Bus->find('first', array('fields' => array('Bus.bus_number'), 'conditions' => array('Bus.id' => $id)));

        $finaldata = array();
        foreach ($getlivedata as $getlivedata1) {
            $finaldata2['lat'] = $getlivedata1['positions']['latitude'];
            $finaldata2['lng'] = $getlivedata1['positions']['longitude'];
            $finaldata2['address'] = $getlivedata1['positions']['address'];
            array_push($finaldata, $finaldata2);
        }

        $this->set('lat2', $getlivedata6[0]['positions']['latitude']);
        $this->set('long2', $getlivedata6[0]['positions']['longitude']);
        $this->set('longa2', $getlivedata6[0]['positions']['address']);

        $this->set('lat1', $getlivedata7[0]['positions']['latitude']);
        $this->set('long1', $getlivedata7[0]['positions']['longitude']);
        $this->set('longa1', $getlivedata7[0]['positions']['address']);


        $this->set('latArr', $finaldata);
        $this->set('bus_number', $bus_number1);
        $this->set('id', $id);
        $this->set('m', $m);
        //$this->set('mappaging', $mappaging);
    }

    public function mappaginate($reload, $page, $tpages) {
        $adjacents = 2;
        $prevlabel = "&lsaquo; Prev";
        $nextlabel = "Next &rsaquo;";
        $out = "";
        // previous
        if ($page == 1) {
            $out.= "\n"; //"<span>".$prevlabel."</span>\n";
        } elseif ($page == 2) {
            $out.="<li><a href=\"" . $reload . "\">" . $prevlabel . "</a>\n</li>";
        } else {
            $out.="<li><a href=\"" . $reload . "&amp;page=" . ($page - 1) . "\">" . $prevlabel . "</a>\n</li>";
        }
        $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
        $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;
        for ($i = $pmin; $i <= $pmax; $i++) {
            if ($i == $page) {
                $out.= "<li class=\"active\"><a href=''>" . $i . "</a></li>\n";
            } elseif ($i == 1) {
                $out.= "<li><a href=\"" . $reload . "\">" . $i . "</a>\n</li>";
            } else {
                $out.= "<li><a href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a>\n</li>";
            }
        }

        if ($page < ($tpages - $adjacents)) {
            $out.= "<li><a style='font-size:11px' href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $tpages . "</a>\n</li>";
        }
        // next
        if ($page < $tpages) {
            $out.= "<li><a href=\"" . $reload . "&amp;page=" . ($page + 1) . "\">" . $nextlabel . "</a>\n</li>";
        } else {
            $out.= "\n"; //"<span style='font-size:11px'>".$nextlabel."</span>\n";
        }
        $out.= "";
        return $out;
    }

    public function admin_add() {

        $leftnav = "bus";
        $subleftnav = "add";
        $pageTitle = "Add Bus";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle'));
        $this->set('pageHeading', 'Add Bus');
        if ($this->Session->read('Auth.User.role_id') == 1) {
            $catList = $this->User->find('list', array('conditions' => array('User.status' => 1, 'User.role_id' => 2), 'fields' => array('User.id', 'User.first_name')));
        } else {
            $catList = $this->User->find('list', array('conditions' => array('User.status' => 1, 'User.role_id' => 2, 'User.id' => $this->Session->read('Auth.User.id')), 'fields' => array('User.id', 'User.first_name')));
        }

        //$catList = $this->User->find('list',array('conditions'=>array('User.status'=>1,'User.role_id'=>2),'fields'=>array('User.id','User.first_name')));
        $RouteList = $this->Trip->find('list', array('conditions' => array('Trip.status' => 1), 'fields' => array('Trip.id', 'Trip.title')));
        $this->set('RouteList', $RouteList);
        $this->set('catList', $catList);

        if ($this->request->is('post') || $this->request->is('put')) {
            try {

                $countbuses = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['Bus']['school_id']), 'fields' => array('User.id', 'User.totalbus')));
                $countbuses1 = $this->Bus->find('count', array('conditions' => array('Bus.school_id' => $this->request->data['Bus']['school_id']), 'fields' => array('Bus.id', 'Bus.school_id')));

                $countiemi = $this->Bus->find('count', array('conditions' => array('Bus.iemi' => $this->request->data['Bus']['iemi']), 'fields' => array('Bus.id', 'Bus.school_id')));
                if ($countiemi > 0) {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('You have entered same bus imei.'));
                    $this->redirect(array('controller' => 'buses', 'action' => 'index'));
                }
                if ($countbuses1 < $countbuses['User']['totalbus']) {
                    if ($this->Bus->save($this->request->data)) {

                        $dataArr = array('Device' => array('id' => $this->Bus->id, 'name' => $this->request->data['Bus']['bus_number'],
                                'uniqueid' => $this->request->data['Bus']['iemi'],
                                'status' => '',
                                'lastupdate' => NULL,
                                'positionid' => NULL,
                                'groupid' => 0));
                        $this->Device->save($dataArr, false);

                        //$this->Device->query("INSERT INTO `devices`(`id`, `name`, `uniqueid`, `status`, `lastupdate`, `positionid`, `groupid`) VALUES ('".$this->Bus->id."','".$this->request->data['Bus']['bus_number']."','".$this->request->data['Bus']['iemi']."',NULL,NULL,NULL,0)");
                        $this->Bus->query("INSERT INTO `user_device`(`userid`, `deviceid`) VALUES (1," . $this->Device->id . ")");

                        $this->Session->write('msg_type', 'alert-success');
                        $this->Session->setFlash(__('Bus Added successfully'));
                        $this->redirect(array('controller' => 'buses', 'action' => 'index'));
                    } else {
                        $msg = "";
                        foreach ($this->Bus->validationErrors as $value) {
                            $msg .=$value[0] . "<br/>";
                        }
                        $this->Session->write('msg_type', 'alert-danger');
                        $this->Session->setFlash(__($msg));
                    }
                } else {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('You have reached bus limit.'));
                    $this->redirect(array('controller' => 'buses', 'action' => 'index'));
                }
            } catch (Exception $e) {
                $this->log($e, "debug");
            }
        }
    }

    public function admin_edit($id = null) {
        $this->layout = 'admin';
        $leftnav = "bus";
        $subleftnav = "view_bus";
        $pageTitle = "Edit Bus";
        $this->set(compact('leftnav', 'subleftnav', 'pageTitle'));
        $this->set(compact('leftnav', 'subleftnav'));
        $this->set('pageHeading', 'Edit bus');
        if ($this->Session->read('Auth.User.role_id') == 1) {
            $catList = $this->User->find('list', array('conditions' => array('User.status' => 1, 'User.role_id' => 2), 'fields' => array('User.id', 'User.first_name')));
        } else {
            $catList = $this->User->find('list', array('conditions' => array('User.status' => 1, 'User.role_id' => 2, 'User.id' => $this->Session->read('Auth.User.id')), 'fields' => array('User.id', 'User.first_name')));
        }
        //$catList = $this->User->find('list',array('conditions'=>array('User.status'=>1,'User.role_id'=>2),'fields'=>array('User.id','User.first_name')));
        $this->set('catList', $catList);

        $RouteList = $this->Trip->find('list', array('conditions' => array('Trip.status' => 1), 'fields' => array('Trip.id', 'Trip.title')));
        $this->set('RouteList', $RouteList);

        if (empty($id) && empty($this->request->data)) {
            $this->Session->write('msg_type', 'alert-danger');
            $this->Session->setFlash(__('INVALID_USER'));
            $this->redirect(array('controller' => 'buses', 'action' => 'index'));
        }

        try {
            if ($this->request->is('post') || $this->request->is('put')) {

                $countbuses = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['Bus']['school_id']), 'fields' => array('User.id', 'User.totalbus')));
                $countbuses1 = $this->Bus->find('count', array('conditions' => array('Bus.school_id' => $this->request->data['Bus']['school_id']), 'fields' => array('Bus.id', 'Bus.school_id')));

                if ($countbuses1 <= $countbuses['User']['totalbus']) {
                    //echo $countbuses['User']['totalbus']; die;
                    if ($this->Bus->save($this->request->data)) {

                        $dataArr = array('Device' => array('id' => $this->request->data['Bus']['id'], 'name' => $this->request->data['Bus']['bus_number'],
                                'uniqueid' => $this->request->data['Bus']['iemi']));
                        $this->Device->save($dataArr, false);

                        $this->Session->write('msg_type', 'alert-success');
                        $this->Session->setFlash(__('Bus updated successfully'));
                        $this->redirect(array('controller' => 'buses', 'action' => 'index'));
                    } else {
                        $msg = "";
                        foreach ($this->Bus->validationErrors as $value) {
                            $msg .=$value[0] . "<br/>";
                        }
                        $this->Session->write('msg_type', 'alert-danger');
                        $this->Session->setFlash(__($msg));
                    }
                } else {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('You have reached bus limit.'));
                    $this->redirect(array('controller' => 'buses', 'action' => 'index'));
                }
            } else {
                $this->Bus->id = $id;
                if (!$this->Bus->exists()) {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('INVALID_CATEGORY'));
                    $this->redirect(array('controller' => 'buses', 'action' => 'index'));
                }
                $this->request->data = $this->Bus->read(null, $id);
            }
        } catch (Exception $e) {
            $this->log($e, "debug");
        }
    }

    public function admin_delete($id = null) {
        $this->layout = false;
        try {

            if ($this->Session->read('Auth.User.role_id') != 1) {
                $GetMyBuses = $this->Bus->find('count', array('conditions' => array('Bus.id ' => $id, 'Bus.school_id' => $this->Session->read('Auth.User.id')), 'fields' => array('Bus.id', 'Bus.bus_number')));
                if ($GetMyBuses > 0) {
                    $this->Bus->delete($id);
                    $this->Session->write('msg_type', 'alert-success');
                    $this->Session->setFlash(__('Bus deleted successfully'));
                } else {
                    $this->Session->write('msg_type', 'alert-danger');
                    $this->Session->setFlash(__('Bus cannot be deleted.'));
                }
            } else {
                $this->Bus->delete($id);
                $this->Session->write('msg_type', 'alert-success');
                $this->Session->setFlash(__('Bus deleted successfully'));
            }
        } catch (Exception $e) {
            $this->log($e, 'debug');
            $this->Session->write('msg_type', 'alert-danger');
            $this->Session->setFlash(__('DELETE_RECORD_EXCEPTION_MSG'));
        }
        $this->redirect(array('controller' => 'buses', 'action' => 'index'));
    }

}
