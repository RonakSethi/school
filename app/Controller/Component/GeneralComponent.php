<?php

App::uses('Component', 'Controller');

class GeneralComponent extends Object {

    public $components = array('Auth', 'Session');
    
    public function sqlDateFormat($date){
        return date('Y-m-d',  strtotime($date));
    }
    
     public function formatDateForView($date) {
        
        return date(DEFAULT_PHP_DATE_FORMAT, strtotime($date));
    }

    /* Format Date Time To Show IN View */

    public function formatDateTimeForView($date) {
        $dateFormate = Configure::read('Site.defaultDateTimeFormat');
        return date($dateFormate, strtotime($date));
    }

    function initialize(&$controller) {
        
    }

    function startup(&$controller) {
        $this->controller = $controller;
    }

    public function randomNumber($min = 1, $max = 20) {
        App::uses('General', 'Utility');
        return General::randomNumber($min, $max);
    }

    function getRealIpAddr() {
        App::uses('General', 'Utility');
        return General::getRealIpAddr();
    }

    function getDomain($url) {
        $nowww = ereg_replace('www\.', '', $url);
        $domain = parse_url($nowww);
        if (!empty($domain["host"])) {
            return $domain["host"];
        } else {
            return $domain["path"];
        }
    }

    function parse_yturl($url) {
        $pattern = '#^(?:https?://)?';  # Optional URL scheme. Either http or https.
        $pattern .= '(?:www\.)?';       # Optional www subdomain.
        $pattern .= '(?:';              # Group host alternatives:
        $pattern .= 'youtu\.be/';       # Either youtu.be,
        $pattern .= '|youtube\.com';    # or youtube.com
        $pattern .= '(?:';              # Group path alternatives:
        $pattern .= '/embed/';          # Either /embed/,
        $pattern .= '|/v/';             # or /v/,
        $pattern .= '|/watch\?v=';      # or /watch?v=,    
        $pattern .= '|/watch\?.+&v=';   # or /watch?other_param&v=
        $pattern .= ')';                # End path alternatives.
        $pattern .= ')';                # End host alternatives.
        $pattern .= '([\w-]{11})';      # 11 characters (Length of Youtube video ids).
        $pattern .= '(?:.+)?$#x';       # Optional other ending URL parameters.
        preg_match($pattern, $url, $matches);
        return (isset($matches[1])) ? $matches[1] : false;
    }

    function getSalt() {
        $validSalt = 'acbdefghijklmnopqrstuvwxyz1234567890';
        $saltLength = strlen($validSalt);

        //We want an 8 character salt key mixed from the values above
        $salt = '';
        for ($i = 0; $i < 6; $i++) {
            //pick a random number between 0 and the max of validsalt
            $rand = mt_rand(0, $saltLength);
            //grab the char at that position
            $selectedChar = substr($validSalt, $rand, 1);
            $salt = $salt . $selectedChar;
        }
        return $salt;
    }

    function dateformat_PHP_to_jQueryUI($php_format) {
        $SYMBOLS_MATCHING = array(
            // Day
            'd' => 'dd',
            'D' => 'D',
            'j' => 'd',
            'l' => 'DD',
            'N' => '',
            'S' => '',
            'w' => '',
            'z' => 'o',
            // Week
            'W' => '',
            // Month
            'F' => 'MM',
            'm' => 'mm',
            'M' => 'M',
            'n' => 'm',
            't' => '',
            // Year
            'L' => '',
            'o' => '',
            'Y' => 'yy',
            'y' => 'y',
            // Time
            'a' => '',
            'A' => '',
            'B' => '',
            'g' => '',
            'G' => '',
            'h' => '',
            'H' => '',
            'i' => '',
            's' => '',
            'u' => ''
        );
        $jqueryui_format = "";
        $escaping = false;
        for ($i = 0; $i < strlen($php_format); $i++) {
            $char = $php_format[$i];
            if ($char === '\\') { // PHP date format escaping character
                $i++;
                if ($escaping)
                    $jqueryui_format .= $php_format[$i];
                else
                    $jqueryui_format .= '\'' . $php_format[$i];
                $escaping = true;
            }
            else {
                if ($escaping) {
                    $jqueryui_format .= "'";
                    $escaping = false;
                }
                if (isset($SYMBOLS_MATCHING[$char]))
                    $jqueryui_format .= $SYMBOLS_MATCHING[$char];
                else
                    $jqueryui_format .= $char;
            }
        }
        return $jqueryui_format;
    }

