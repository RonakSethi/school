$(document).ready(function () {
    /* Few More Validation Methods */
    $.validator.addMethod('integer', function (value, element, param) {
        return (value != "0") && (value == parseInt(value, 10)) && (value > 0);
    }, 'Please enter a non zero integer value!');

    $.validator.addMethod('integerd', function (value, element, param) {
        return (value == "") || (value == parseInt(value, 10)) && (value > 0);
    }, 'Please enter a non zero integer value!');

    $.validator.addMethod('mindatestarttime', function (value, element, param) {
        value = value.replace(/\-/g, '/');

        var fieldDate = new Date(value);
        var currentDate = new Date();

        var msDateF = Date.UTC(fieldDate.getFullYear(), fieldDate.getMonth() + 1, fieldDate.getDate(), fieldDate.getHours());
        var msDateC = Date.UTC(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate(), currentDate.getHours());

        return (msDateF >= msDateC);
    }, 'Please specify a recent date');

    $.validator.addMethod('mindateendtime', function (value, element, param) {
        value = value.replace(/\-/g, '/');

        var fieldDate = new Date(value);
        var startDate = $('#SpeedMeetingStartTime').val();
        startDate = startDate.replace(/\-/g, '/');
        startDate = new Date(startDate);

        var msDate1 = Date.UTC(fieldDate.getFullYear(), fieldDate.getMonth() + 1, fieldDate.getDate(), fieldDate.getHours());
        var msDate2 = Date.UTC(startDate.getFullYear(), startDate.getMonth() + 1, startDate.getDate(), startDate.getHours());

        return (msDate1 > msDate2);
    }, 'Please specify a recent date');

    $.validator.addMethod('mindatestartleveltime', function (value, element, param) {
        value = value.replace(/\-/g, '/');

        var fieldDate = new Date(value);
        var endDate = $('#SupplierLevelEndDate').val();
        endDate = endDate.replace(/\-/g, '/');
        endDate = new Date(endDate);
        var currentDate = new Date();

        var msDateC = Date.UTC(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate(), currentDate.getHours());
        var msDate1 = Date.UTC(fieldDate.getFullYear(), fieldDate.getMonth() + 1, fieldDate.getDate(), fieldDate.getHours());
        var msDate2 = Date.UTC(endDate.getFullYear(), endDate.getMonth() + 1, endDate.getDate(), endDate.getHours());

        return (msDate1 < msDate2 && msDate1 >= msDateC);
    }, 'Please specify a recent date');

    $.validator.addMethod('mindate', function (value, element, param) { //alert(value);

        Date.prototype.yyyymmdd = function () {

            var yyyy = this.getFullYear().toString();
            var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based         
            var dd = this.getDate().toString();

            return yyyy + '-' + (mm[1] ? mm : "0" + mm[0]) + '-' + (dd[1] ? dd : "0" + dd[0]);
        };

        todayD = new Date();

        var nowTemp = new Date();
        now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var tod = todayD.yyyymmdd();


        ValueD = new Date(value);

        TimeStampCurr = now.valueOf();

        TimeStampValue = ValueD.valueOf();

        return (TimeStampValue >= TimeStampCurr);

        // return minDate <= curDate;
    }, 'Please specify a recent date');

    //URL Validation
    $.validator.addMethod("url", function (value, element) {
        var urlPattern = /^((https?:\/\/)|(www\.))([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \?=.-]*)*\/?$/;
        return this.optional(element) || urlPattern.test(value);
    }, "Please enter valid URL. Example : http://example.com or www.example.com");

    $.validator.addMethod('charlimit', function (value, element, param) {
        return (value.length < 600);
    }, 'Please enter a non zero integer value!');


// Login Form
    $('#UserAdminLoginForm').validate({
        rules: {
            'data[User][email]': {
                required: true, 
                email: true
            },
            'data[User][password]': {
                required: true, minlength: 6
            }
        },
        messages: {
            
        },
        submitHandler: function (form) {
            // do other things for a valid form
            $('input[type="submit"]').attr('disabled', 'disabled');
            form.submit();
        }


    });


    $('#updatePassword').validate({
        rules: {
            'data[User][password]': {
                required: true, minlength: 6
            },
            'data[User][re_password]': {
                required: true, equalTo: "#UserPassword123", minlength: 6
            },
        },
        messages: {
        },
        submitHandler: function (form) {
            // do other things for a valid form
            $('input[type="submit"]').attr('disabled', 'disabled');
            form.submit();
        }


    });

    $('#EditTemplate').validate({
        rules: {
            'data[EmailTemplate][title]': {
                required: true
            },
            'data[EmailTemplate][email_type]': {
                required: true
            },
            'data[EmailTemplate][sender_name]': {
                required: true
            },
            'data[EmailTemplate][sender_email]': {
                required: true
            },
            'data[EmailTemplate][subject]': {
                required: true
            },
            'data[EmailTemplate][message]': {
                required: true
            },
        },
        messages: {
        },
        submitHandler: function (form) {
            // do other things for a valid form
            $('input[type="submit"]').attr('disabled', 'disabled');
            form.submit();
        }


    });

    $('#UserAdminSignupForm').validate({
        rules: {
            'data[User][first_name]': {
                required: true
            },
            'data[User][last_name]': {
                required: true
            },
            'data[User][term&conditions]': {
                required: true
            },
            'data[User][phone]': {
                required: true,
                number: true,
                remote: {
                    url: SITE_URL + "ajax/isDuplicatephone",
                    type: "post",
                    data: {
                        remote: function ()
                        {
                            return $('#UserPhone').val();
                        },
                        remoteId: function ()
                        {
                            if ($('#UserId').val() != '')
                                return $('#UserId').val();
                            else
                                return 'nocheck';
                        }
                    }},
            },
            'data[User][email]': {
                required: true,
                email: true,
                remote: {
                    url: SITE_URL + "ajax/isDuplicateUserEmail",
                    type: "post",
                    data: {
                        remote: function ()
                        {
                            return $('#UserEmail').val();
                        },
                        remoteId: function ()
                        {
                            if ($('#UserId').val() != '')
                                return $('#UserId').val();
                            else
                                return 'nocheck';
                        }
                    }},
            },
            'data[User][password]': {
                required: true, minlength: 6
            },
            'data[User][conf_password]': {
                required: true,
                equalTo: "#UserPassword",
                minlength: 6
            },
        },
        messages: {
            'data[User][first_name]': {
                required: 'Please enter first name',
            },
            'data[User][last_name]': {
                required: 'Please enter last name',
            },
            'data[User][phone]': {
                required: 'Please enter phone',
            },
            'data[User][email]': {
                required: 'Please enter email',
            },
            'data[User][term&conditions]': {
                required: 'Please agree on terms & conditions',
            },
            'data[User][password]': {
                required: 'Please enter password',
                minlength: 'Password atleast 6 character long'
            },
            'data[User][conf_password]': {
                required: 'Please enter confirm password',
                equalTo: 'Password and confirm password does not match',
                minlength: 'Password atleast 6 character long'
            },
        },
        submitHandler: function (form) {
            // do other things for a valid form
            $('input[type="submit"]').attr('disabled', 'disabled');
            form.submit();
        }
    });

    $('#UserAdminEditForm').validate({
        rules: {
            'data[User][first_name]': {
                required: true
            },
            'data[User][last_name]': {
                required: true
            },
            'data[User][username]': {
                required: true
            },
            'data[User][email]': {
                required: true
            },
            'data[User][color_code]': {
                required: true
            },
            'data[User][header_image]': {
                required: true,
            },
            'data[User][logo]': {
                required: true
            },
        },
        messages: {
        },
        submitHandler: function (form) {
            // do other things for a valid form
            $('input[type="submit"]').attr('disabled', 'disabled');
            form.submit();
        }


    });

    $('#CategoryAdminAddForm').validate({
        rules: {
            'data[Category][cat_name]': {
                required: true
            },
        },
        messages: {
            'data[User][cat_name]': {
                required: 'Please enter category name',
            }
        }


    });

    $('#CategoryAdminEditForm').validate({
        rules: {
            'data[Category][cat_name]': {
                required: true
            },
        },
        messages: {
            'data[User][cat_name]': {
                required: 'Please enter category name',
            }
        }


    });

    $('#StudioTypeAdminAddForm').validate({
        rules: {
            'data[StudioType][studio_type_name]': {
                required: true
            },
        },
        messages: {
            'data[StudioType][studio_type_name]': {
                required: 'Please enter studio type',
            }
        }
    });

    $('#StudioTypeAdminEditForm').validate({
        rules: {
            'data[StudioType][studio_type_name]': {
                required: true
            },
        },
        messages: {
            'data[StudioType][studio_type_name]': {
                required: 'Please enter studio type',
            }
        }
    });
    
    $('#StudioAdminAddForm').validate({
        rules: {
            'data[Studio][studio_name]': {
                required: true
            },
            'data[Studio][category_id]': {
                required: true
            },
            'data[Studio][studioType_id]': {
                required: true
            },
            'data[Studio][cancel_policy]': {
                required: true
            },
            'data[Studio][studio_services][]': {
                required: true
            },
            'data[Studio][description]': {
                required: true
            },
            'data[StudioImage][img_name][]': {
                required: true
            },
            'data[Studio][address]': {
                required: true
            },
           
        },
        messages: {
            'data[Studio][studio_name]': {
                required: 'Please enter studio name',
            },
            'data[Studio][category_id]': {
                required: 'Please select atleast a category',
            },
            'data[Studio][studioType_id]': {
                required: 'Please select type of studio',
            },
            'data[Studio][cancel_policy]': {
                required: 'Please select cancel policy',
            },
            'data[Studio][studio_services][]': {
                required: 'Please select altleast one service',
            },
            'data[Studio][description]': {
                required: 'Please enter short description',
            },
            'data[StudioImage][img_name][]': {
                required: 'Please upload atleast one image',
            },
            'data[Studio][address]': {
                required: 'Please select address',
            },
           
        },
        submitHandler: function (form) {
            // do other things for a valid form
            $('input[type="submit"]').attr('disabled', 'disabled');
            form.submit();
        }
    });
    
    // ADD SERVICE IN SUB ADMIN
    $('#ServiceAdminAddForm').validate({
        rules: {
            'data[Service][service_name]': {
                required: true
            },
            'data[Service][service_price]': {
                required: true,
                number: true
            },
            
           
        },
        messages: {
            'data[Service][service_name]': {
                required: 'Please enter proper service name',
            },
            'data[Service][service_price]': {
                required: 'Please enter proper service price',
                number: 'Please enter correct price',
            }
           
           
        },
        submitHandler: function (form) {
            // do other things for a valid form
            $('input[type="submit"]').attr('disabled', 'disabled');
            form.submit();
        }
    });
    
    // EDIT SERVICE IN SUB ADMIN
    $('#ServiceAdminEditForm').validate({
        rules: {
            'data[Service][service_name]': {
                required: true
            },
            'data[Service][service_price]': {
                required: true,
                number: true
            },
            
           
        },
        messages: {
            'data[Service][service_name]': {
                required: 'Please enter proper service name',
            },
            'data[Service][service_price]': {
                required: 'Please enter proper service price',
                number: 'Please enter correct price',
            }
           
           
        },
        submitHandler: function (form) {
            // do other things for a valid form
            $('input[type="submit"]').attr('disabled', 'disabled');
            form.submit();
        }
    });


});


function customValid(val) {
    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
    var CountError = [];
    var count1 = 1;
    $(".Acode").each(function () {
        var str = $(this).val();
        if (str == '') {
            $(this).addClass('error');
            CountError[count1] = 'error';
        } else {
            $(this).removeClass('error');
        }
        count1++;
    });


    var count2 = 1;
    $(".Avalue").each(function () {
        var num = $(this).val();
        if (num == '' || !numberRegex.test(num)) {
            $(this).addClass('error');
            CountError[count2] = 'error';

        } else {
            $(this).removeClass('error');
        }
        count2++;
    });

    if (jQuery.inArray("error", CountError) && CountError.length != 0) {
        return false;

    } else {
        return true;
    }
    //console.log($.inArray( "error", CountError )

    /* alert(flagger);
     if(flagger && flagger == 1){
     return false;
     }else{
     return true;
     } */
}