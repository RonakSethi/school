exports.sendandroidNotification = function (androidToken, message, payloadField, payloadValue, callback) {
    var http = require('http');
    var data = {"collapseKey": "applice",
        "delayWhileIdle": true,
        "timeToLive": 3,
        "data": {"message": message,
            "PATH": payloadValue,
            "title": "Ustunner"
        },
        "registration_ids": [androidToken]
    };

    console.log('pushdataAndroid>>>>>>>>', data);
    var dataString = JSON.stringify(data);
    var headers = {
        'Authorization': 'key=AAAAx4cxqhM:APA91bE-l7VyTv787U5CQq6MJgO4cCfoaFtQSS_cAa1_HuAX-KifuWYrJkTJ9xVWLRaGrHN0sFnhB_rmStXg46t6TC1aG1sI4x85IHYxkrdiYuDQBu8r72k7VlWTVl7qSqX6mKqzg1ViBxIj9fTpV0lUb3DAuUCI3Q',
        'Content-Type': 'application/json',
        'Content-Length': dataString.length
    };

//    var options = {host: 'android.googleapis.com',
    var options = {host: 'fcm.googleapis.com',
        port: 80,
//        path: '/gcm/send',
        path: '/fcm/send',
        method: 'POST',
        headers: headers
    };

    //Setup the request 
    var req = http.request(options, function (res) {
        res.setEncoding('utf-8');
        var responseString = '';

        res.on('data', function (data) {
            responseString += data;
        });

        res.on('end', function () {
            console.log('responseString msg--->', responseString);
            var resultObject = JSON.parse(responseString);
        });
    });
    req.on('error', function (e) {
        //TODO: handle error.
        //console.log('error : ' + e.message + e.code);
        //callback(false);
    });

    req.write(dataString);
    req.end();
}