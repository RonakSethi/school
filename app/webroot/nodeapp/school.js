var async = require('async'),
        request = require("request"),
        config = require('./config'),
        https = require("https"),
        http = require("http"),
        hashSalt = config.hashSalt,
        querystring = require("querystring"),
        Hashids = require("hashids"),
        hashids = new Hashids(hashSalt),
        fs = require('fs-extra'),
        responseVar = require('./responseVar'),
        pushVar = require('./pushVar'),
        //  apnagent = require('./apnagent.js'),
        sha1 = require('sha1'),
        FUNCTIONS = require("./functions.js");
//var anroidUserPush = require('./android_apnagent.js');
var limit = config.limit
var adminEmailConfig = config.adminEmailConfig;
var smtpMailUser = config.smtpMailUser;
var smtpMailPass = config.smtpMailPass;

module.exports.studio_listing = studio_listing;
module.exports.studio_detail = studio_detail;
module.exports.services_listing = services_listing;


//apnagent.sendNotification('3425aace8a951b18f193853303dc687b82aac594377be40772c4c7b159b15c49','JISKO PUSH MILE PLZ BATA DENA RONAK','','');
// apnagent.sendNotification('c8c629d60c1f003dda2dc5782f0a01855411d59f7f9da45ed11f35bf82eb404a','PUSH TESTING','','');
//anroidUserPush.sendandroidNotification("APA91bFvSg9z_Pb4YEHd2RfbDkJVGxYQ4szuV-qaAViTvuPPl--uDIIbci_e-zuWlUDLz3KpSowWohBh6ZxKEviG8DvFbLQWx4Ig_ylERnCOpMKvaVaHBT7I-NdHcpGkWDkGRalKPosSQ-HsOoCuPqKaMSkHED3Heg", 'Test message', 'path', '{"type":"chat"}');
//anroidUserPush.sendandroidNotification("APA91bHHg4IEqE4VQO7CdRYduoiABsQXSeY8qRQ9zcho73DAxDWOkGn45rWi8eIBrjKAweraVjxcRvYpR3A-BKebRGo5VGkMLLOq3kbOcVGZQ8zWhgYga17IU821nsZ7JYPIraV_2P04eFYH50jGU3JoGeCRDt28Ew", 'Test message', 'path', '{"type":"chat"}');
//console.log("12 >> " + hashids.encode(12))

function random_code() {
    var pin_no = "";
    var randString = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for (var i = 0; i < 5; i++)
        pin_no += randString.charAt(Math.floor(Math.random() * randString.length));
    return pin_no;
}


/*
 * function :- Studio Listing
 * url : http://localhost:3232/studio_listing
 * description :- all studio_listing
 * parameters :- status(0 = inactive,1 = active),distance(optional , default = 15), lat,lng
 *
 */
