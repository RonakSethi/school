<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class AjaxController extends AppController {

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array('Text', 'Js', 'Time');

    /**
     *
     * Model
     *  
     */
    public $uses = array('User', 'Category', 'UserSetting', 'Theme', 'StudioCalendar');

    /**
     * Components
     *
     * @var array
     */
    //public $components = array('Common', 'Schedule');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('isDuplicateUserEmail', 'info', 'isDuplicatephone', 'addEvent', 'getEvents', 'getYearList', 'getAllMonths', 'getCalender');
    }

    /**
     * Admin process
     *
     * @return Bool
     * @access public
     */
    public function isDuplicateUserEmail() {
        $this->layout = false;
        $userExist = '';
        $conditions = array();
        if (isset($this->request->data['remoteId']) && $this->request->data['remoteId'] != "undefined") {
            $conditions['User.id !='] = $this->request->data['remoteId'];
        }
        if (isset($this->request->data['User']['email']) && !empty($this->request->data['User']['email'])) {
            $conditions['User.email'] = $this->request->data['User']['email'];
            $userExist = $this->User->find('count', array('conditions' => $conditions));
        }
        if ($userExist > 0) {
            echo "false";
        } else {
            echo "true";
        }
        $this->autoLayout = false;
        $this->autoRender = false;
    }

    public function isDuplicatephone() {
        $this->layout = false;
        $userExist = '';
        $conditions = array();
        if (isset($this->request->data['remoteId']) && $this->request->data['remoteId'] != "undefined") {
            $conditions['User.id !='] = $this->request->data['remoteId'];
        }
        if (isset($this->request->data['User']['phone']) && !empty($this->request->data['User']['phone'])) {
            $conditions['User.phone'] = $this->request->data['User']['phone'];
            $userExist = $this->User->find('count', array('conditions' => $conditions));
        }
        if ($userExist > 0) {
            echo "false";
        } else {
            echo "true";
        }
        $this->autoLayout = false;
        $this->autoRender = false;
    }

    /**
     * Admin process
     *
     * @return Bool
     * @access public
     */
    public function isDuplicateMembershipName() {
        $this->layout = false;
        $membershipExist = '';
        $conditions = array();
        if (isset($this->request->data['remoteId']) && $this->request->data['remoteId'] != "undefined") {
            $conditions['Membership.id !='] = $this->request->data['remoteId'];
        }
        if (isset($this->request->data['Membership']['name']) && !empty($this->request->data['Membership']['name'])) {
            $conditions['Membership.name'] = $this->request->data['Membership']['name'];
            $membershipExist = $this->Membership->find('count', array('conditions' => $conditions));
        }
        if ($membershipExist > 0) {
            echo "false";
        } else {
            echo "true";
        }
        $this->autoLayout = false;
        $this->autoRender = false;
    }

    /**
     * Admin process
     *
     * @return Bool
     * @access public
     */
    public function isDuplicateExerciseName() {
        $this->layout = false;
        $exerciseExist = '';
        $conditions = array();
        if (isset($this->request->data['remoteId']) && $this->request->data['remoteId'] != "undefined") {
            $conditions['Exercise.id !='] = $this->request->data['remoteId'];
        }
        if (isset($this->request->data['Exercise']['name']) && !empty($this->request->data['Exercise']['name'])) {
            $conditions['Exercise.name'] = $this->request->data['Exercise']['name'];
            $exerciseExist = $this->Exercise->find('count', array('conditions' => $conditions));
        }
        if ($exerciseExist > 0) {
            echo "false";
        } else {
            echo "true";
        }
        $this->autoLayout = false;
        $this->autoRender = false;
    }

    public function info() {
        $this->layout = false;
        $this->autoRender = false;
        $model = $this->request->data['model'];
        $field = $this->request->data['field'];
        $fieldValue = $this->request->data[$model][$field];
        $this->loadModel($model);
        $count = $this->$model->find('count', array('conditions' => array($model . '.' . $field => $fieldValue)));
        if ($count == 0) {
            exit('true');
        } else {
            exit('false');
        }
    }

    function status() {
        $this->layout = false;
        $this->autoRender = false;
        if ($this->request->is(array('post', 'put', 'ajax'))) {
            $model = $this->request->data['model'];
            $id = $this->request->data['model_id'];
            $status = $this->request->data['status'];
            $this->loadModel($model);
            $this->$model->id = $id;
            $data[$model]['status'] = $status;
            if ($this->$model->save($data)) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            $this->redirect('/');
        }
    }

    function verify() {
        $this->layout = false;
        $this->autoRender = false;
        if ($this->request->is(array('post', 'put', 'ajax'))) {
            $model = $this->request->data['model'];
            $id = $this->request->data['model_id'];
            $status = $this->request->data['status'];
            $this->loadModel($model);
            $this->$model->id = $id;
            $data[$model]['is_approved'] = $status;
            if ($this->$model->save($data)) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            $this->redirect('/');
        }
    }

    function get_filter() {
        $this->layout = false;
        $this->autoRender = false;
        if ($this->request->is(array('post', 'put', 'ajax'))) {
            $this->Category->recursive = 3;
            $categories = $this->Category->find('first', array('conditions' => array('Category.status' => 1, 'Category.id' => $this->request->data['category'])));
            $temp = $subArr = $subArr2 = $subArr3 = $subArr4 = array();
            if (isset($categories['SubCategory']) && !empty($categories['SubCategory'])) {
                foreach ($categories['SubCategory'] as $category) {
                    $subArr = $subArr3 = $subArr4 = array();
                    if (!empty($category['SubCategory'])) {
                        foreach ($category['SubCategory'] as $value) {
                            $subArr4 == array();
                            $subArr4[$value['id']] = $value['name'];
                        }
                        $subArr2[$category['name']] = $subArr4;
                    } else {
                        $subArr2[$category['id']] = $category['name'];
                    }
                }
            }

            if (!empty($subArr2)) {
                $view = new View($this, false);
                $content = $view->element('filter', array('data' => $subArr2));
                $sendArray['replyCode'] = 'success';
                $sendArray['content'] = $content;
            } else {
                $sendArray['replyCode'] = 'error';
                $sendArray['content'] = '<p class="no-filter">No Filter for this category.</p>';
            }
            echo json_encode($sendArray);
            // pr($subArr2);
        }
    }

    function change_settings() {
        $this->layout = false;
        $this->autoRender = false;
        $user_setting = $this->UserSetting->findByTypeAndUserId($this->request->data['type'], $this->Session->read('Auth.User.id'));
        if (!empty($user_setting)) {
            $result = $this->UserSetting->updateAll(array('UserSetting.theme_id' => $this->request->data['theme']), array('UserSetting.user_id' => $this->Session->read('Auth.User.id'), 'UserSetting.type' => $this->request->data['type']));
        } else {
            $user_setting['UserSetting']['theme_id'] = $this->request->data['theme'];
            $user_setting['UserSetting']['user_id'] = $this->Session->read('Auth.User.id');
            $user_setting['UserSetting']['type'] = $this->request->data['type'];
            $result = $this->UserSetting->save($user_setting);
        }
        $theme = $this->Theme->findById($this->request->data['theme'], array('Theme.id', 'Theme.image'));
        if ($result) {
            $arr = array('replyCode' => 1, 'contentId' => $theme['Theme']['id'], 'content' => $theme['Theme']['image']);
        } else {
            $arr = array('replyCode' => 0, 'contentId' => '', 'content' => '');
        }
        echo json_encode($arr);
    }

    function validate_category_slug() {
        $this->layout = false;
        $this->autoRender = false;

        $conditions = array();
        $slug = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', trim(strtolower($this->request->data['Category']['name'])))));

        $conditions[] = array('Category.slug' => $slug);

        if (isset($this->request->data['Category']['id'])) {
            $id = $this->request->data['Category']['id'];
            $conditions[] = array('Category.id <>' => $id);
        }
        $slugExist = $this->Category->find('count', array('conditions' => $conditions));

        if ($slugExist) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }

    function featuredPost() {
        $this->layout = false;
        $this->autoRender = false;
        if ($this->request->is(array('post', 'put', 'ajax'))) {
            $model = $this->request->data['model'];
            $id = $this->request->data['model_id'];
            $status = $this->request->data['status'];
            $this->loadModel($model);
            $this->$model->id = $id;
            $data[$model]['is_featured'] = $status;

            if ($this->$model->save($data)) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            $this->redirect('/');
        }
    }

    public function isDuplicateCheckInCode() {
        $this->layout = false;
        $userExist = '';
        $conditions = array();
        if (isset($this->request->data['remoteId']) && $this->request->data['remoteId'] != "undefined") {
            $conditions['User.id !='] = $this->request->data['remoteId'];
        }
        if (isset($this->request->data['User']['check_in_code']) && !empty($this->request->data['User']['check_in_code'])) {
            $conditions['User.check_in_code'] = $this->request->data['User']['check_in_code'];
            $userExist = $this->User->find('count', array('conditions' => $conditions));
        }
        if ($userExist > 0) {
            echo "false";
        } else {
            echo "true";
        }
        $this->autoLayout = false;
        $this->autoRender = false;
    }

    /*
     * Get months options list.
     */

    function getAllMonths($selected = '') {
        $options = '';
        for ($i = 1; $i <= 12; $i++) {
            $value = ($i < 01) ? '0' . $i : $i;
            $selectedOpt = ($value == $selected) ? 'selected' : '';
            $options .= '<option value="' . $value . '" ' . $selectedOpt . ' >' . date("F", mktime(0, 0, 0, $i + 1, 0, 0)) . '</option>';
        }
        return $options;
    }

    /*
     * Get years options list.
     */

    function getYearList($selected = '') {
        $options = '';
        for ($i = 2015; $i <= 2025; $i++) {
            $selectedOpt = ($i == $selected) ? 'selected' : '';
            $options .= '<option value="' . $i . '" ' . $selectedOpt . ' >' . $i . '</option>';
        }
        return $options;
    }

    /*
     * Get events by date
     */

    function getEvents($date = '') {
        $this->layout = false;
        $this->autoRender = false;
        //Include db configuration file
        $eventListHTML = '';
        $date = $this->request->data['date'];
        $date = $date ? $date : date("Y-m-d");
        //Get events based on the current date
        $result = $this->StudioCalendar->find('first', array('conditions' => array('status' => 1, 'date' => $date, 'studio_id' => $this->request->data['studioId']),'fields'=>array('id','studio_id','date','start_time','end_time','status','DATE_FORMAT(StudioCalendar.start_time, "%H:%i ") as format_start_time','DATE_FORMAT(StudioCalendar.end_time, "%H:%i ") as format_end_time')));

        if (count($result) > 0) {
            $eventListHTML = '  <div id="event_edit">';
            $eventListHTML .= '<h2>Availability on ' . date("l, d M Y", strtotime($date)) . '</h2>';
            $eventListHTML .= '<p><b>Availability : </b><span class="slider-time">' . $result[0]['format_start_time'] . '</span> - <span class="slider-time2">' . $result[0]['format_end_time'] . '</span><div class="sliders_step1"><div id="slider-range"></div></div><input type="hidden" id="se_start_time" value="' . $result['StudioCalendar']['start_time'] . '"/><input type="hidden" id="se_end_time" value="' . $result['StudioCalendar']['end_time'] . '"/></p><input type="hidden" name="id" id="studioDateId" value="' . $result['StudioCalendar']['id'] . '"/><input type="hidden" id="eventDate" value="'.$date.'"/><input type="button" id="editEventBtn" value="Update"/></div>';
            
           
        }
        
        echo $eventListHTML;
    }

    /*
     * Add event to date
     */

    function addEvent($date = null, $title = null) {
        $this->layout = false;
        $this->autoRender = false;
        //Include db configuration file
        $currentDate = date("Y-m-d");

        $this->request->data['StudioCalendar'] = array(
            'studio_id' => $this->request->data['studioId'],
            'start_time' => $this->request->data['startTime'],
            'end_time' => $this->request->data['endTime'],
            'date' => $this->request->data['date'],
            'modified' => $currentDate
        );
        if ($this->request->data['func'] == 'editEvent') {
            //Update cal availability
            $this->request->data['StudioCalendar']['id'] = $this->request->data['studioCalId'];
        } else {
            //Insert the event data into database
            $this->request->data['StudioCalendar']['created'] = $currentDate;
        }

        if ($this->StudioCalendar->save($this->request->data['StudioCalendar'])) {
            echo 'ok';
        } else {
            echo 'err';
        }
    }

    function getCalender($year = '', $month = '', $studioId = '') {
        $this->autoRender = false;
        $this->StudioCalendar = ClassRegistry::init('StudioCalendar');
        $dateYear = ($year != '') ? $year : date("Y");
        $dateMonth = ($month != '') ? $month : date("m");
        $date = $dateYear . '-' . $dateMonth . '-01';
        $currentMonthFirstDay = date("N", strtotime($date));
        $totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN, $dateMonth, $dateYear);
        $totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7) ? ($totalDaysOfMonth) : ($totalDaysOfMonth + $currentMonthFirstDay);
        $boxDisplay = ($totalDaysOfMonthDisplay <= 35) ? 35 : 42;
        ?>

        <div id="calender_section">
            <h2>
                <input type="hidden" id="studio_id" value="<?php echo $studioId; ?>"/>
                <a href="javascript:void(0);" onclick="getCalendar('calendar_div', '<?php echo date("Y", strtotime($date . ' - 1 Month')); ?>', '<?php echo date("m", strtotime($date . ' - 1 Month')); ?>', '<?php echo $studioId ?>');">&lt;&lt;</a>
                <select name="month_dropdown" class="month_dropdown dropdown"><?php echo $this->getAllMonths($dateMonth); ?></select>
                <select name="year_dropdown" class="year_dropdown dropdown"><?php echo $this->getYearList($dateYear); ?></select>
                <a href="javascript:void(0);" onclick="getCalendar('calendar_div', '<?php echo date("Y", strtotime($date . ' + 1 Month')); ?>', '<?php echo date("m", strtotime($date . ' + 1 Month')); ?>', '<?php echo $studioId ?>');">&gt;&gt;</a>
            </h2>
            <div id="event_list" class="none"></div>
            <!--For Add Event-->
              <div id="event_add" class="none">
                <p>Studio Availability on <span id="eventDateView"></span></p>
                 <p>Availability : <span class="slider-time">00:00</span> - <span class="slider-time2">23:45</span></p>
    <div class="sliders_step1">
        <div id="slider-range"></div>
    </div>
                <input type="hidden" id="studio_start_time" value=""/> 
                <input type="hidden" id="studio_end_time" value=""/>
                <input type="hidden" id="eventDate" value=""/>
                <input type="button" id="addEventBtn" value="Add"/>
            </div>
            <div id="calender_section_top">
                <ul>
                    <li>Sun</li>
                    <li>Mon</li>
                    <li>Tue</li>
                    <li>Wed</li>
                    <li>Thu</li>
                    <li>Fri</li>
                    <li>Sat</li>
                </ul>
            </div>
            <div id="calender_section_bot">
                <ul>
                    <?php
                    $dayCount = 1;
                    for ($cb = 1; $cb <= $boxDisplay; $cb++) {
                        if (($cb >= $currentMonthFirstDay + 1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)) {
                            //Current date
                            $currentDate = $dateYear . '-' . $dateMonth . '-' . $dayCount;
                            $eventNum = 0;
                            $result = $this->StudioCalendar->find('first', array('conditions' => array('status' => 1, 'date' => $currentDate, 'studio_id' => $studioId),'fields'=>array('id','studio_id','date','start_time','end_time','status','DATE_FORMAT(StudioCalendar.start_time, "%h:%i %p") as format_start_time','DATE_FORMAT(StudioCalendar.end_time, "%h:%i %p") as format_end_time')));
                          
                            $eventNum = count($result);
                            //Define date cell color
                            if (strtotime($currentDate) == strtotime(date("Y-m-d"))) {
                                echo '<li date="' . $currentDate . '" class="grey date_cell">';
                            } elseif ($eventNum > 0) {
                                echo '<li date="' . $currentDate . '" class="light_sky date_cell"><span> ' . $result[0]['format_start_time'] . ' - ' . $result[0]['format_end_time'].'</span>';
                            } else {
                                echo '<li date="' . $currentDate . '" class="date_cell">';
                            }
                            //Date cell
                            echo '<span>';
                            echo $dayCount;
                            echo '</span>';

                            //Hover event popup
                            echo '<div id="date_popup_' . $currentDate . '" class="date_popup_wrap none">';
                            echo '<div class="date_window">';

                            echo ($eventNum > 0) ? '<a href="javascript:;" onclick="getEvents(\'' . $currentDate . '\');">Edit avaliablity</a><br/>' : '';
                            //For Add Event
                          echo ($eventNum > 0)?"":'<a href="javascript:;" onclick="addEvent(\''.$currentDate.'\');">add availability</a>';
                            echo '</div></div>';

                            echo '</li>';
                            $dayCount++;
                            ?>
                        <?php } else { ?>
                            <li><span>&nbsp;</span></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

        <script type="text/javascript">
            timepicker();
            function getCalendar(target_div, year, month, studioId) {
                $.ajax({
                    type: 'POST',
                    url: SITE_URL + "ajax/getCalender/" + year + '/' + month + '/' + studioId,
                    data: 'func=getCalender&year=' + year + '&month=' + month,
                    success: function (html) {
                        $('#' + target_div).html('');
                        $('#' + target_div).html(html);
                        reloadAtdropdown();
                    }
                });
            }

            function getEvents(date) {
                $.ajax({
                    type: 'POST',
                    url: SITE_URL + "ajax/getEvents",
                    data: 'func=getEvents&date=' + date + '&studioId=' + $('#studio_id').val(),
                    success: function (html) {
                        $('#event_list').html(html);
                        $('#event_add').slideUp('slow');
                        $('#event_list').slideDown('slow');
                        reloadAtdropdown()
                         timepicker();
                    }
                });
            }
            //For Add Event
            function addEvent(date) {
                $('#eventDate').val(date);
                $('#eventDateView').html(date);
                $('#event_list').slideUp('slow');
                $('#event_add').slideDown('slow');
            }
            //For Add Event
            $(document).ready(function () {
                reloadAtdropdown();
                timepicker();
            });



            function reloadAtdropdown() {
                $('#addEventBtn').on('click', function () {
                    var date = $('#eventDate').val();
                    var startTime = $('#studio_start_time').val();
                    var endTime = $('#studio_end_time').val();
                    $.ajax({
                        type: 'POST',
                        url: SITE_URL + "ajax/addEvent",
                        data: 'func=addEvent&date=' + date + '&startTime=' + startTime + '&endTime=' + endTime + '&studioId=' + $('#studio_id').val(),
                        success: function (msg) {
                            if (msg == 'ok') {
                                timepicker();
                                var dateSplit = date.split("-");
                                $('#studio_start_time').val('');
                                $('#studio_end_time').val('');
                               
                                alert('Event Created Successfully.');
                                getCalendar('calendar_div', dateSplit[0], dateSplit[1], $('#studio_id').val());

                            } else {
                                alert('Some problem occurred, please try again.');
                            }
                        }
                    });
                });
                $('#editEventBtn').on('click', function () {
                    var date = $('#eventDate').val();
                    var startTime = $('#se_start_time').val();
                    var studioCalId = $('#studioDateId').val();
                    var endTime = $('#se_end_time').val();
                    $.ajax({
                        type: 'POST',
                        url: SITE_URL + "ajax/addEvent",
                        data: 'func=editEvent&date=' + date + '&startTime=' + startTime + '&endTime=' + endTime + '&studioCalId=' + studioCalId + '&studioId=' + $('#studio_id').val(),
                        success: function (msg) {
                            studioCalId
                            if (msg == 'ok') {
                                timepicker();
                                console.log("date in event edit"+date)
                                var dateSplit = date.split("-");
                                $('#studio_start_time').val('');
                                $('#studio_end_time').val('');
                                alert('Event Update Successfully.');
                                getCalendar('calendar_div', dateSplit[0], dateSplit[1], $('#studio_id').val());

                            } else {
                                alert('Some problem occurred, please try again.');
                            }
                        }
                    });
                });

                $('.date_cell').mouseenter(function () {
                    date = $(this).attr('date');
                    $(".date_popup_wrap").fadeOut();
                    $("#date_popup_" + date).fadeIn();
                });
                $('.date_cell').mouseleave(function () {
                    $(".date_popup_wrap").fadeOut();
                });
                $('.month_dropdown').on('change', function () {

                    getCalendar('calendar_div', $('.year_dropdown').val(), $('.month_dropdown').val(), $('#studio_id').val());
                });
                $('.year_dropdown').on('change', function () {
                    getCalendar('calendar_div', $('.year_dropdown').val(), $('.month_dropdown').val(), $('#studio_id').val());
                });
                $(document).click(function () {
                    //  $('#event_list').slideUp('slow');
                });
            }
        </script>
        <?php
        die;
    }
}
