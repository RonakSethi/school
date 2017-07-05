<?PHP

#################################################################################
## Developed by Manifest Interactive, LLC                                      ##
## http://www.manifestinteractive.com                                          ##
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ##
##                                                                             ##
## THIS SOFTWARE IS PROVIDED BY MANIFEST INTERACTIVE 'AS IS' AND ANY           ##
## EXPRESSED OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE         ##
## IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR          ##
## PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL MANIFEST INTERACTIVE BE          ##
## LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR         ##
## CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF        ##
## SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR             ##
## BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,       ##
## WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE        ##
## OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,           ##
## EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.                          ##
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ ##
## Author of file: Peter Schmalfeldt                                           ##
#################################################################################

/**
 * @category Apple Push Notification Service using PHP & MySQL
 * @package EasyAPNs
 * @author Peter Schmalfeldt <manifestinteractive@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link http://code.google.com/p/easyapns/
 */

/**
 * Begin Document
 */
class APNS {

    /**
     * Connection to MySQL
     *
     * @var string
     * @access private
     */
    private $db;

    /**
     * Array of APNS Connection Settings
     *
     * @var array
     * @access private
     */
    private $apnsData;

    /**
     * Whether to trigger errors
     *
     * @var bool
     * @access private
     */
    private $showErrors = false;

    /**
     * Whether APNS should log errors
     *
     * @var bool
     * @access private
     */
    private $logErrors = true;

    /**
     * Log path for APNS errors
     *
     * @var string
     * @access private
     */
    private $logPath = 'apns.log';

    /**
     * Max files size of log before it is truncated. 1048576 = 1MB.  Added incase you do not add to a log
     * rotator so this script will not accidently make gigs of error logs if there are issues with install
     *
     * @var int
     * @access private
     */
    private $logMaxSize = 1048576; // max log size before it is truncated

    /**
     * Absolute path to your Production Certificate
     *
     * @var string
     * @access private
     */
    private $certificate = '/usr/local/apns/apns.pem';

    /**
     * Apples Production APNS Gateway
     *
     * @var string
     * @access private
     */
    private $ssl = 'ssl://gateway.push.apple.com:2195';

    /**
     * Apples Production APNS Feedback Service
     *
     * @var string
     * @access private
     */
    private $feedback = 'ssl://feedback.push.apple.com:2196';

    /**
     * Absolute path to your Development Certificate
     *
     * @var string
     * @access private
     */
    private $sandboxCertificate = '/usr/local/apns/apns-dev.pem'; // change this to your development certificate absolute path

    /**
     * Apples Sandbox APNS Gateway
     *
     * @var string
     * @access private
     */
    private $sandboxSsl = 'ssl://gateway.sandbox.push.apple.com:2195';

    /**
     * Apples Sandbox APNS Feedback Service
     *
     * @var string
     * @access private
     */
    private $sandboxFeedback = 'ssl://feedback.sandbox.push.apple.com:2196';

    /**
     * Message to push to user
     *
     * @var string
     * @access private
     */
    private $message;

    /**
     * Streams connected to APNS server[s]
     *
     * @var array
     * @access private
     */
    private $sslStreams;
    public $development;

