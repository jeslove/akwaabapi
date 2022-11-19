<?php
##################################################
#             Database configuration             #
##################################################
# DB_HOST:	The MySQL server to connect to		 #
# DB_USER:	The MySQL server username			 #
# DB_PASS:	The MySQL server password			 #
# DB_NAME:	The MySQL server database			 #
#                                                #
##################################################

define('DEBUG', true); // DEBUG MODE ON

define('DB_NAME', 'akwaaba'); //Databse Name restapi #digichor_tesanotbc

define('DB_USER', 'root'); //Databse UserName #digichor_tbchurch

define('DB_PASSWORD', ''); //Databse Password #6t#DFwXQtblf

define('DB_HOST', 'localhost'); //Databse Host #mysql3000.mochahost.com

define('DRIVER','mysql'); // Database drivers example: postsql,mssql, mysql,oracle etc

define('PREFIX',''); // table prefix name

define('COLLATION','utf8_unicode_ci'); //database collations

define('CHARSET','utf8'); // database charset

// Production connections

#####################################################
#              System  directory                #
#####################################################

define('DS', DIRECTORY_SEPARATOR);

define('ROOT', dirname(__FILE__));

define('DEFAULT_CONTROLLERS', '');

define('DEFAULT_METHOD', 'create');

define('BASE_PATH', 'http://localhost/api/');

define('BASE_ORIGIN', 'http://localhost:4200');

define('ENVERONMENT','Development');// Change to {Production} mode if on live server


########################################################
#           API KEYS AND ALGOS						   #
########################################################

define('ENCRYPT', '!@hhdgshHRIJLJLF1233232#%>:{]}&&)^<,.746644343dsdsds!@');

define('AUTH_KEY','HS256');

define('API_KEY','!@hhdgshHRIJLJLF1233232#%>!@');

define('VERIFICATION_CODE','12345678902345678903456789045678905678906789078908909010');

define('ATHORIZATION_HEADER_NOT_FOUND', 401);

define('APISecret','acvMExxxxxxxxxxxxSBPkjxxxx');

define('APIAccess','U2FsdGVkX18RjAFhm+yqWOSUQMRQmC9SdakWO8I4wt4=');


########################################
#      EMAIL SMPT CONFIGURATION		   #
########################################

## Set all fields empty if not in use.##

define('EMAIL_SMTP_PORT', 587);

// define('EMAIL_SMTP_USERNAME', '');

// define('EMAIL_SMTP_PASSWORD', '');

define('EMAIL_SMTP_HOST', 'http://akwaaba.fytino.com'); //smtp.example.com/smtp://localhost

// define('EMAIL_SMTP_AUTH', '');

define('EMAIL_SECURITY_PORT','tls');//TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

define('USERCASE','Localhost'); // If on live server set [Localhost] to [Live]

// define('SET_FROM','Roma Catholic Church');

define('SET_FROM_MAIL','info@akwaaba.com');
define('MAILCC','info@akwaaba.com');
define('MAILBCC','info@akwaaba.com');

// <div align="center"><img src="cid:logo" width="100px"></div>

#######################################
#			   ERRORS				  #
# Set to ZERO (0) on production level #
#######################################

define('ERR',1);

#########################################
#            FILE UPLOADS				#
#########################################

define('UPLOADS', 'uploads');

define('ATTACHMENT', 'attachment');

define('LOGOS', 'logos');






