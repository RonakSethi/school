var request = require("request");
var config = require('./config');
var https = require("https");
var http = require("http");
var hashSalt = config.hashSalt;
var Hashids = require("hashids"), hashids = new Hashids(hashSalt);
var fs = require('fs-extra');
responseVar = require('./responseVar');
//var apnagent = require('./apnagent.js');
var sha1 = require('sha1');
var FUNCTIONS = require("./functions.js");
var twilioAccountSid = config.twilioAccountSid;
var twilioAuthToken = config.twilioAuthToken;
var twilioFrom = config.twilioFrom;
var client = require('twilio')(twilioAccountSid, twilioAuthToken);

var adminEmailConfig = config.adminEmailConfig;
var smtpMailUser = config.smtpMailUser;
var smtpMailPass = config.smtpMailPass;

module.exports.is_user_exists = is_user_exists;
//module.exports.signupVerified = signupVerified;
module.exports.signupVerified = signupVerifiedTemp;
module.exports.register = register;
module.exports.fbVerified = fbVerified;
module.exports.login = login;
module.exports.forgot_password = forgot_password;
module.exports.logout = logout;
module.exports.changePassword = changePassword;
module.exports.static_content = static_content;
module.exports.static_content_list = static_content_list;
module.exports.basic_profile = basic_profile;
module.exports.edit_profile = edit_profile;









module.exports.language = language;
module.exports.user_settings = user_settings;
module.exports.edit_content = edit_content;
module.exports.user_listing = user_listing;
module.exports.active_inactive = active_inactive;
module.exports.add_service_cat = add_service_cat;
module.exports.update_profile_token = update_profile_token;

console.log(hashids.encode(2));
console.log(hashids.encode(13));

//apnagent.sendNotification('3425aace8a951b18f193853303dc687b82aac594377be40772c4c7b159b15c49','PUSH NODE TESTING','','');


function random_code() {
    var pin_no = "";
    var randString = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for (var i = 0; i < 5; i++)
        pin_no += randString.charAt(Math.floor(Math.random() * randString.length));
    return pin_no;
}


/**
 * check is user exists or not
 */
function is_user_exists(sid, pool, callback) {
    var uid = hashids.decode(sid);
    //var uid = sid;
    console.log("USER ID >>" + uid);
    var resultJson = [];
    pool.getConnection(function (err, connection) {
        var count_query = "select count(*) as total_count from users where id = '" + uid + "'";
        connection.query(count_query, function (err, rows) {
            if (err) {
                resultJson.push({"replyCode": "error", "replyMsg": err});
                connection.release();
                callback(500, null, JSON.stringify(resultJson[0]));
                return;
            } else {
                if (rows[0].total_count > 0) {
                    resultJson.push({"replyCode": "success", "replyMsg": ""});
                    connection.release();
                    callback(200, null, JSON.stringify(resultJson[0]));
                    return;
                } else {
                    resultJson.push({"replyCode": "error", "replyMsg": responseVar.invalidLogin});
                    connection.release();
                    callback(200, null, JSON.stringify(resultJson[0]));
                    return;
                }
            }
        });
    });
}



/*
 * function :- signupverified
 * url : http://localhost:3232/signupVerified
 * description :- signupVerified
 * parameters :- email,phone 
 *
 */