    /**
     * Constructor.
     *
     * Initializes a database connection and perfoms any tasks that have been assigned.
     *
     * Create a new PHP file named apns.php on your website...
     *
     * <code>
     * <?php
     * $db = new DbConnect('localhost','dbuser','dbpass','dbname');
     * $db->show_errors();
     * $apns = new APNS($db);
     * ?>
     * </code>
     *
     * Alternate for Different Certificates
     *
     * <code>
     * <?php
     * $db = new DbConnect('localhost','dbuser','dbpass','dbname');
     * $db->show_errors();
     * $apns = new APNS($db, NULL, '/usr/local/apns/alt_apns.pem', '/usr/local/apns/alt_apns-dev.pem');
     * ?>
     * </code>
     *
     * Your iPhone App Delegate.m file will point to a PHP file with this APNS Object.  The url will end up looking something like:
     * https://secure.yourwebsite.com/apns.php?task=register&appname=My%20App&appversion=1.0.1&deviceuid=e018c2e46efe185d6b1107aa942085a59bb865d9&devicetoken=43df9e97b09ef464a6cf7561f9f339cb1b6ba38d8dc946edd79f1596ac1b0f66&devicename=My%20Awesome%20iPhone&devicemodel=iPhone&deviceversion=3.1.2&pushbadge=enabled&pushalert=disabled&pushsound=enabled
     *
     * @param object|DbConnectAPNS $db Database Object
     * @param array $args Optional arguments passed through $argv or $_GET
     * @param string $certificate Path to the production certificate.
     * @param string $sandboxCertificate Path to the production certificate.
     * @param string $logPath Path to the log file.
     * @access 	public
     */
    function __construct($certificate = NULL, $sandboxCertificate = NULL, $logPath = NULL) {

        if (!empty($certificate) && file_exists($certificate)) {
            $this->certificate = $certificate;
        }

        if (!empty($sandboxCertificate) && file_exists($sandboxCertificate)) {
            $this->sandboxCertificate = $sandboxCertificate;
        }

        /* abid $this->db = $db; */
        $this->checkSetup();
        $this->apnsData = array(
            'production' => array(
                'certificate' => $this->certificate,
                'ssl' => $this->ssl,
                'feedback' => $this->feedback
            ),
            'sandbox' => array(
                'certificate' => $this->sandboxCertificate,
                'ssl' => $this->sandboxSsl,
                'feedback' => $this->sandboxFeedback
            )
        );
        if ($logPath !== null) {
            $this->logPath = $logPath;
        }
    }

    /**
     * Check Setup
     *
     * Check to make sure that the certificates are available and also provide a notice if they are not as secure as they could be.
     *
     * @access private
     */
    private function checkSetup() {
        if (!file_exists($this->certificate))
            $this->_triggerError('Missing Production Certificate.', E_USER_ERROR);
        if (!file_exists($this->sandboxCertificate))
            $this->_triggerError('Missing Sandbox Certificate.', E_USER_ERROR);

        clearstatcache();
        $certificateMod = substr(sprintf('%o', fileperms($this->certificate)), -3);
        $sandboxCertificateMod = substr(sprintf('%o', fileperms($this->sandboxCertificate)), -3);

        if ($certificateMod > 644)
            $this->_triggerError('Production Certificate is insecure! Suggest chmod 644.');
        if ($sandboxCertificateMod > 644)
            $this->_triggerError('Sandbox Certificate is insecure! Suggest chmod 644.');
    }

    /**
     * Connect the SSL stream (sandbox or production)
     *
     * @param $development string Development environment - sandbox or production
     * @return bool|resource status whether the socket connected or not.
     * @access private
     */
    public function closeSSL() {
        // Close streams and check feedback service
        foreach ($this->sslStreams as $key => $socket) {
            $this->_closeSSLSocket($key);
            //$this->_checkFeedback($key);
        }
    }

    public function openSSL() {
        // Connect the socket the first time it's needed.
        if (!isset($this->sslStreams[$this->development])) {
            $this->_connectSSLSocket($this->development);
        }
    }

