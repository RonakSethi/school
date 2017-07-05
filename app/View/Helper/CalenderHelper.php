<?php
/*
 * Function requested by Ajax
 */

App::uses('Helper', 'View');

class CalenderHelper extends AppHelper {
    /*
     * Get calendar full HTML
     */

    function getCalender($year = '', $month = '', $studioId = '') {

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
                            //Get number of events based on the current date
                            $result = $this->StudioCalendar->find('first', array('conditions' => array('status' => 1, 'date' => $currentDate, 'studio_id' => $studioId),'fields'=>array('id','studio_id','date','start_time','end_time','status','DATE_FORMAT(StudioCalendar.start_time, "%h:%i %p") as format_start_time','DATE_FORMAT(StudioCalendar.end_time, "%h:%i %p") as format_end_time')));
                            $eventNum = count($result);

                            //Define date cell color
                            if (strtotime($currentDate) == strtotime(date("Y-m-d"))) {
                                echo '<li date="' . $currentDate . '" class="grey date_cell">';
                            } elseif ($eventNum > 0) {
                                echo '<li date="' . $currentDate . '" class="light_sky date_cell"><span>' . $result[0]['format_start_time'] . ' - ' . $result[0]['format_end_time'].'</span>';
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

                            echo ($eventNum > 0) ? '<a href="javascript:;" onclick="getEvents(\'' . $currentDate . '\');">Edit availability</a><br/>' : '';
                            //For Add Event
                            echo ($eventNum > 0) ? "" : '<a href="javascript:;" onclick="addEvent(\'' . $currentDate . '\');">add availability</a>';
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

            function getCalendar(target_div, year, month, studioId) {
                $.ajax({
                    type: 'POST',
                    url: SITE_URL + "ajax/getCalender/" + year + '/' + month + '/' + studioId,
                    data: 'func=getCalender&year=' + year + '&month=' + month + '&studioId=' + studioId,
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
                        reloadAtdropdown();
                       timepicker()
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
                                var dateSplit = date.split("-");
                                $('#studio_start_time').val('');
                                $('#studio_end_time').val('');
                                alert('Event Created Successfully.');
                                getCalendar('calendar_div', dateSplit[0], dateSplit[1], $('#studio_id').val());
                                reloadAtdropdown();
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
            });

            $(document).ready(function () {
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
                    //$('#event_list').slideUp('slow');
                });
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

}
?>