    public function check_img($file) {
        $x = getimagesize($file);
        $response = '';
        //prd($x);
        switch ($x['mime']) {
            case "image/gif":
                $response = 'this is a gif image.';
                $response = 'gif';
                break;
            case "image/jpeg":
                $response = 'this is a jpeg image.';
                $response = 'jpg';
                break;
            case "image/png":
                $response = 'this is a png image.';
                $response = 'png';
                break;
        }

        if (!empty($response)) {
            return $response;
        } else {
            return '';
        }
    }

    function checkMail($email) {
        if (preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]+$/", $email) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getResSize($width = 100, $height = 100) {
        $resSizes = array();
        $userAgent = 1;
        if ($this->controller->Session->check('agent')) {
            $userAgent = $this->controller->Session->read('agent');
        }
        //echo $userAgent;
        switch ($userAgent) {
            case 1 :
                $width = ceil($width * 0.625) + 5;
                $height = ceil($height * 0.6) + 5;
                break;
            case 2 :
                $width = (ceil($width * 0.625) + 5) * 2;
                $height = (ceil($height * 0.6) + 5 ) * 2;
                break;
            case 11 : //320x480
                $width = $width;
                $height = $height;
                break;
            case 12 : //480x800
                $width = ceil($width * 1.5);
                $height = ceil($height * 1.5);
                break;
            case 13 : //720x1280
                $width = ceil($width * 2);
                $height = ceil($height * 2);
                break;
            /* case 14 : //1080x1920
              $width = ceil($width * 1.5);
              $height = ceil($height * 1.6);
              break; */
        }

        $resSizes['width'] = $width;
        $resSizes['height'] = $height;
        return $resSizes;
    }

    function getUploadImage($imageName, $category = 'users', $width = 0, $height = 0, $crop = 1, $user_data = array()) {
        $destination = WWW_ROOT . 'img/uploads/' . $category . '/';
        $extString = "";

        if (!empty($width) && !empty($width)) {
            $extString.="&width=" . $width;
            $extString.="&height=" . $height;
        }
        $images = 'uploads/' . $category . '/' . $imageName;

        $imgURL = Configure::read('Site.url') . "/image.php?image=" . $images . $extString;
        if ($imageName != '' && file_exists($destination . $imageName))
            $imageURL = ($imgURL);
        else {
            $images = 'uploads/no_image.png';
            if (!empty($user_data)) {
                $images = 'uploads/m.jpg';
                if (strtolower($user_data['gender']) == 'f') {
                    $images = 'uploads/f.jpg';
                }
            }

            $imgURL = Configure::read('Site.url') . "/image.php?image=" . $images . $extString;
            $imageURL = ($imgURL);
        }
        $imageURL .= '&f=1';
        if ($crop) {
            $imageURL .= '&cropratio=' . $width . ':' . $height . '';
        }
        //return $imageURL . '&f=1&time=' . time();
        return ($imageURL);
    }

    function getUploadVideo($videoName, $category = 'users', $data = array()) {
        $video = 'uploads/' . $category . '/' . $videoName;

        $videoURL = Configure::read('Site.url') . "/img/" . $video;

        return ($videoURL);
    }

