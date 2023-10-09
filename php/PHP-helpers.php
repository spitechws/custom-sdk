<?php
-----Android Development-----------
keytool -list -v -keystore "%USERPROFILE%\.android\debug.keystore" -alias androiddebugkey -storepass android -keypass android

Debug Sha1: 33:0F:56:64:66:03:BA:B5:4E:ED:DE:3C:1D:AE:B4:CD:8D:A1:68:25

Debug sha256 : 3D:C5:4A:A0:12:50:F8:A9:85:F9:F4:FE:E7:A1:85:2F:5D:C2:CB:C9:2F:CA:A0:07:7A:96:A5:1E:D3:FB:B5:51


//--------------CODEIGNITER--------------

//----file session----------
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = sys_get_temp_dir();
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = TRUE;



//--------------MYSQL TO MYSQLI MIGRation ---------------------
1. replace mysql_query with mysqli_query($_SESSION['conn'],$SQL)

function is_exist($tbl_name, $field_name, $field_value, $pk, $pk_value) {
    $ci = & get_instance();
    $response = false;
    if (!empty($field_value)) {
        $academy_id = config_item('aAcademy')->academy_id;
        if ($pk_value > 0) { // edit validation
            $qry = "select $field_name from " . tbl_prefix() . $tbl_name . " where academy_id=$academy_id and ";
            $qry .= " $field_name ='" . $field_value . "' and $pk!='" . $pk_value . "'";
        } else { // add validation
            $qry = "select $field_name from " . tbl_prefix() . $tbl_name . " where academy_id=$academy_id and ";
            $qry .= " $field_name ='" . $field_value . "'";
        }
        $row = $ci->db->query($qry)->row();
        if (isset($row->$field_name)) {
            $response = true;
        }
    }
    return $response;
}

---
function SetFocus($ID = "")
	{
		if (strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE')) {
		} else {
		?>
			<script>
				$('#Content').hide(1);
				$('#Content').show(500);
				var element = document.getElementById('<?php echo $ID ?>');
				element.focus();
			</script>

		<?php }
	}
---	

function get_ip_details(){
	$ip = $_SERVER['REMOTE_ADDR'];          
    $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
}


//---------debug function ---------------
function debug($arg, $is_die = 0) {
    echo '<pre>';
    if (is_array($arg) || is_object($arg)) {
        print_r($arg);
    } else {
        echo $arg;
    }
    echo '</pre>';
    if ($is_die == '1') {
        exit;
    }
}

function setUserCookie($USER_ROW) {
    $json = json_encode($USER_ROW);
    setcookie('user', $json, time() + (86400 * 30), "/"); // 86400 = 1 day
}

function getUserCookie() {
    $temp = new stdClass();
    if (isset($_COOKIE['user']) && $_COOKIE['user'] != "" && $_COOKIE['user'] != "0") {
        $json = json_decode($_COOKIE['user']);
        $temp = (object) $json;
    }
    return $temp;
}



function show404($msg = '') {
    $html = '<div style="text-align:center;background-color:white;">';
    $html .= '<h3>System Error: Content Not Avaialble</h3>';
    if ($msg != "") {
        $html .= '<h2>Message:' . $msg . '</h2>';
    }
    $html .= '</div>';
    echo $html;
    exit;
}

function permission_denied() {
    $html = '<div style="text-align:center;background-color:white;">';
    $html .= '<h3>System Error: Permission Denied: You are not allowed to change the url or this url is not exist.</h3>';
    $html .= '</div>';
    echo $html;
    exit;
}

function is_localhost()
{
    return $_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1';
}

//-------delete file-----------

---------------windows--------------

DEL /S/Q falcon.php

--------ubuntu--------------------
Goto Root Directory and type bellow command

find -type f -name "*.swp" -delete


/******************************
 *  CI FILE SESSION
 * ****************************/

$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'session';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;



/******************************
 *  EMAIL API
 * ****************************/

//$arrParam = array(
//    "to" => "",   // Example: "Bob <bob@host.com>". You can use commas to separate multiple recipients.
//    "subject" => "",
//    "message" => "",    
//    "cc" => "",
//    "bcc" => "",
//    "attachment" => ""  // physical path of file
//);
function send_spitech_mail($aParam) {
    if (isset($aParam['attachment']) && !empty($aParam['attachment'])) {
        $file = __DIR__ . "\\" . $aParam['attachment'];
        $mime = mime_content_type($file);
        $info = pathinfo($file);
        $name = $info['basename'];
        $output = new CURLFile($file, $mime, $name);
        $aParam["file"] = $output;
    }
    $url = 'http://spitech.in/';
    $url .= 'global_api/send_email';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $aParam);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = array(
        "Content-Type: multipart/form-data",
        "Accept: application/json",
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $response = json_decode($response, TRUE);
    curl_close($ch);
    $curl_error = curl_error($ch);
    $result = "failed";
    if ($curl_error == "") {
        if (isset($response['status']) && $response['status'] == "1") {
            $result = "success";
        } else {
            $result = $response['message'];
        }
    } else {
        $result = "Send Mail Error:" . $curl_error;
    }
    return $result;
}



/***************************
 *  JSON DECODE
 ***************************/

function get_json_decode($json_string, $is_array = FALSE) {
    $response = json_decode($json_string, $is_array);
    $json_error_code = json_last_error();
    if ($json_error_code) {
        $error = array(
            "json_error_code" => $json_error_code,
            "json_error" => json_last_error_msg(),
            "json_string" => $json_string
        );
        debug($error);
    }
    return $response;
}    

function get_sn($page_size = 10)
{
    if (!isset($page_size)) {
        $page_size = config('global.page_limit');
    }
    $sn = 1;
    if (!empty($_GET['page']) && $_GET['page'] > 1) {      
        $sn = $page_size * ($_GET['page']-1);
    }  
    return $sn;
}      

**********************************************
CI-3 BASE URL AND ROOT PATH SETUP
**********************************************

--- root index.php
function get_base_url($environment = 'development')
{
    if ($environment == 'production') {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
        $root = $protocol . $_SERVER['HTTP_HOST'] . '/';
    } else {
        $root = "http://" . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    }
    return $root;
}

function is_localhost()
{
    return $_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1';
}

if (is_localhost()) {
    define('ENVIRONMENT', 'development');
} else {
    define('ENVIRONMENT', 'production');
}

-- config/config.php
$config['base_url'] = get_base_url(ENVIRONMENT);
$config['root_path'] = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;