function signupVerifiedTemp(appdata, pool, callback) {
    var uid = '';
    var sid = '';
    var phone = '';
    var email = '';
    fs.writeFile("filewrite/signupVerified.txt", JSON.stringify(appdata));
    if (typeof appdata.phone != 'undefined' && appdata.phone != '') {
        var phone = "+" + appdata.phone;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.phoneRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.email != 'undefined' && appdata.email != '') {
        email = appdata.email;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.emailRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }

    pool.getConnection(function (err, connection) {
        var query = 'SELECT * FROM users WHERE email ="' + email + '" OR phone = "' + phone + '" AND isdeleted = 0';
        connection.query(query, function (err, results) {
            console.log(results);
            if (!err) {
                if (results.length > 0) {
                    results = results[0];
                    if (results.email == email) {
                        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.mailExists + '","cmd":"signup staus not  verified"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                    } else if (results.phone == phone) {
                        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.phoneExists + '","cmd":"signup staus not  verified"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                    }
                } else {
                    //If email and phone number not already found then send otp to user and app
                    var new_otp = '',
                        message = '';
                    var new_otp = '1234';
                    var dataResult = {new_otp: new_otp}
                            resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.otpSend + '","resultCount":"","data":' + JSON.stringify(dataResult) + '}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return
                }
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '","cmd":"signup error"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }

        });
    });
}


/*
 * function :- signupverified
 * url : http://localhost:3232/signupVerified
 * description :- signupVerified
 * parameters :- email,phone 
 *
 */

function signupVerified(appdata, pool, callback) {
    var uid = '';
    var sid = '';
    var phone = '';
    var email = '';
    fs.writeFile("filewrite/signupVerified.txt", JSON.stringify(appdata));
    if (typeof appdata.phone != 'undefined' && appdata.phone != '') {
        var phone = "+" + appdata.phone;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.phoneRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.email != 'undefined' && appdata.email != '') {
        email = appdata.email;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.emailRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }

    pool.getConnection(function (err, connection) {
        var query = 'SELECT * FROM users WHERE email ="' + email + '" OR phone = "' + phone + '" AND isdeleted = 0';
        connection.query(query, function (err, results) {
            console.log(results);
            if (!err) {
                if (results.length > 0) {
                    results = results[0];
                    if (results.email == email) {
                        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.mailExists + '","cmd":"signup staus not  verified"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                    } else if (results.phone == phone) {
                        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.phoneExists + '","cmd":"signup staus not  verified"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                    }
                } else {
                    //If email and phone number not already found then send otp to user and app
                    var new_otp = '',
                        message = '';
                    var new_otp = random_code();
                    
                    message += "Your otp is " + new_otp + " for  \n\n";
                    message += "mobile no :" + phone + "  \n\n";
                    message += "Cheers,\n";
                    message += "The Jamspot Team" + "\n";
                    console.log(message);
                    client.sendMessage({
                        to: phone, // Any number Twilio can deliver to
                        from: twilioFrom, // '+12566672441', // A number you bought from Twilio and can use for outbound communication
                        body: message // body of the SMS message

                    }, function (otperr, otpresponse) { 
                        //this function is executed when a response is received from Twilio
                        if (!otperr) { 
                           // "err" is an error received during the request, if any
                            var dataResult = {new_otp: new_otp}
                            resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.otpSend + '","resultCount":"","data":' + JSON.stringify(dataResult) + '}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return;
                            console.log(responseData.from); 
                            console.log(responseData.body); 
                        } else {
                            console.log("Error Sms : " + JSON.stringify(otperr));
                            resultJson = '{"replyCode":"error","replyMsg":"Invalid Mobile Number"}\n';
                            connection.release();
                            callback(400, null, resultJson);
                            return;
                        }
                    });
                }
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '","cmd":"signup error"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }

        });
    });
}


/*
 * function :- register 
 * url : http://localhost:3232/register
 * description :- to add user 
 * parameters :- role_id(1 = admin 2 = studio 3 = user 4 = commonUser),first_name,last_name,email,password,device_token(optional),gcm(optional),phone,fb_id
 */
function register(appdata, pool, callback) {
    fs.writeFile("filewrite/register.txt", JSON.stringify(appdata));
    var resultJson = '';
    var strJson = '';
    var fb_id = '';
    var first_name = '';
    var last_name = '';
    var device_token = '';
    var gcm = '';
    var email = '';
    var name = '';
    var password = '';
    var gender = '';
    var phone = '';
    var status = 1;
    SerializeJson(appdata)
console.log(appdata.first_name);
console.log(appdata.last_name);
return
    if (typeof appdata.email != 'undefined' && appdata.email != '') {
        email = appdata.email;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.emailRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.first_name != 'undefined' && appdata.first_name != '') {
        first_name = appdata.first_name;
        console.log(first_name);
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.firstNameRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.last_name != 'undefined' && appdata.last_name != '') {
        last_name = appdata.last_name;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.lastNameRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.role_id != 'undefined' && appdata.role_id != '') {
        var role_id = appdata.role_id;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.roleRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.phone != 'undefined' && appdata.phone != '') {
        var phone = "+" + appdata.phone;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.phoneRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }

    if (typeof appdata.status != 'undefined' && appdata.status != '') {
        var status = appdata.status;
    }
    if (typeof appdata.device_token != 'undefined' && appdata.device_token != '') {
        var device_token = appdata.device_token;
    }
    if (typeof appdata.gcm != 'undefined' && appdata.gcm != '') {
        var gcm = appdata.gcm;
    }
    if (typeof appdata.fb_id != 'undefined' && appdata.fb_id != '') {
        var fb_id = appdata.fb_id;
    }
    
    if (typeof appdata.password != 'undefined' && appdata.password != '') {
        var password = appdata.password;
        var hash_password = sha1(hashSalt + appdata.password);
    }

    /* ESTABLISH CONNECTION TO DATABASE */
    pool.getConnection(function (err, connection) {
          var insertQry = 'INSERT INTO users SET role_id = ' + role_id + ', first_name = "' + first_name + '" , last_name = "' + last_name + '" , email = "' + email + '" , password = "' + hash_password + '" , phone = "' + phone + '", fb_id = "'+fb_id+'", status = "1" , created = now() , modified = now()';
                    console.log(insertQry);
                    connection.query(insertQry, function (inserterr, insertresult) {
                        if (!inserterr) {
                            var sid = hashids.encode(insertresult.insertId);
                            var dataResult = {id: insertresult.insertId, role_id: role_id, first_name: first_name,last_name:last_name, email: email, phone: phone}
                            console.log(dataResult);
                            var nodemailer = require('nodemailer');
                            var message = '';
                            message += "Dear " + first_name +" "+last_name +", <br/><br/>";
                            message += "Thank you for registering with us  <br/><br/>";
                            message += "If you would like any further assistance please contact our friendly team at support@jamspot.com <br/><br/>";
                            message += "Best Wishes, <br/>";
                            message += "The Jamspot Team <br/>";
                            console.log(message);
                            // setup e-mail data with unicode symbols
                            var mailOptions = {
                                from: 'The Jamspot Team <receipts.info@Jamspot.com>', // sender address
                                to: email, // list of receivers
                                subject: 'Welcome to Jamspot', // Subject line
                                html: message // html body
                            };

                            var transporter = nodemailer.createTransport({
                                from: 'info@Jamspot.com',
                                host: 'smtp.gmail.com', // hostname
                                service: 'Gmail',
                                auth: {
                                    user: smtpMailUser,
                                    pass: smtpMailPass
                                }
                            });    // send mail with defined transport object
                            transporter.sendMail(mailOptions, function (error, info) {
                                if (error) {
                                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.signUpSuccess + '","resultCount":"","data":' + JSON.stringify(dataResult) + ',"sid":"' + sid + '","cmd":"mail not sent"}\n';
                                    connection.release();
                                    callback(200, null, resultJson);
                                    return;
                                } else {

                                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.signUpSuccess + '","resultCount":"","data":' + JSON.stringify(dataResult) + ',"sid":"' + sid + '"}\n';
                                    connection.release();
                                    callback(200, null, resultJson);
                                    return;
                                }
                            });

                        } else {
                            resultJson = '{"replyCode":"error","replyMsg":"' + inserterr.message + '"}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return;
                        }
                    });
    });
}




/*
 * function :- Facebook account exist or not
 * url : http://localhost:3232/fbVerified
 * description :- signupVerified
 * parameters :- email,fb_id 
 *
 */

function fbVerified(appdata, pool, callback) {
    var fb_id = '',
     email = '',
     emailSearch = '',
     fbIdSrch = '',
     device_token = '',
     gcm = '';
    fs.writeFile("filewrite/fbVerified.txt", JSON.stringify(appdata));
    if (typeof appdata.fb_id != 'undefined' && appdata.fb_id != '') {
        fb_id = appdata.fb_id;
        fbIdSrch = 'fb_id = "'+fb_id+'" '
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.fbIdRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.email != 'undefined' && appdata.email != '') {
        email = appdata.email;
        emailSearch = 'OR email = "'+email+'"';
    } 
    if (typeof appdata.device_token != 'undefined' && appdata.device_token != '') {
        device_token = appdata.device_token;
    } 
    if (typeof appdata.gcm != 'undefined' && appdata.gcm != '') {
        gcm = appdata.gcm;
    } 

    pool.getConnection(function (err, connection) {
        var query = 'SELECT * FROM users WHERE '+fbIdSrch+' '+emailSearch+' AND isdeleted = 0';
        connection.query(query, function (err, results) {
            console.log(results);
            if (!err) {
                if (results.length > 0) {
                    results = results[0];
                    if (results.email == email) {
                        connection.query('UPDATE users SET fb_id = "'+fb_id+'", device_token = "'+device_token+'", gcm = "'+gcm+'" WHERE users.email = "'+email+'"')
                        resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.userExist + '","data":'+JSON.stringify(results)+',"new_user":"0","cmd":"email match"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                    } else if (results.fbIdSrch == fbIdSrch) {
                        resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.userExist + '","data":'+JSON.stringify(results)+',"new_user":"0","cmd":"fb id match"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                    }
                } else {
                            resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.otpSend + '","resultCount":"0","data":"", "new_user":"1"}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return
                }
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '","cmd":"signup error"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }

        });
    });
}




/*
 * function :- login
 * url : http://192.168.0.198:3835/login
 * description :- to login user 
 * parameters :- email,password,device_token(optional),gcm(optional),role_id,logintype(app = 1 , web = 2)
 *
 */

function login(appdata, pool, callback) {
    var resultJson = '';
    var strJson = '';
    var role_id = '';
    var email = '';
    var device_token = '';
    var updateQry = '';
    var hash_password = '';
    var logintype = '';
    fs.writeFile("filewrite/login.txt", JSON.stringify(appdata))
    if (typeof appdata.email != 'undefined' && appdata.email != '') {
        email = appdata.email;
    }else{
       resultJson = '{"replyCode":"error","replyMsg":"'+responseVar.emailRequired+'","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;  
    }
    if (typeof appdata.logintype != 'undefined' && appdata.logintype != '') {
        var logintype = appdata.logintype;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.logintypeRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    
 if (typeof appdata.password != 'undefined' && appdata.password != '') {
      hash_password = sha1(hashSalt + appdata.password);
        }else {
         resultJson = '{"replyCode":"error","replyMsg":"'+responseVar.passwordRequired+'","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }


    /* ESTABLISH CONNECTION TO DATABASE */
    pool.getConnection(function (err, connection) {
        var hash_password = sha1(hashSalt + appdata.password);
        var SelectUser =  'SELECT * FROM users WHERE users.email = "'+email+'" AND password = "'+hash_password+'" '
        connection.query(SelectUser, function (err, results) {
            console.log(results);
            if (!err){
                var pagingCount = results.length;
                if (pagingCount > 0) {
                    var dataResult = results[0];
                    var sid = hashids.encode(dataResult.id);
                   
                    if (dataResult.status == "2") {
                        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.accountSuspend + '","data":"" ,"cmd":"account suspend"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                    }
                    else {
                        // device token update start
                        if (appdata.device_token) {
                            connection.query('UPDATE users set device_token=""  where device_token="' + appdata.device_token + '" ');
                            connection.query('UPDATE users set device_token="' + appdata.device_token + '"  where id="' + dataResult.id + '" ');
                        }
                        if (appdata.gcm) {
                            connection.query('UPDATE users set gcm=""  where gcm="' + appdata.gcm + '" ');
                            connection.query('UPDATE users set gcm="' + appdata.gcm + '"  where id="' + dataResult.id + '" ');
                        }
                        
                        resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.loginSuccess + '","data":' + JSON.stringify(dataResult) + ',"sid":"' + sid + '","resultCount":"1","cmd":"login success"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                    }
                }else{
                    resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.loginInvalid + '","data" :"","resultCount":"0","cmd":"login"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            }else{
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '","cmd":"login"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }
        });
    });
}


/*
 * function :- logout
 * url : http://localhost:3232/logout
 * description :- logout
 * parameters :- sid 
 *
 */
function logout(appdata, pool, callback) {
    var sid = '';
    var uid = '';
    fs.writeFile("filewrite/logout.txt", JSON.stringify(appdata), function (err22) {
    });
    if (typeof appdata.sid == 'undefined' || appdata.sid == '') {
        resultJson = '{"replyCode":"error","data":"","replyMsg":"' + responseVar.sidRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    } else {
         uid = hashids.decode(appdata.sid);
    }

    pool.getConnection(function (err, connection) {
        var updateQuery = 'UPDATE users SET device_token = "", gcm = "" WHERE id = ' + uid;
        console.log(updateQuery)
        connection.query(updateQuery, function (err, result) {
            if (!err) {
                resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.logoutSuccess + '"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                connection.release();
                callback(400, null, resultJson);
                return;
            }
        });
    });
}

/*
 * function name :- forgot password
 * url : http://localhost:3232/forgot_password
 * params :- email
 */
function forgot_password(appdata, pool, callback) {
    var resultJson = '';
    var strJson = '';
    var sha1 = require('sha1');
    var email = '';
    fs.writeFile("filewrite/forgotpassword.txt", JSON.stringify(appdata), function (err22) {
    });
    if (typeof appdata.email != 'undefined' && appdata.email != '') {
        email = appdata.email;
    }
    pool.getConnection(function (err, connection) {
        connection.query('SELECT count(*) as total_count,id,role_id from users where email="' + appdata.email + '"', function (err, user) {
            if (!err) {
                console.log('SELECT count(*) as total_count,id,role_id from users where email="' + appdata.email + '"')
                if (user[0].total_count > 0) {
                    var userRec = user[0];
                    var helloUserEmail = appdata.email;
                    var sid = hashids.encode(userRec.id);
                    var otp_code = random_code();
                    console.log(otp_code);
//                    var dataResult = {otp_code: otp_code}
                    var dataResult = {sid:sid,otp_code: '1234'}

                    // start mail template 
                    var nodemailer = require('nodemailer');
                    var message = '';
                    message += "You've recently forgotten your username or password to the Jamspot app. Please use the details provided below to login. <br/><br/>";
                    message += "Your Username: <strong>" + helloUserEmail + "</strong><br/><br/>";
                    message += "someone is  requested for reset your password <br/><br/>";
                    message += "your otp is " + otp_code + " to reset your password <br/><br/>";
                    message += "If you would like any further assistance please contact our friendly team at support@Jamspot.com <br/><br/>";
                    message += "Cheers,<br/>";
                    message += "The Jamspot Team" + "<br/>";
                    console.log(message);
                    // setup e-mail data with unicode symbols
                    var mailOptions = {
                        from: 'Jamspot Team <receipts.info@Jamspot.com>', // sender address
                        to: email, // list of receivers
                        subject: 'Forgot Password', // Subject line
                        html: message // html body
                    };
                    var transporter = nodemailer.createTransport({
                        from: 'info@Jamspot.com',
                        host: 'smtp.gmail.com', // hostname
                        service: 'Gmail',
                        auth: {
                            user: smtpMailUser,
                            pass: smtpMailPass
                        }
                    });
                    // send mail with defined transport object
                    transporter.sendMail(mailOptions, function (error, info) {
                        if (error) {
                            console.log(" in err");
                            resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.forgotSuccess + '","data":' + JSON.stringify(dataResult) + ',"sid":"' + sid + '","mailsend":"0"}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return;
                        } else {
                            resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.forgotSuccess + '","data":' + JSON.stringify(dataResult) + ',"sid":"' + sid + '"}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return;
                        }
                    });
                    // end mail template	
                } else {
                    resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.email_not_register + '", "cmd":"email not register"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }
        });
    });
}

/*
 * function :- Change Password
 * url : http://localhost:3232/changePassword
 * description :- changePassword
 * parameters :- sid,old_password(only in logedin change password case),new_password
 *
 */

function changePassword(appdata, pool, callback) {
    var email = '';
    var sid = '';
    var uid = '';
    var email = '';
    var old_password = '';
    var new_password = '';
    
    fs.writeFile("filewrite/changePassword.txt", JSON.stringify(appdata), function (err22) {
    });
    if (typeof appdata.sid != 'undefined' || appdata.sid != '' || appdata.sid != 0 || appdata.sid != undefined) {
        sid = appdata.sid;
        uid = hashids.decode(sid);
    }else{
      resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.sidRequired + '"}\n';
        callback(200, null, resultJson);
        return;  
    }
    if (typeof appdata.old_password == 'undefined' && appdata.old_password == '') {
        old_password = appdata.old_password
    }

    if (typeof appdata.new_password != 'undefined' && appdata.new_password != '') {
        new_password = appdata.new_password;
        console.log(appdata.new_password)
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.passwordRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    }

    pool.getConnection(function (err, connection) {
        var new_password = sha1(hashSalt + appdata.new_password);
       
        if (old_password != 'undefined' && old_password != '') {
            console.log("enter in old password ")
            var query = 'SELECT id,password FROM users WHERE id = "' + uid + '"';
            connection.query(query, function (err, results) {
                console.log(query);
                if (!err) {
                    //WHEN CHANGE PASSWORD FROM SETTINGS
                    var dataResult = results[0];
                    //var old_password = sha1(hashSalt + appdata.old_password);
                    if (dataResult.password != old_password) {
                        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.wrongOldPassword + '","cmd":"change password error"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                    } else {
                        var UpdatePassword = 'UPDATE users SET password = "' + new_password + '" WHERE id = "' + uid + '"';
                        connection.query(UpdatePassword, function (updateErr, updateRes) {
                            if (!updateErr) {
                                resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.userChangePassSuccess + '","cmd":"change password success"}\n';
                                connection.release();
                                callback(200, null, resultJson);
                                return;
                            } else {
                                resultJson = '{"replyCode":"error","replyMsg":"' + updateErr.message + '","cmd":"chane password error"}\n';
                                connection.release();
                                callback(200, null, resultJson);
                                return;
                            }
                        });
                    }

                } else {
                    resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '","cmd":"change password error"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            });
        } else {
            console.log("ENTER in ELSE PART")
            //WHEN FORGOT PASSWORD
            var UpdatePassword = 'UPDATE users SET password = "' + new_password + '" WHERE users.id = "' + uid + '"';
            connection.query(UpdatePassword, function (updateErr, updateRes) {
                if (!updateErr) {
                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.userChangePassSuccess + '","cmd":"change password success"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                } else {
                    resultJson = '{"replyCode":"error","replyMsg":"' + updateErr.message + '","cmd":"chane password error"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            });
        }
    });
}





/*
 * Function : Static Content
 *
 * Url      : http://localhost:3232/static_content
 * params   : content_id
 */

function static_content(appdata, pool, callback) {
    var content_id = '';
    var resultJson = '';
    fs.writeFile("filewrite/static_content.txt", JSON.stringify(appdata), function (err22) {
    });
console.log("ENTER IN CONTENT")
    if (typeof appdata.content_id != 'undefined' && appdata.content_id != '') {
        content_id = appdata.content_id;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.contentIdNotFound + '","cmd":"static_content  not defined"}';
        callback(200, null, resultJson);
        return;
    }

    pool.getConnection(function (err, connection) {
        console.log("ENTER IN CONTENT")
        var query = 'SELECT * FROM contents WHERE id = "' + content_id + '"';
        console.log(query)
        connection.query(query, function (qryerr, qryresult) {
            if (!qryerr) {

                var pagingCount = qryresult.length;
                if (pagingCount > 0)
                {
                    var dataResult = qryresult[0];
                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.recordFound + '","data":' + JSON.stringify(dataResult) + ',"cmd":"static_content"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                } else {
                    resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.recordNotFound + '","cmd":"static_content"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }

            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + qryerr.message + '"}\n';
                connection.release();
                callback(400, null, resultJson);
                return
            }
        });
    });
}

/*
 * Function : Static Content List
 * Url      : http://localhost:3232/static_content_list
 * params   : 
 */

function static_content_list(appdata, pool, callback) {
    fs.writeFile("filewrite/static_content_list.txt", JSON.stringify(appdata), function (err22) {
    });
    pool.getConnection(function (err, connection) {
        var query = 'SELECT * FROM contents WHERE status = 1';
        console.log(query);
        connection.query(query, function (qryerr, qryresult) {
            if (!qryerr) {
                var pagingCount = qryresult.length;
                if (pagingCount > 0)
                {
                    var dataResult = qryresult;
                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.recordFound + '","data":' + JSON.stringify(dataResult) + ',"cmd":"static_content"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                } else {
                    resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.recordNotFound + '","cmd":"static_content"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }

            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + qryerr.message + '"}\n';
                connection.release();
                callback(400, null, resultJson);
                return
            }
        });
    });
}

/*
 * function :- User Profile
 * url : http://localhost:3232/basic_profile
 * description :-Basic User profile
 * parameters :- sid
 */

function basic_profile(appdata, pool, callback) {
    fs.writeFile("filewrite/profile.txt", JSON.stringify(appdata));
    var sid = '';
    var uid = '';
    if (typeof appdata.sid != 'undefined' && appdata.sid != '') {
        sid = appdata.sid;
        uid = hashids.decode(sid);
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.sidRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    }

    pool.getConnection(function (err, connection) {
        var SelQuery = 'SELECT *, IFNULL(users.image,"") as user_image FROM users WHERE users.id = "' + uid + '"';
        console.log(SelQuery);
        connection.query(SelQuery, function (err, result) {
            if (!err) {
                var pageCount = result.length
                if (pageCount > 0) {
                    var dataResult = result[0];
                        resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.datasuccess + '","data":' + JSON.stringify(dataResult) + ',"resultCount":"' + pageCount + '"}\n';
                        connection.release();
                        callback(200, null, resultJson);
                        return;
                } else {
                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.invalid_sid + '","resultCount":"0"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }
        });
    });
}


/*
 * function :- Edit Profile
 * url : http://localhost:3232/edit_profile
 * description :-Edit User profile
 * parameters :- sid,first_name,last_name,user_image,notification_setting
 */

function edit_profile(appdata, pool, callback) {
    fs.writeFile("filewrite/edit_profile.txt", JSON.stringify(appdata));
    var sid = '';
    var uid = '';
    var first_name = '';
    var last_name = '';
    var user_image = '';
    var name = '';
    var upadteImg = '';
    var status = 1;
    var notification_setting = 1;
   


    if (typeof appdata.sid != 'undefined' && appdata.sid != '') {
        sid = appdata.sid;
        uid = hashids.decode(sid);
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.sidRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    }

    if (typeof appdata.first_name != 'undefined' && appdata.first_name != '') {
        first_name = appdata.first_name;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.firstNameRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.last_name != 'undefined' && appdata.last_name != '') {
        last_name = appdata.last_name;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.lastNameRequired + '","resultCount":"","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
if ((typeof appdata.notification_setting != 'undefined' && appdata.notification_setting != '') || appdata.notification_setting == 0) {
        notification_setting = appdata.notification_setting;
    } 

    /* ESTABLISH CONNECTION TO DATABASE */
    pool.getConnection(function (err, connection) {
        var SelUser = 'SELECT *, IFNULL(users.image, "") as user_image FROM users WHERE id ="' + uid + '"'
        console.log(SelUser)
        connection.query(SelUser, function (selErr, selResult) {
            if (!selErr) {
                if (selResult.length > 0) {
                    if (typeof appdata.user_image != 'undefined' && appdata.user_image != '') {
                        var img = appdata.user_image;
                        var d1 = new Date();
                        var img_name = "user_" + d1.getTime() + '.jpeg';
                        FUNCTIONS.saveFile(img, img_name, 'users/');
                        upadteImg = 'image = "' + img_name + '", '
                        if (selResult[0].user_image != '' && selResult[0].user_image != '0' && selResult[0].user_image != 'undefined') {
                            var userOldImage = config.imageFilePath + 'users/' + selResult[0].user_image;
                            if (fs.existsSync(userOldImage)) {
                                fs.unlink(userOldImage);
                            }
                        }
                    }
                    var updateUser = 'UPDATE users SET  first_name = "' + first_name + '",last_name = "' + last_name + '",notification_setting = "'+notification_setting+'" WHERE id = "' + uid + '"  ';
                    console.log(updateUser)
                    connection.query(updateUser, function (updateErr, updateResult) {
                        if (!updateErr) {
                            connection.query('SELECT * FROM users WHERE id = "' + uid + '"', function (userErr, userResult) {
                                console.log('SELECT * FROM users WHERE id = "' + uid + '"')
                                if (!userErr) {
                                    var dataResult = userResult[0]
                                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.userUpdateSuccess + '","data":' + JSON.stringify(dataResult) + ',"sid":"' + sid + '"}\n';
                                    connection.release();
                                    callback(200, null, resultJson);
                                    return;
                                } else {
                                    resultJson = '{"replyCode":"error","replyMsg":"' + userErr.message + '"}\n';
                                    connection.release();
                                    callback(200, null, resultJson);
                                    return;
                                }
                            });
                        } else {
                            resultJson = '{"replyCode":"error","replyMsg":"' + updateErr.message + '"}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return;
                        }
                    });
                } else {
                    resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.invalid_sid + '"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + selErr.message + '"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }
        })
    });
}


















/*
 * function :- langugages
 * url : http://192.168.0.198:7777/language
 * description :- language
 * parameters :- 
 *
 */

function language(appdata, pool, callback) {
    var resultJson = '';
    var strJson = '';
    var query = '';


    /* ESTABLISH CONNECTION TO DATABASE */
    pool.getConnection(function (err, connection) {
        var query = 'SELECT * FROM languages WHERE status = 1'
        connection.query(query, function (err, results) {
            console.log(results);
            if (!err)
            {
                resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.datasuccess + '","data":' + JSON.stringify(results) + ' ,"cmd":"language success"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '","cmd":"language error"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }
        });
    });
}





/*
 * function :- User Listing
 * url : http://localhost:3232/user_listing
 * description :-Basic User listing
 * parameters :- status(optional),search(optional),role_id(1 = admin, 2 = users, 3 = service providers )
 */

function user_listing(appdata, pool, callback) {
    var offset = 0;
    var status = '';
    var searchby = '';
    var role_id = '';

    fs.writeFile("filewrite/user_listing.txt", JSON.stringify(appdata));

    if (typeof appdata.limit != 'undefined' && appdata.limit != '') {
        var limit = appdata.limit;
    } else {
        limit = config.limit
    }
    if (typeof appdata.offset != 'undefined' && appdata.offset != '') {
        var offset = limit * appdata.offset;
    }
    if (typeof appdata.status != 'undefined' && appdata.status != '') {
        var status = 'status = "' + appdata.status + '" AND ';

    }
    if (typeof appdata.search != 'undefined' && appdata.search != '') {
        var searchby = '(email LIKE "%' + appdata.search + '%" OR name LIKE "%' + appdata.search + '%") AND ';

    }
    if (typeof appdata.role_id != 'undefined' && appdata.role_id != '') {
        var role = 'role_id IN (' + appdata.role_id + ') AND ';
    }


    pool.getConnection(function (err, connection) {
        var SelectUser = 'SELECT (SELECT count(id) FROM users WHERE ' + status + ' ' + role + ' ' + searchby + ' isdeleted = 0 ) as total_users, users.* FROM users WHERE ' + status + ' ' + searchby + ' ' + role + '  isdeleted = 0  ORDER BY users.created DESC LIMIT ' + offset + ',' + limit;
        console.log(SelectUser);
        connection.query(SelectUser, function (companyErr, companyResult) {
            if (companyErr) {
                resultJson = '{"replyCode":"error","replyMsg":"' + companyErr.message + '"}\n';
                connection.release();
                callback(400, null, resultJson);
                return;
            } else {
                if (companyResult.length > 0) {
                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.dataSuccess + '","resultCount":"' + companyResult[0].total_users + '","data":' + JSON.stringify(companyResult) + '}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                } else {
                    resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.noUserFound + '","resultCount":"0","data":"","cmd":"no user found"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            }
        })
    });
}







/*
 * function :- User Settings
 * url : http://192.168.0.198:7777/user_settings
 * description :- User Settings
 * parameters :- sid,setting_meta(lang_id,date_format,address_format),setting_value
 */

function user_settings(appdata, pool, callback) {
    fs.writeFile("filewrite/user_settings.txt", JSON.stringify(appdata));
    var user_id = '';
    var lang_id = '';
    var date_format = '';
    var address_format = '';
    var setting_meta = '';
    var setting_value = '';
    if (typeof appdata.sid == 'undefined' || appdata.sid == '') {
        resultJson = '{"replyCode":"error","data":"","replyMsg":"' + responseVar.insufficient_information + '"}\n';
        callback(200, null, resultJson);
        return;
    } else {
        var user_id = hashids.decode(appdata.sid);
    }

    if (typeof appdata.setting_meta != 'undefined' && appdata.setting_meta != '') {
        setting_meta = appdata.setting_meta;
    } else {
        resultJson = '{"replyCode":"error","data":"","replyMsg":"' + responseVar.insufficient_information + '"}\n';
        callback(200, null, resultJson);
        return;
    }

    if (typeof appdata.setting_value != 'undefined' && appdata.setting_value != '') {
        setting_value = appdata.setting_value;
    } else {
        resultJson = '{"replyCode":"error","data":"","replyMsg":"' + responseVar.insufficient_information + '"}\n';
        callback(200, null, resultJson);
        return;
    }


    pool.getConnection(function (err, connection) {
        var UpdateQuery = 'UPDATE users SET ' + setting_meta + ' = "' + setting_value + '" WHERE users.id = "' + user_id + '"';
        console.log(UpdateQuery);
        connection.query(UpdateQuery, function (err, result) {
            if (!err) {
                resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.datasuccess + '","data":"","resultCount":""}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }
        });
    });
}


/*
 * Function : Static Content
 *
 * Url      : http://192.168.0.198:3835/edit_content
 * params   : content_id,title,body
 */

function edit_content(appdata, pool, callback) {
    var content_id = '';
    var title = '';
    var body = '';
    var resultJson = '';
    fs.writeFile("filewrite/edit_content.txt", JSON.stringify(appdata), function (err22) {
    });

    if (typeof appdata.content_id != 'undefined' && appdata.content_id != '') {
        content_id = appdata.content_id;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.insufficient_information + '","cmd":"static_content  not defined"}';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.title != 'undefined' && appdata.title != '') {
        title = appdata.title;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.insufficient_information + '","cmd":"static_content  not defined"}';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.body != 'undefined' && appdata.body != '') {
        body = appdata.body;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.insufficient_information + '","cmd":"static_content  not defined"}';
        callback(200, null, resultJson);
        return;
    }

    pool.getConnection(function (err, connection) {
        var query = 'SELECT * FROM contents WHERE id = "' + content_id + '"';
        connection.query(query, function (qryerr, qryresult) {
            if (!qryerr) {

                var pagingCount = qryresult.length;
                if (pagingCount > 0)
                {
                    var UpdateQuery = 'UPDATE contents SET title = "' + title + '", body = "' + body + '" WHERE id ="' + content_id + '"'
                    connection.query(UpdateQuery)
                    var dataResult = qryresult[0];
                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.contentUpdateSuccess + '","data":"","cmd":"static_content"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                } else {
                    resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.recordNotFound + '","cmd":"static_content"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + qryerr.message + '"}\n';
                connection.release();
                callback(400, null, resultJson);
                return
            }
        });
    });
}


/*
 * function :- Active Inactive
 * url : http://localhost:3232/active_inactive
 * description :- Active Inactive 
 * parameters :- table_name, active_inactive
 *
 */
function active_inactive(tethrdata, pool, callback) {
    var table_name = '';
    var active_inactive = '';
    var row_id = '';
    fs.writeFile("filewrite/active_inactive.txt", JSON.stringify(tethrdata));

    if (typeof tethrdata.table_name != 'undefined' && tethrdata.table_name != '') {
        var table_name = tethrdata.table_name;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.tableRequired + '","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof tethrdata.active_inactive != 'undefined') {
        var active_inactive = tethrdata.active_inactive;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.statusRequired + '","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof tethrdata.row_id != 'undefined' && tethrdata.row_id != '') {
        var row_id = tethrdata.row_id;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.rowRequired + '","data":""}\n';
        callback(200, null, resultJson);
        return;
    }
    pool.getConnection(function (err, connection) {
        var updateTable = 'UPDATE ' + table_name + ' SET status = "' + active_inactive + '" WHERE id = "' + row_id + '"';
        console.log(updateTable);
        connection.query(updateTable, function (companyErr, companyResult) {
            if (companyErr) {
                resultJson = '{"replyCode":"error","replyMsg":"' + companyErr.message + '"}\n';
                connection.release();
                callback(400, null, resultJson);
                return;
            } else {
                resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.statusUpdate + '","resultCount":"1","data":""}\n';
                connection.release();
                callback(200, null, resultJson);
                return;

            }
        })
    });
}


/*
 * function :- Add Service Categories
 * url : http://localhost:3232/add_service_cat
 * description :-Add service categories
 * parameters :- sid,services_providing
 */

function add_service_cat(appdata, pool, callback) {
    fs.writeFile("filewrite/add_service_cat.txt", JSON.stringify(appdata));
    var sid = '';
    var uid = '';
    var services_providing = '';

    if (typeof appdata.services_providing != 'undefined' && appdata.services_providing != '') {
        services_providing = appdata.services_providing;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.servicesCatRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    }

    if (typeof appdata.sid != 'undefined' && appdata.sid != '') {
        sid = appdata.sid;
        uid = hashids.decode(sid);
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.sidRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    }

    pool.getConnection(function (err, connection) {
        var SelQuery = 'SELECT * FROM users WHERE users.id = "' + uid + '"';
        console.log(SelQuery);
        connection.query(SelQuery, function (err, result) {
            if (!err) {
                var pageCount = result.length
                if (pageCount > 0) {
                    var updateUser = 'UPDATE users SET  services_providing = "' + services_providing + '" WHERE id = "' + uid + '"  ';
                    connection.query(updateUser, function (updateErr, updateResult) {
                        if (!updateErr) {
                            connection.query('SELECT * FROM users WHERE id = "' + uid + '"', function (userErr, userResult) {
                                if (!userErr) {
                                    var dataResult = userResult[0]
                                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.userUpdateSuccess + '","data":' + JSON.stringify(dataResult) + ',"sid":"' + sid + '"}\n';
                                    connection.release();
                                    callback(200, null, resultJson);
                                    return;
                                } else {
                                    resultJson = '{"replyCode":"error","replyMsg":"' + userErr.message + '"}\n';
                                    connection.release();
                                    callback(200, null, resultJson);
                                    return;
                                }
                            });
                        } else {
                            resultJson = '{"replyCode":"error","replyMsg":"' + updateErr.message + '"}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return;
                        }
                    });

                } else {
                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.invalid_sid + '","resultCount":"0"}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + err.message + '"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }
        });
    });
}


/*
 * function :- Update Profile Token
 * url : http://localhost:3232/update_profile_token
 * description :- Update service provider profile token
 * parameters :- sid,stripe_token,paypal_token
 */

function update_profile_token(appdata, pool, callback) {
    fs.writeFile("filewrite/update_profile_token.txt", JSON.stringify(appdata));
    var sid = '';
    var uid = '';
    var stripe_token = '';
    var paypal_token = '';
    var updateToken = '';

    if (typeof appdata.stripe_token != 'undefined' && appdata.stripe_token != '') {
        stripe_token = appdata.stripe_token;
        updateToken = 'stripe_token = "' + stripe_token + '"';
    }
    if (typeof appdata.paypal_token != 'undefined' && appdata.paypal_token != '') {
        paypal_token = appdata.paypal_token;
        updateToken = 'paypal_token = "' + paypal_token + '"';
    }

    if (typeof appdata.sid != 'undefined' && appdata.sid != '') {
        sid = appdata.sid;
        uid = hashids.decode(sid);
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.sidRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    }

    pool.getConnection(function (err, connection) {
        var updateProfileToken = 'UPDATE users SET ' + updateToken + ' WHERE users.id = "' + uid + '" '
        connection.query(updateProfileToken, function (updateErr, updateResult) {
            if (!updateErr) {
                resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.userUpdateSuccess + '","data":""}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            } else {
                resultJson = '{"replyCode":"error","replyMsg":"' + updateErr.message + '"}\n';
                connection.release();
                callback(200, null, resultJson);
                return;
            }
        });
    });
}



/*
 * function :- Test Image
 * url : http://localhost:3232/test_image
 * description :- Test Image
 * parameters :- image
 */

function test_image(appdata, pool, callback) {
    fs.writeFile("filewrite/test_image.txt", JSON.stringify(appdata));
    
    var image = '';

    if (typeof appdata.image != 'undefined' && appdata.image != '') {
        image = appdata.image;
         var img = appdata.user_image;
                        var d1 = new Date();
                        var img_name = "user_" + d1.getTime() + '.jpeg';
                        FUNCTIONS.saveFile(img, img_name, 'users/');
                          resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.userUpdateSuccess + '","data":""}\n';
                callback(200, null, resultJson);
                return;
    }
   

   
}