    private function _connectSSLSocket($development) {
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->apnsData[$development]['certificate']);
        $this->sslStreams[$development] = stream_socket_client($this->apnsData[$development]['ssl'], $error, $errorString, 100, (STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT), $ctx);
        if (!$this->sslStreams[$development]) {
            $this->_triggerError("Failed to connect to APNS: {$error} {$errorString}.");
            unset($this->sslStreams[$development]);
            return false;
        }
        return $this->sslStreams[$development];
    }

    /**
     * Close the SSL stream (sandbox or production)
     *
     * @param $development string Development environment - sandbox or production
     * @return void
     * @access private
     */
    private function _closeSSLSocket($development) {
        if (isset($this->sslStreams[$development])) {
            fclose($this->sslStreams[$development]);
            unset($this->sslStreams[$development]);
        }
    }

    /**
     * Push APNS Messages
     *
     * This gets called automatically by _fetchMessages.  This is what actually deliveres the message.
     *
     * @param int $pid
     * @param string $message JSON encoded string
     * @param string $token 64 character unique device token tied to device id
     * @param string $development Which SSL to connect to, Sandbox or Production
     * @access private
     */
    private function pushMessage($message, $token) {
        $development = $this->development;
        // Connect the socket the first time it's needed.
        if (!isset($this->sslStreams[$development])) {
            $this->_connectSSLSocket($development);
        }

        $fp = false;
        if (isset($this->sslStreams[$development])) {
            $fp = $this->sslStreams[$development];
        }

        if (!$fp) {
            //$this->_pushFailed($pid);
            $this->_triggerError("A connected socket to APNS wasn't available.");
        } else {
            // "For optimum performance, you should batch multiple notifications in a single transmission over the
            // interface, either explicitly or using a TCP/IP Nagle algorithm."
            // Simple notification format (Bytes: content.) :
            // 1: 0. 2: Token length. 32: Device Token. 2: Payload length. 34: Payload
            //$msg = chr(0).pack("n",32).pack('H*',$token).pack("n",strlen($message)).$message;
            // Enhanced notification format: ("recommended for most providers")
            // 1: 1. 4: Identifier. 4: Expiry. 2: Token length. 32: Device Token. 2: Payload length. 34: Payload
            $expiry = time() + 120; // 2 minute validity hard coded!
            $msg = chr(1) . pack("N", 1) . pack("N", $expiry) . pack("n", 32) . pack('H*', $token) . pack("n", strlen($message)) . $message;

            $fwrite = fwrite($fp, $msg);
            if (!$fwrite) {
                $this->_triggerError("Failed writing to stream.", E_USER_ERROR);
                $this->_closeSSLSocket($development);
            } else { 
                // "Provider Communication with Apple Push Notification Service"
                // http://developer.apple.com/library/ios/#documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/CommunicatingWIthAPS/CommunicatingWIthAPS.html#//apple_ref/doc/uid/TP40008194-CH101-SW1
                // "If you send a notification and APNs finds the notification malformed or otherwise unintelligible, it
                // returns an error-response packet prior to disconnecting. (If there is no error, APNs doesn't return
                // anything.)"
                // 
                // This complicates the read if it blocks.
                // The timeout (if using a stream_select) is dependent on network latency.
                // default socket timeout is 60 seconds
                // Without a read, we leave a false positive on this push's success.
                // The next write attempt will fail correctly since the socket will be closed.
                //
				// This can be done if we start batching the write
                // Read response from server if any. Or if the socket was closed.
                // [Byte: data.] 1: 8. 1: status. 4: Identifier.
                $tv_sec = 1;
                $tv_usec = null; // Timeout. 1 million micro seconds = 1 second
                $r = array($fp);
                $we = null; // Temporaries. "Only variables can be passed as reference."
//echo "<pre>"; print_r($r);die(' 346');
                $numChanged = @stream_select($r, $we, $we, $tv_sec, $tv_usec);
                
                if (false === $numChanged) { die(' 348');
                    $this->_triggerError("Failed selecting stream to read.", E_USER_ERROR);
                } else if ($numChanged > 0) { die(' 350'); 
                    $command = ord(fread($fp, 1));
                    $status = ord(fread($fp, 1));
                    $identifier = implode('', unpack("N", fread($fp, 4)));
                    $statusDesc = array(
                        0 => 'No errors encountered',
                        1 => 'Processing error',
                        2 => 'Missing device token',
                        3 => 'Missing topic',
                        4 => 'Missing payload',
                        5 => 'Invalid token size',
                        6 => 'Invalid topic size',
                        7 => 'Invalid payload size',
                        8 => 'Invalid token',
                        255 => 'None (unknown)',
                    );
                    $this->_triggerError("APNS responded with command($command) status($status) pid($identifier).", E_USER_NOTICE);
//echo $status; die(' jatin');
                    if ($status > 0) {
                        // $identifier == $pid
                        $desc = isset($statusDesc[$status]) ? $statusDesc[$status] : 'Unknown';
                        $this->_triggerError("APNS responded with error for . status($status: $desc)", E_USER_ERROR);
                        // The socket has also been closed. Cause reopening in the loop outside.
                        $this->_closeSSLSocket($development);
                    } else {
                        // Apple docs state that it doesn't return anything on success though
                        //$this->_pushSuccess($pid);
                    }
                } else { //die(' 378');
                    //$this->_pushSuccess($pid);
                }
            }
        }
    }

    private function _triggerError($error, $type = E_USER_NOTICE) {
        //$backtrace = debug_backtrace();
        //$backtrace = array_reverse($backtrace);
        $error .= "\n";
        /* $i=1;
          foreach($backtrace as $errorcode)
          {
          $file = ($errorcode['file']!='') ? "-> File: ".basename($errorcode['file'])." (line ".$errorcode['line'].")":"";
          $error .= "\n\t".$i.") ".$errorcode['class']."::".$errorcode['function']." {$file}";
          $i++;
          }
          $error .= "\n\n"; */

        if ($this->logErrors && file_exists($this->logPath)) {
            if (filesize($this->logPath) > $this->logMaxSize)
                $fh = fopen($this->logPath, 'w');
            else
                $fh = fopen($this->logPath, 'a');
            fwrite($fh, $error);
            fclose($fh);
        }
        if ($this->showErrors)
            trigger_error($error, $type);
    }

    /**
     * JSON Encode
     *
     * Some servers do not have json_encode, so use this instead.
     *
     * @param array $array Data to convert to JSON string.
     * @access private
     * @return string
     */
    private function jsonEncode() {
        $array = $this->message;
        //Using json_encode if exists
        if (function_exists('json_encode')) {
            return json_encode($array);
        }
        if (is_null($array))
            return 'null';
        if ($array === false)
            return 'false';
        if ($array === true)
            return 'true';
        if (is_scalar($array)) {
            if (is_float($array)) {
                return floatval(str_replace(",", ".", strval($array)));
            }
            if (is_string($array)) {
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $array) . '"';
            }
            else
                return $array;
        }
        $isList = true;
        for ($i = 0, reset($array); $i < count($array); $i++, next($array)) {
            if (key($array) !== $i) {
                $isList = false;
                break;
            }
        }
        $result = array();
        if ($isList) {
            foreach ($array as $v)
                $result[] = $this->_jsonEncode($v);
            return '[' . join(',', $result) . ']';
        } else {
            foreach ($array as $k => $v)
                $result[] = $this->_jsonEncode($k) . ':' . $this->_jsonEncode($v);
            return '{' . join(',', $result) . '}';
        }
    }

    /**
     * Add Message Alert
     *
     * <code>
     * <?php
     * $db = new DbConnect('localhost','dbuser','dbpass','dbname');
     * $db->show_errors();
     * $apns = new APNS($db);
     *
     * // SIMPLE ALERT
     * $apns->newMessage(1, '2010-01-01 00:00:00');
     * $apns->addMessageAlert('Message received from Bob'); // MAKES DEFAULT BUTTON WITH BOTH 'Close' AND 'View' BUTTONS
     * $apns->queueMessage();
     *
     * // CUSTOM 'View' BUTTON
     * $apns->newMessage(1, '2010-01-01 00:00:00');
     * $apns->addMessageAlert('Bob wants to play poker', 'PLAY'); // MAKES THE 'View' BUTTON READ 'PLAY'
     * $apns->queueMessage();
     *
     * // NO 'View' BUTTON
     * $apns->newMessage(1, '2010-01-01 00:00:00');
     * $apns->addMessageAlert('Bob wants to play poker', ''); // MAKES AN ALERT WITH JUST AN 'OK' BUTTON
     * $apns->queueMessage();
     *
     * // CUSTOM LOCALIZATION STRING FOR YOUR APP
     * $apns->newMessage(1, '2010-01-01 00:00:00');
     * $apns->addMessageAlert(NULL, NULL, 'GAME_PLAY_REQUEST_FORMAT', array('Jenna', 'Frank'));
     * $apns->queueMessage();
     * ?>
     * </code>
     *
     * @param int $number
     * @access public
     */
    public function addMessage($alert = NULL, $actionlockey = NULL, $lockey = NULL, $locargs = NULL) {
        //$this->message = array();
        //$this->message['aps'] = array();
        switch (true) {
            case (!empty($alert) && empty($actionlockey) && empty($lockey) && empty($locargs)):
                if (!is_string($alert))
                    $this->_triggerError('Invalid Alert Format. See documentation for correct procedure.', E_USER_ERROR);
                $this->message['aps']['alert'] = (string) $alert;
                break;

            case (!empty($alert) && !empty($actionlockey) && empty($lockey) && empty($locargs)):
                if (!is_string($alert))
                    $this->_triggerError('Invalid Alert Format. See documentation for correct procedure.', E_USER_ERROR);
                else if (!is_string($actionlockey))
                    $this->_triggerError('Invalid Action Loc Key Format. See documentation for correct procedure.', E_USER_ERROR);
                $this->message['aps']['alert']['body'] = (string) $alert;
                $this->message['aps']['alert']['action-loc-key'] = (string) $actionlockey;
                break;

            case (empty($alert) && empty($actionlockey) && !empty($lockey) && !empty($locargs)):
                if (!is_string($lockey))
                    $this->_triggerError('Invalid Loc Key Format. See documentation for correct procedure.', E_USER_ERROR);
                $this->message['aps']['alert']['loc-key'] = (string) $lockey;
                $this->message['aps']['alert']['loc-args'] = $locargs;
                break;

            default:
                $this->_triggerError('Invalid Alert Format. See documentation for correct procedure.', E_USER_ERROR);
                break;
        }
    }

    /**
     * Add Message Badge
     *
     * <code>
     * <?php
     * $db = new DbConnect('localhost','dbuser','dbpass','dbname');
     * $db->show_errors();
     * $apns = new APNS($db);
     * $apns->newMessage(1, '2010-01-01 00:00:00');
     * $apns->addMessageBadge(9); // HAS TO BE A NUMBER
     * $apns->queueMessage();
     * ?>
     * </code>
     *
     * @param int $number
     * @access public
     */
    public function addMessageBadge($number = NULL) {
        if (!$this->message)
            $this->_triggerError('Must use addMessage() before calling this method.', E_USER_ERROR);
        if ($number) {
            //if(isset($this->message['aps']['badge'])) $this->_triggerError('Message Badge has already been created. Overwriting with '.$number.'.');
            $this->message['aps']['badge'] = $number;
        } else {
            $this->message['aps']['badge'] = '0';
        }
    }

    /**
     * Add Message Custom
     *
     * <code>
     * <?php
     * $db = new DbConnect('localhost','dbuser','dbpass','dbname');
     * $db->show_errors();
     * $apns = new APNS($db);
     * $apns->newMessage(1, '2010-01-01 00:00:00');
     * $apns->addMessageCustom('acme1', 42); // CAN BE NUMBER...
     * $apns->addMessageCustom('acme2', 'foo'); // ... STRING
     * $apns->addMessageCustom('acme3', array('bang', 'whiz')); // OR ARRAY
     * $apns->queueMessage();
     * ?>
     * </code>
     *
     * @param string $key Name of Custom Object you want to pass back to your iPhone App
     * @param mixed $value Mixed Value you want to pass back.  Can be int, bool, string, or array.
     * @access public
     */
    public function addMessageCustom($key = NULL, $value = NULL) {
        if (!$this->message)
            $this->_triggerError('Must use addMessage() before calling this method.', E_USER_ERROR);
        if (!empty($key) && !empty($value)) {
            if (isset($this->message[$key])) {
                unset($this->message[$key]);
                $this->_triggerError('This same Custom Key already exists and has not been delivered. The previous values have been removed.');
            }
            if (!is_string($key))
                $this->_triggerError('Invalid Key Format. Key must be a string. See documentation for correct procedure.', E_USER_ERROR);
            $this->message[$key] = $value;
        }
    }
    
    public function addMessageAlert($msg = NULL) {
        if (!$this->message)
            $this->_triggerError('Must use addMessage() before calling this method.', E_USER_ERROR);
        if (!empty($msg)) {
            if (isset($this->message[$msg])) {
                unset($this->message[$msg]);
                $this->_triggerError('This same Custom Key already exists and has not been delivered. The previous values have been removed.');
            }
            if (!is_string($msg))
                $this->_triggerError('Invalid Key Format. Key must be a string. See documentation for correct procedure.', E_USER_ERROR);
            $this->message["push_value"]["message"]["body"]["text"] = $msg;
        }
    }

    /**
     * Add Message Sound
     *
     * <code>
     * <?php
     * $db = new DbConnect('localhost','dbuser','dbpass','dbname');
     * $db->show_errors();
     * $apns = new APNS($db);
     * $apns->newMessage(1, '2010-01-01 00:00:00');
     * $apns->addMessageSound('bingbong.aiff'); // STRING OF FILE NAME
     * $apns->queueMessage();
     * ?>
     * </code>
     *
     * @param string $sound Name of sound file in your Resources Directory
     * @access public
     */
    public function addMessageSound($sound = NULL) {
        if (!$this->message)
            $this->_triggerError('Must use addMessage() before calling this method.', E_USER_ERROR);
        if ($sound) {
            if (isset($this->message['aps']['sound']))
                $this->_triggerError('Message Sound has already been created. Overwriting with ' . $sound . '.');
            $this->message['aps']['sound'] = (string) $sound;
        }
    }

    public function test($devices = array()) {

        $message = $this->jsonEncode();
        echo $message;
        //pr($devices);
        $this->openSSL();
        foreach ($devices as $token) {
            $resultArr[] = $this->pushMessage($message, $token);
        }
        $this->closeSSL();
        //pr($resultArr);
        exit();
    }

    public function sendPushNotificationDeal($udid = '') {
        //error_reporting(0);

        $this->openSSL();
        $message = $this->jsonEncode();
        echo $message;
        echo "<br>";
        echo $udid;
        $this->pushMessage($message, $udid);
        $this->closeSSL();
    }

    /* public function sendPushNotificationDeal($devices=array())
      {
      //echo $message;
      //echo "<pre>";
      //print_r($devices);
      error_reporting(0);
      $this->openSSL();
      foreach($devices as $udid)
      {
      $this->addMessageBadge($udid['badge']);
      $message=$this->jsonEncode();
      $this->pushMessage($message,$udid['udid']);
      }
      $this->closeSSL();
      } */

    public function sendPushNotificationCron($udid = '') {
        error_reporting(0);
        $this->openSSL();
        $message = $this->jsonEncode();
        $this->pushMessage($message, $udid);
        $this->closeSSL();
    }

    public function sendPushNotification($devices = array()) {
//        echo $message;
//        echo "<pre>";
//        print_r($devices); die(' 684');
        //error_reporting(0);
        /* $this->openSSL();
          foreach($devices as $udid)
          {
          $this->addMessageBadge($udid['badge']);
          $message=$this->jsonEncode();
          $this->pushMessage($message,$udid['udid']);
          }
          $this->closeSSL(); */
        //pr($devices);
        
        $message = $this->jsonEncode();
//        $this->logErrors($message);
        $this->openSSL();
        foreach ($devices as $token) {
            //echo "<br>" . $token;
          
            $this->pushMessage($message, $token);
        } 
        $this->closeSSL();
    }

    public function sendPushNotificationReminder($devices = array()) {
        //echo $message;
        //echo "<pre>";
        //print_r($devices);
        error_reporting(0);
        $this->openSSL();
        foreach ($devices as $udid) {
            $this->addMessageBadge($udid['badge']);
            $this->addMessage($udid['message']);
            $message = $this->jsonEncode();
            $this->pushMessage($message, $udid['udid']);
        }
        $this->closeSSL();
    }

    public function sendPushNotificationBroadCast($devices = array()) {
        //error_reporting(0);
        $this->openSSL();
        foreach ($devices as $udid) {
            $this->addMessageCustom('related_id', $udid['related_id']);
            $this->addMessageCustom('push_type', $udid['push_type']);
            $this->addMessageBadge($udid['badge']);
            $this->addMessageSound('default');
            $this->addMessage($udid['message']);
            $message = $this->jsonEncode();
            $this->pushMessage($message, $udid['udid']);
        }
        $this->closeSSL();
    }

}

?>