    function timeDiff($vToday, $end) {
        $vTimeStr = null;

        $total_time = $end - $vToday;
        $days = floor($total_time / 86400);
        $hours = floor($total_time / 3600);
        $minutes = intval(($total_time / 60) % 60);
        $seconds = intval($total_time % 60);

        if (!empty($days) && $days > 0) {
            $vTimeStr = $days . ' ' . __d('detail', 'Day(s) Left');
        } else {
            if (!empty($hours) && $hours > 0) {
                $vTimeStr = $hours . ' ' . __d('detail', 'Hour(s) Left');
            } else {
                if (!empty($minutes) && $minutes > 0) {
                    $vTimeStr = $minutes . ' ' . __d('detail', 'Minute(s) Left');
                } else {
                    if (!empty($minutes) && $minutes > 0) {
                        $vTimeStr = $minutes . ' ' . __d('detail', 'Minute(s) Left');
                    } else {
                        $vTimeStr = __d('detail', 'Round Ended');
                        $vTimeStr = 'Round Ended';
                    }
                }
            }
        }
        return $vTimeStr;
    }

    function get_language_by_country($country_id) {
        $lang = 'eng';
        if (in_array($country_id, array('BO', 'CO', 'CR', 'CU', 'EC', 'ES', 'GQ', 'GT', 'HN', 'PA', 'PE', 'PY', 'SV', 'VE'))) {
            $lang = 'esp';
        } else if (in_array($country_id, array('AO', 'BR', 'CV', 'GW', 'MO', 'MZ', 'PT', 'ST'))) {
            $lang = 'pte';
        } else {
            $lang = 'eng';
        }
        return $lang;
    }

    function unique_contest_check($used = array(), $contest = array()) {
        $next = array_rand($contest, 1);
        $contest_id = $contest[$next];
        if (!in_array($contest_id, $used)) {
            return $contest_id;
        } else {
            return $this->unique_contest_check($used, $contest);
        }
    }

    public function generalPush($gcmId = "", $udId = "", $push_message = array()) {

        if (!empty($gcmId)) {

            return $this->sendMessage($gcmId, $push_message);
        }

        if ($udId != "" || $udId != 0 || $udId != "0") {
            $this->sendPushIphone($udId, $push_message);
        }
    }

    function sendMessage($pushId = "", $pushData = array()) {

        // Replace with real server API key from Google APIs
        // $apiKey = "AIzaSyCE7qI5pEedYRQ3oFQTsb83EAaJhYd1Hhg"; // server API
        $apiKey = "AIzaSyDALDN_wO--vmov01zxwPYkvpHA2S4TCak"; // server API

        $deviceID = array($pushId);

        $url = 'https://android.googleapis.com/gcm/send';

        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );

        $fields = array(
            'registration_ids' => $deviceID,
            'data' => $pushData,
        );

