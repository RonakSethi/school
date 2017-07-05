var request = require("request"),
        http = require("http"),
        util = require("util"),
        fs = require('fs-extra'),
        path = require('path'),
        net = require('net'),
        config = require('./config'),
        PORT = config.port,
        Users = require('./users.js'),
Jamspot = require('./school.js');

imageFilePath = config.imageFilePath;

// configs

var bodyParser = require('body-parser');
var express = require('express');
var mysql = require('mysql');
var pool = mysql.createPool({
    host: config.mysql_host,
    user: config.mysql_user,
    password: config.mysql_password,
    database: config.mysql_database,
});

var app = express();
app.use(bodyParser.urlencoded({limit: '50mb', extended: false}));
app.use(bodyParser.json({limit: '50mb'}));

// listen clients
var server = app.listen(config.port, function () {
    var host = server.address().address;
    var port = server.address().port;
    console.log(config.SITE_TITLE, 'listening on port', port);
});




// allow cross origin domain
app.use(function (req, res, next) {
    var userdata = req.body;
    if (config.DEBUG > 0)
        console.log('####################################### ' + req.url + ' API IS CALLED WITH DATA: ', userdata);
    fs.writeFile("filewrite/postdata.txt", JSON.stringify(userdata), function (err) {
    });
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    console.log('Auth login section');
    // check if user is exists or not
    var currentUser = userdata.sid;

    if (currentUser != undefined && currentUser != "") {
        Users.is_user_exists(currentUser, pool, function (http_status_code, err, response) {
            if (err) {
                throw err;
            }
            //console.log(http_status_code);
            if (http_status_code == 200) {
                // forward to next route
                next();
            } else {
                if (config.DEBUG == 2) {
                    console.log();
                    console.log(response);
                    console.log();
                }
                // invalid login id
                res.status(http_status_code).send(response);
            }
        });
    } else {
        // forward to next route
        next();
    }
});


app.post('/signupVerified', function (req, res) {
    var userdata = req.body;
    Users.signupVerified(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/register', function (req, res) {
    var userdata = req.body;
    
    Users.register(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/fbVerified', function (req, res) {
    var userdata = req.body;
    Users.fbVerified(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/login', function (req, res) {
    var userdata = req.body;
    Users.login(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});

app.post('/resend_otp', function (req, res) {
    var userdata = req.body;
    Users.resend_otp(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});


app.post('/forgot_password', function (req, res) {
    var userdata = req.body;
    Users.forgot_password(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});

app.post('/changePassword', function (req, res) {
    var userdata = req.body;
    Users.changePassword(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});



app.post('/logout', function (req, res) {
    var userdata = req.body;
    Users.logout(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/basic_profile', function (req, res) {
    var userdata = req.body;
    Users.basic_profile(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/edit_profile', function (req, res) {
    var userdata = req.body;
    Users.edit_profile(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/static_content', function (req, res) {
    var userdata = req.body;
    Users.static_content(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/edit_content', function (req, res) {
    var userdata = req.body;
    Users.edit_content(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/static_content_list', function (req, res) {
    var userdata = req.body;
    Users.static_content_list(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});

app.post('/studio_listing', function (req, res) {
    var userdata = req.body;
    Jamspot.studio_listing(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/studio_detail', function (req, res) {
    var userdata = req.body;
    Jamspot.studio_detail(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});
app.post('/services_listing', function (req, res) {
    var userdata = req.body;
    Jamspot.services_listing(userdata, pool, function (http_status_code, err, response) {
        if (err) {
            throw err;
        }
        if (config.DEBUG == 2)
            console.log(response);
        res.status(http_status_code).send(response);
    });
});