function studio_listing(appdata, pool, callback) {
    fs.writeFile("filewrite/studio_listing.txt", JSON.stringify(appdata));
    var offset = 0;
    var cid = '';
    var status = '1';
    var lat = '';
    var lng = '';
    var searchby = '';
    var checkdate = '';
    var checkintime = '';
    var checkouttime = '';
    var servicetype = '';
    var price_min = '';
    var price_max = '';
    var chckindate = '';
    var distance = 15;

    if (typeof appdata.limit != 'undefined' && appdata.limit != '') {
        var limit = appdata.limit;
    } else {
        limit = config.limit
    }
    if (typeof appdata.offset != 'undefined' && appdata.offset != '') {
        var offset = limit * appdata.offset;
    }
    if (typeof appdata.status != 'undefined' && appdata.status != '') {
        status = 'status = "' + appdata.status + '" ';
    }
    if (typeof appdata.lat != 'undefined' && appdata.lat != '') {
        lat = appdata.lat;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.latRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.lng != 'undefined' && appdata.lng != '') {
        lng = appdata.lng;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.lngRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    }
    if (typeof appdata.search != 'undefined' && appdata.search != '') {
        searchby = 'studios.studio_name LIKE "%' + appdata.search + '%" AND ';
    }
    if (typeof appdata.checkdate != 'undefined' && appdata.checkdate != '') {
        checkdate = 'studio_calendars.date = '+appdata.checkdate+' AND ';
    }
    if (typeof appdata.checkintime != 'undefined' && appdata.checkintime != '') {
        checkintime = 'studio_calendars.start_time = '+appdata.checkintime+' AND ';
    }
    if (typeof appdata.checkouttime != 'undefined' && appdata.checkouttime != '') {
        checkouttime = 'studio_calendars.end_time = '+appdata.checkouttime+' AND ';
    }
    if (typeof appdata.servicetype != 'undefined' && appdata.servicetype != '') {
        servicetype = 'studio_calendars.end_time = '+appdata.servicetype+' AND ';
    }
    
    if (typeof appdata.distance != 'undefined' && appdata.distance != '') {
        distance = appdata.distance;
    }


    pool.getConnection(function (err, connection) {
        
        
        
        
        
        var SelectStudio = 'SELECT studios.*,ROUND(( 3959 * acos( cos( radians("' + lat + '") ) * cos( radians(`lat` ) ) * cos( radians(`lng`) - radians("' + lng + '")) + sin(radians("' + lat + '")) * sin( radians(`lat`)))),2) AS distance,(SELECT img_name FROM studio_images WHERE studios.id = studio_images.studio_id Limit 1) as studio_image  FROM studios LEFT JOIN studio_calendars ON studio_calendars.studio_id = studios.id WHERE ' + searchby + ' '+checkdate+' '+checkintime+' '+checkouttime+' studios.status = 1   HAVING ROUND(distance,2) < ' + distance + '  ORDER BY distance ASC LIMIT ' + offset + ',' + limit;

        console.log(SelectStudio);
        connection.query(SelectStudio, function (studioErr, studioResult) {
            if (studioErr) {
                resultJson = '{"replyCode":"error","replyMsg":"' + studioErr.message + '"}\n';
                connection.release();
                callback(400, null, resultJson);
                return;
            } else {
                if (studioResult.length > 0) {
                    var i = 0
                    async.eachSeries(studioResult, function (studio, loop) {
                        var getServices = 'SELECT GROUP_CONCAT(service_name) as service_name FROM services WHERE services.id IN (' + studio.studio_services + ')'
                        connection.query(getServices, function (getServicesErr, getServicesResult) {
                            if (getServicesErr) {
                                loop()
                                i++
                            } else {
                                studioResult[i]['services'] = getServicesResult[0]['service_name']
                                loop();
                                i++
                            }
                        })
                    }, function (asynerr) {
                        if (!asynerr) {
                            resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.recordFound + '","resultCount":"' + studioResult.length + '","data":' + JSON.stringify(studioResult) + '}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return;
                        } else {
                            resultJson = '{"replyCode":"error","replyMsg":"' + asynerr.message + '","resultCount":"0","data":""}\n';
                            connection.release();
                            callback(200, null, resultJson);
                            return;
                        }
                    })

                } else {
                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.noStudioFound + '","resultCount":"0","data":""}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            }
        })
    });
}

/*
 * function :- Studio  Detail
 * url : http://localhost:3232/studio_detail
 * description :- studio detail
 * parameters :- studio_id
 *
 */
function studio_detail(appdata, pool, callback) {
    fs.writeFile("filewrite/studio_listing_detail.txt", JSON.stringify(appdata));
    var offset = 0;
    var studio_id = '';
    var status = '1';

    if (typeof appdata.studio_id != 'undefined' && appdata.studio_id != '') {
        studio_id = appdata.studio_id;
    } else {
        resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.studioIdRequired + '"}\n';
        callback(200, null, resultJson);
        return;
    }
    pool.getConnection(function (err, connection) {
        var SelectStudio = 'SELECT studios.*,users.first_name,users.last_name,categories.cat_name,cancel_policies.policy_type FROM studios LEFT JOIN users ON studios.soid = users.id LEFT JOIN categories ON categories.id = studios.category_id LEFT JOIN cancel_policies ON  studios.cancel_policy = cancel_policies.id  WHERE studios.id = "' + studio_id + '"';
        console.log(SelectStudio);
        connection.query(SelectStudio, function (studioErr, studioResult) {
            if (studioErr) {
                resultJson = '{"replyCode":"error","replyMsg":"' + studioErr.message + '"}\n';
                connection.release();
                callback(400, null, resultJson);
                return;
            } else {
                if (studioResult.length > 0) {
                    var i = 0
                    studioResult = studioResult[0];
                    var getServices = 'SELECT services.id,services.service_name,services.service_price,services.service_name_price FROM services WHERE services.id IN (' + studioResult.studio_services + ')'
                    console.log(getServices)
                    connection.query(getServices, function (getServicesErr, getServicesResult) {
                        if (getServicesErr) {
                            resultJson = '{"replyCode":"error","replyMsg":"' + getServicesErr.message + '"}\n';
                            connection.release();
                            callback(400, null, resultJson);
                            return;

                        } else {
                            console.log(JSON.stringify(getServicesResult));
                            studioResult['services'] = getServicesResult
                            //For Images
                            async.eachSeries(studioResult, function (studio, loopimage) {
                                var getStudioImages = 'SELECT studio_images.id,studio_images.img_name FROM studio_images WHERE studio_images.studio_id = "' + studio_id + '"'

                                connection.query(getStudioImages, function (getStudioImagesErr, getStudioImagesResult) {
                                    if (getStudioImagesErr) {
                                        loopimage()
                                        i++
                                    } else {

                                        studioResult['studio_images'] = getStudioImagesResult
                                        loopimage();
                                        i++
                                    }
                                })
                            }, function (asynerr) {
                                if (!asynerr) {
                                    //For Calendar
                                    async.eachSeries(studioResult, function (studio, loopcalendar) {
                                        var getStudioCalendar = 'SELECT studio_calendars.id,DATE_FORMAT(studio_calendars.date, "%Y-%m-%d") as format_date,DATE_FORMAT(studio_calendars.start_time, "%h:%i %p") as formated_start_time,DATE_FORMAT(studio_calendars.end_time, "%h:%i %p") as formated_end_time FROM studio_calendars WHERE studio_calendars.studio_id = "' + studio_id + '"'

                                        connection.query(getStudioCalendar, function (getStudioCalendarErr, getStudioCalendarResult) {
                                            if (getStudioCalendarErr) {
                                                loopcalendar()
                                                i++
                                            } else {

                                                studioResult['studio_calendar'] = getStudioCalendarResult
                                                loopcalendar();
                                                i++
                                            }
                                        })
                                    }, function (asynerr) {
                                        if (!asynerr) {
                                            
                                              //var SelectStudio = 'SELECT studios.*,ROUND(( 3959 * acos( cos( radians("' + lat + '") ) * cos( radians(`lat` ) ) * cos( radians(`lng`) - radians("' + lng + '")) + sin(radians("' + lat + '")) * sin( radians(`lat`)))),2) AS distance,(SELECT img_name FROM studio_images WHERE studios.id = studio_images.studio_id Limit 1) as studio_image  FROM studios WHERE ' + searchby + ' studios.status = 1   HAVING ROUND(distance,2) < ' + distance + '  ORDER BY distance ASC LIMIT ' + offset + ',' + limit;


                                            resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.dataSuccess + '","resultCount":"1","data":' + JSON.stringify(studioResult) + '}\n';
                                            connection.release();
                                            callback(200, null, resultJson);
                                            return;
                                        } else {
                                            resultJson = '{"replyCode":"error","replyMsg":"' + asynerr + '","resultCount":"0","data":""}\n';
                                            connection.release();
                                            callback(200, null, resultJson);
                                            return;
                                        }
                                    })
                                } else {
                                    resultJson = '{"replyCode":"error","replyMsg":"' + asynerr.message + '","resultCount":"0","data":""}\n';
                                    connection.release();
                                    callback(200, null, resultJson);
                                    return;
                                }
                            })
                        }
                    })


                } else {
                    resultJson = '{"replyCode":"error","replyMsg":"' + responseVar.noStudioFound + '","resultCount":"0","data":""}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            }
        })
    });
}


/*
 * function :- Services Listing
 * url : http://localhost:3232/services_listing
 * description :- all services listing
 * parameters :- 
 *
 */
function services_listing(appdata, pool, callback) {
    fs.writeFile("filewrite/services_listing.txt", JSON.stringify(appdata));
    

    pool.getConnection(function (err, connection) {
        var selectServices = 'SELECT * FROM services WHERE status = 1';

        console.log(selectServices);
        connection.query(selectServices, function (serviceErr, serviceResult) {
            if (serviceErr) {
                resultJson = '{"replyCode":"error","replyMsg":"' + serviceErr.message + '"}\n';
                connection.release();
                callback(400, null, resultJson);
                return;
            } else {
                if (serviceResult.length > 0) {
                resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.ServiceFound + '","resultCount":"0","data":'+JSON.stringify(serviceResult)+'}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                } else {
                    resultJson = '{"replyCode":"success","replyMsg":"' + responseVar.noServiceFound + '","resultCount":"0","data":""}\n';
                    connection.release();
                    callback(200, null, resultJson);
                    return;
                }
            }
        })
    });
}