var config = {}
config.port                     = 3232;
config.mysql_host               = 'localhost';
config.mysql_user               = 'root';
config.mysql_password           = '';
config.mysql_database           = 'tracker';
config.imgUrl                   = 'http://localhost/school/';
config.imageFilePath            = '../uploads/';
config.hashSalt                 = 'DYhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi12';
config.adminEmailConfig         = 'kiplphp70@konstantinfosolutions.com';
config.smtpMailUser             = 'konstantiphone@gmail.com';
config.smtpMailPass             = 'konstant123';
config.SITE_URL                 = 'http://localhost/school/admin';
config.SITE_TITLE               = 'School App';
config.DEBUG                    = 2;
config.limit                    = 10;

//Twilo Login Details
//test account twillo          //(224) 231-4760
config.twilioAccountSid		= 'ACdb9a70291c70dc3fba10938d71bd4e36';
config.twilioAuthToken		= 'e419c10e3a2f2e43bb84a0a8b200babf';
config.twilioFrom		= '+12065694873';
module.exports                  = config;