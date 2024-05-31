<?php


define("RUTA_BASE",$_SERVER['DOCUMENT_ROOT']."/");
define("HTTP_BASE","http://127.0.0.1/SaborXpress");

define('ROOT_DIR',RUTA_BASE.'SaborXpress');
define('ROOT_CORE',RUTA_BASE.'SaborXpress/core');
define('ROOT_UPLOAD',RUTA_BASE.'SaborXpress/uploads');
define('ROOT_VIEW',RUTA_BASE.'SaborXpress/view');
define('ROOT_REPORT',RUTA_BASE.'SaborXpress/reports');
define('ROOT_REPORT_DOWN',RUTA_BASE.'SaborXpress/reports_download');

define("URL_RESOURCES", HTTP_BASE."/public/");

define('SECRET_KEY','SABORXPRESS.jksdfwonfeaSDGMSDM345Lgomsda435lkfnsdalfASD7MGSDL2345FJSADOGJsadf232');
define('ALGORITHM','HS256');
;