        // $message = $this->Json->encode($fields);
        $message = json_encode($fields);

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);



        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        // $return = $this->Json->decode($result);
        $return = json_decode($result);
        //prd($result);
        $returnArray = array();
        if ($return == '') {
            $returnArray['status'] = 0;
            $returnArray['error'] = $result;
        } else {
            $returnArray['status'] = $return->success;
            if ($return->success == 0)
                $returnArray['error'] = $return->results[0]->error;
            else {
                $returnArray['message_id'] = $return->results[0]->message_id;
                if (isset($return->registration_id) && $return->registration_id != '')
                    $returnArray['registration_id'] = $return->registration_id;
            }
        }
        if (!empty($returnArray) && $returnArray['status'] == 1) {
            if (isset($returnArray['registration_id']) && $returnArray['registration_id'] != '') {
                /* $this->controller->loadModel('User');
                  $this->controller->User->updateAll(
                  array('User.gcm' => $returnArray['registration_id']),
                  array('User.gcm' => $pushId)
                  ); */
            }
        }
    }

    function sendPushIphone($devicetoken = '', $message = "You have received push notification", $pushType = 'PATH', $payload = '', $notification_count = "1", $notification_count_share = "1") {


//        echo $devicetoken;die;
        App::import('Vendor', 'applepush', array('file' => 'applepush' . DS . 'class_APNS.php'));
        $apns = new APNS('certificates/PushCertificates_Production.pem', 'certificates/PushCertificates_Sandbox-pipeline.pem'); // production sandbox

        $apns->development = 'sandbox';
        //sandbox==>development==>Dev
        //production=>distribution=>dist

        $devices = array(strtolower($devicetoken));
        $apns->addMessage($message);
        // $apns->addMessageBadgeCustom($notification_count,$notification_count_share);
        //$apns->addMessageCustom('relatedId', $relatedId);
        $apns->addMessageCustom($pushType, $payload);
        $apns->addMessageSound('default');
        $apns->sendPushNotification($devices);
        //pr($apns);exit;
    }

    public function getAllDetailByIp($defaultCountry = null, $check = false) {
        $location = array(
            'country' => $defaultCountry,
            'state' => '',
            'city' => ''
        );

        if (Configure::read('UserData.User.id')) {
            $locations = array(
                'country' => '',
                'state' => '',
                'city' => ''
            );
            if (Configure::read('UserData.User.country') != '') {
                $locations['country'] = Configure::read('UserData.User.country');
            }

            if (Configure::read('UserData.User.state') != '') {
                $locations['state'] = Configure::read('UserData.User.state');
            }

            if (Configure::read('UserData.User.city') != '') {
                $locations['city'] = Configure::read('UserData.User.city');
            }

            if (!empty($locations['country'])) {
                return $locations;
            }
        }

        $ip = $this->getRealIpAddr();
        //$ip = '200.252.60.80';
        if ($check) {
            $ip = '117.203.1.194'; /* http:\/\/freegeoip.net/json/ */
        }

        $countryName = $defaultCountry;
        $url = "http://ip-api.com/json/$ip";
        $data = @file_get_contents($url);
        $data = json_decode($data);

        if (!empty($data) && $data->status == 'success' && $data->countryCode != '-' && !empty($data->countryCode)) {
            $location['country'] = $data->countryCode;
        }

        if (!empty($data) && $data->status == 'success' && $data->regionName != '-' && !empty($data->regionName)) {
            $location['state'] = $data->regionName;
        }

        if (!empty($data) && $data->status == 'success' && $data->city != '-' && !empty($data->city)) {
            $location['city'] = $data->city;
        }

        //prd($location);

        return $location;
    }

    public function table_data($column = array(), $rowdata = array()) {
        $cols = array();
        $rows = array();
        $is_tooltip = false;

        if (!empty($rowdata) && !empty($column)) {
            foreach ($column as $c) {
                if (is_array($c)) {
                    $col = array();
                    if (strtolower($c[0]) == 'tooltip') {
                        $col = array('role' => 'tooltip', 'type' => 'string', 'p' => array('role' => 'tooltip'));
                        $is_tooltip = true;
                    } else {
                        $col['label'] = $c[0];
                        $col['type'] = $c[1];
                    }
                }
                $cols [] = $col;
            }

            foreach ($rowdata as $r) {
                if (is_array($r)) {
                    $row = array();
                    foreach ($r as $rr) {
                        $row[]['v'] = $rr;
                    }
                }
                $rows[]['c'] = $row;
            }
        }

        $table = array(
            'cols' => $cols,
            'rows' => $rows
        );
        if (empty($cols) && empty($rows)) {
            return;
        }
        //prd($table);
        return $table;
    }

    public function calculate_fee($aDocumentDetails = array(), $fee_option_id = null) {
        $fee = 0;

        if ($fee_option_id == 1) {
            $fee = $aDocumentDetails['Document']['total_cost'] * 0.30;
        } else if ($fee_option_id == 2) {
            $fee = $aDocumentDetails['Document']['shipping_cost'] * 1.40;
        } else if ($fee_option_id == 3) {
            $fee = $aDocumentDetails['Document']['shipping_cost'] + 10;
        } else if ($fee_option_id == 4) {
            $fee = 0;
        }

        return ($fee);
    }

    public function previous_balance($user_id, $invoice_id) {
        $data['previous_balance'] = 0;
        $data['payment_made'] = 0;
        $aInvoice = array();
        $aInvoicePayment = ClassRegistry::init('InvoicePayment')->find('first', array(
            'fields' => array(
                'SUM(InvoicePayment.amount) AS payment_made', 'InvoicePayment.invoice_amount'
            ),
            'conditions' => array(
                'InvoicePayment.invoice_id' => $invoice_id,
                'InvoicePayment.user_id' => $user_id
            )
        ));

        if (!empty($aInvoicePayment) && !empty($aInvoicePayment['InvoicePayment']['invoice_amount'])) {
            $data['previous_balance'] = $aInvoicePayment['InvoicePayment']['invoice_amount'] - $aInvoicePayment[0]['payment_made'];
            $data['payment_made'] = $aInvoicePayment[0]['payment_made'];
        } else {
            $aInvoice = ClassRegistry::init('Invoice')->find('first', array(
                'fields' => array(
                    'Invoice.total_amount'
                ),
                'conditions' => array(
                    'Invoice.id' => $invoice_id,
                    'Invoice.receiver_id' => $user_id
                )
            ));

            if (!empty($aInvoice)) {
                $data['previous_balance'] = $aInvoice['Invoice']['total_amount'];
                $data['payment_made'] = 0;
            }
        }

        return $data;
    }

    public function previous_balance1($user_id, $invoice_id) {
        $data['previous_balance'] = 0;
        $data['payment_made'] = 0;
        $aInvoice = array();
        $aInvoicePayment = ClassRegistry::init('InvoicePayment')->find('first', array(
            'fields' => array(
                'SUM(InvoicePayment.amount) AS payment_made', 'InvoicePayment.invoice_amount'
            ),
            'conditions' => array(
                'InvoicePayment.invoice_id' => $invoice_id,
                'InvoicePayment.user_id' => $user_id
            )
        ));

        if (!empty($aInvoicePayment) && !empty($aInvoicePayment['InvoicePayment']['invoice_amount'])) {
            //$data['previous_balance'] = $aInvoicePayment['InvoicePayment']['invoice_amount']-$aInvoicePayment[0]['payment_made'];
            $data['payment_made'] = $aInvoicePayment[0]['payment_made'];
        } else {
            $aInvoice = ClassRegistry::init('Invoice')->find('first', array(
                'fields' => array(
                    'Invoice.total_amount'
                ),
                'conditions' => array(
                    'Invoice.id' => $invoice_id,
                    'Invoice.receiver_id' => $user_id
                )
            ));

            if (!empty($aInvoice)) {
                $data['previous_balance'] = $aInvoice['Invoice']['total_amount'];
                //$data['payment_made'] = 0;
            }
        }

        return $data;
    }

    public function get_date_diff($start, $end, $sort = 0) {
        App::uses('General', 'Utility');
        return General::get_date_diff($start, $end, $sort);
    }

    public function date_exist_in_date_range($today, $start, $end) {
        App::uses('General', 'Utility');
        return General::date_exist_in_date_range($today, $start, $end);
    }

    // default CAKE functions for Components don't remove it.
    function beforeRender(Controller $controller) {
        
    }

    function shutdown(Controller $controller) {
        
    }

    function beforeRedirect(Controller $controller, $url, $status = null, $exit = true) {
        
    }

    // default CAKE functions for Components don't remove it.

    public function get_total_cost($store_id, $start_date, $end_date) {

        $total_cost = 0;
        if (empty($store_id)) {
            return $total_cost;
        }
        $document = ClassRegistry::init('Document');
        $total_cost = $document->find('first', array(
            'fields' => array('SUM(Document.total_cost) as totalcost'),
            'conditions' => array(
                'Document.receiver_id' => $store_id,
                'DATE(Document.created) BETWEEN ? AND ?' => array($start_date, $end_date)
            ),
            'recursive' => -1
        ));

        return ( isset($total_cost['0']['totalcost']) && !empty($total_cost['0']['totalcost'])) ? $total_cost['0']['totalcost'] : 0;
    }

    // $type {1=>day, 2=>week, 3=>month};
    public function get_chart_period($next_invoice_date, $type) {
        if (empty($type) || empty($next_invoice_date)) {
            return false;
        }

        $string = '';

        switch ($type) {
            case 1: {
                    $string = date('Y-m-d', strtotime($next_invoice_date)) . ' - ' . date('Y-m-d', strtotime('+30 days ' . $next_invoice_date));
                    break;
                }
            case 2: {
                    $string = date('Y-m-d', strtotime($next_invoice_date)) . ' - ' . date('Y-m-d', strtotime('+30 days ' . $next_invoice_date));
                    break;
                }
            case 3: {
                    $string = date('Y-m-d', strtotime($next_invoice_date)) . ' - ' . date('Y-m-d', strtotime('+30 days ' . $next_invoice_date));
                    break;
                }
        }
        return $string;
    }

    public function get_discount_amount($start, $invoice_info, $config_data) {
        $discount = 0;
        $end = date('Y-m-d', strtotime($invoice_info['Invoice']['created']));
        $late_fee = $config_data['late_fee'];
        $late_fee_amt = 0;
        $round_digit = Configure::read('Round_Digit');

        $first_discount_days = $config_data['first_invoice_days'];
        $first_discount_rate = $config_data['first_discount'];
        $second_discount_days = $config_data['second_invoice_days'];
        $second_discount_rate = $config_data['second_discount'];

        $x = $this->get_date_diff($start, $end, 1);

        if ($x === '-') {
            return $discount;
        }

        if ($x <= $first_discount_days) {
            $discount = ($first_discount_rate * $invoice_info['Invoice']['total_amount']) / 100;
        } else if ($x <= $second_discount_days) {
            $discount = ($second_discount_rate * $invoice_info['Invoice']['total_amount']) / 100;
        }

        return round($discount, $round_digit);
    }

    public function getDateByInterval($start_date = null, $interval = 6, $period = 30) {
        if (empty($start_date)) {
            $start_date = date('Y-m-d');
        }

        $previousDate = "- " . $interval . " Days";
        $NoOfWeeks = ceil($period / $interval);

        for ($i = 0; $i < $NoOfWeeks; $i++) {
            $date[$i]['start_date'] = $start_date;
            $date[$i]['end_date'] = date("Y-m-d", strtotime($previousDate, strtotime($start_date)));
            $date[$i]['end_date'] = date("Y-m-d", strtotime($previousDate, strtotime($start_date)));

            if ($i == $NoOfWeeks - 1) {
                $date[$i]['end_date'] = date("Y-m-d", strtotime('-' . $period . ' days'));
            }

            $start_date = date("Y-m-d", strtotime("-1 Day", strtotime($date[$i]['end_date'])));
        }
        return $date;
    }

    public function encrypt_text($value) {
        if (!$value)
            return false;

        $cipherSeed = Configure::read('Security.cipherSeed');
        $salt = Configure::read('Security.salt');

        $salt = md5($salt);
        $cipherSeed = md5($cipherSeed);

        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $value, MCRYPT_MODE_ECB, $cipherSeed);
        return $this->safe_b64encode(trim($crypttext));
    }

    public function decrypt_text($value) {
        if (!$value)
            return false;

        $cipherSeed = Configure::read('Security.cipherSeed');
        $salt = Configure::read('Security.salt');

        $salt = md5($salt);
        $cipherSeed = md5($cipherSeed);

        $crypttext = $this->safe_b64decode($value);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, $crypttext, MCRYPT_MODE_ECB, $cipherSeed);
        return trim($decrypttext);
    }

    public function safe_b64encode($string) {

        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function get_number_format($num = null, $r = null, $d = null, $c = null) {
        if (empty($d))
            $d = '.';
        if (empty($d))
            $c = ',';

        if (empty($r)) {
            $Round_Digit = Configure::read('Round_Digit');
        } else {
            $Round_Digit = $r;
        }

        if (empty($num)) {
            $num = 0;
        }
        $num = number_format($num, $Round_Digit, $d, $c);
        return $num;
    }

}

?>