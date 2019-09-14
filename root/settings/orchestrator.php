<?php
if (!isset($_SESSION)) {
    session_start();
}

/*
if($_SERVER["HTTPS"] != "on" && 1 === 2){
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}*/

define("DIRNAME", dirname(__FILE__) . "/");


/*
 * LOAD THE FUNCTIONS
 */
require_once(DIRNAME . "../functions/XML2Array.php");
require_once(DIRNAME . "../functions/sanitize_output.php");
require_once(DIRNAME . "../functions/translate.php");
require_once(DIRNAME . "../functions/get_request.php");
require_once(DIRNAME . "../functions/is_selected.php");

use PHPMailer\PHPMailer\PHPMailer;

/*
 * LOAD THE CLASSES
 */
require_once(DIRNAME . "../class/lessphp/lessc.inc.php");
require_once(DIRNAME . "../class/AES.php");
require_once(DIRNAME . "../vendor/autoload.php");
require_once(DIRNAME . "../class/URL.php");
require_once(DIRNAME . "../class/Browser.php");
require_once(DIRNAME . "../class/Number.php");
require_once(DIRNAME . "../class/Charset.php");
require_once(DIRNAME . "../class/Database.php");
require_once(DIRNAME . "../class/Encoding.php");
require_once(DIRNAME . "../class/Security.php");
require_once(DIRNAME . "../class/Settings.php");
require_once(DIRNAME . "../class/Images.php");
require_once(DIRNAME . "../class/Account.php");
require_once(DIRNAME . "../class/AccountSettings.php");
require_once(DIRNAME . "../class/Module.php");
require_once(DIRNAME . "../class/Date.php");
require_once(DIRNAME . "../class/Translate.php");
require_once(DIRNAME . "../class/Logger.php");
require_once(DIRNAME . "../class/Address.php");
require_once(DIRNAME . "../class/Products.php");
require_once(DIRNAME . "../class/Sales.php");
require_once(DIRNAME . "../class/SalesProducts.php");

require_once(DIRNAME . "../class/PHPMailer-6.0.3/src/Exception.php");
require_once(DIRNAME . "../class/PHPMailer-6.0.3/src/PHPMailer.php");
require_once(DIRNAME . "../class/PHPMailer-6.0.3/src/SMTP.php");


$less = new lessc;
$url = new URL();
$browser = new Browser();
$number = new Number();
$charset = new Charset();
$encoding = new Encoding();
$database = new Database();
$security = new Security();
$settings = new Settings();
$images = new Images();
$account = new Account();
$customer = new Account();
$account_settings = new AccountSettings();
$module = new Module();
$date = new Date();
$translate = new Translate();
$logger = new Logger();
$mailer = new PHPMailer();
$address = new Address();
$products = new Products();
$sales = new Sales();
$salesProducts = new SalesProducts();

/* ============ CONSTANTS */


define("SERVER", $settings->getServerURL());
define("DASHBOARD", $settings->getDashboardURL());
define("STYLESHEET_PATH", SERVER . "static/css/");
define("JAVASCRIPT_PATH", SERVER . "static/js/");
define("IMAGES_PATH", SERVER . "static/img/");
define("FONTS_PATH", SERVER . "static/fonts/");

define("LOGIN_PAGE", SERVER . "pags/login");
define("LOGOUT_PAGE", SERVER . "pags/logout");
define("REGISTER_PAGE", SERVER . "pags/register");


/* MINIFYING ========================*/

use MatthiasMullie\Minify;

$minifierCSS = new Minify\CSS();
$minifierJS = new Minify\JS();

ob_start("sanitize_output");


