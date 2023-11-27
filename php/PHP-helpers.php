<?php


/**
 * file_upload
 *
 * @param  mixed $fileControlName
 * @param  mixed $oldFileName
 * @param  mixed $allowedExtensions
 * @return void
 */
function file_upload($fileControlName, $oldFileName = '', $allowedExtensions = ["jpg", "jpeg", "png", "gif"])
{
    $result = ['status' => false, 'message' => '', 'file' => '', 'file_path' => ''];
    if (!file_exists(UPLOAD_PATH)) {
        mkdir(UPLOAD_PATH);
    }
    $uploadDir = UPLOAD_PATH;
    $fileToUpload = $_FILES[$fileControlName];
    // Check if a file was uploaded
    if ($fileToUpload["error"] == UPLOAD_ERR_OK) {
        $originalName = $fileToUpload["name"];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        // Check if the file extension is allowed
        if (in_array(strtolower($extension), $allowedExtensions)) {
            $newFileName = uniqid() . "." . $extension;
            $targetFilePath = $uploadDir . $newFileName;
            $oldFilePath = $uploadDir . $oldFileName;

            // Check if a file with the same name exists and remove it
            if (file_exists($targetFilePath)) {
                unlink($targetFilePath);
            }

            // Move the uploaded file to the upload directory
            if (move_uploaded_file($fileToUpload["tmp_name"], $targetFilePath)) {
                $result['message'] =  "File uploaded successfully.";
                $result['status'] = true;
                $result['file'] = $newFileName;
                $result['file_path'] = $targetFilePath;
                // remove old file to save space
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            } else {
                $result['message'] =  "Error uploading file.";
            }
        } else {
            $result['message'] =  "Invalid file format. Allowed formats: " . implode(", ", $allowedExtensions);
        }
    } else {
        $result['message'] = $fileToUpload["error"];
    }
    return $result;
}


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
//1. replace mysql_query with mysqli_query($_SESSION['conn'],$SQL)

function is_exist($tbl_name, $field_name, $field_value, $pk, $pk_value)
{
    $ci = &get_instance();
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


function get_ip_details()
{
    $ip = $_SERVER['REMOTE_ADDR'];
    $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
}


//---------debug function ---------------
function debug($arg, $is_die = 0)
{
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

function setUserCookie($USER_ROW)
{
    $json = json_encode($USER_ROW);
    setcookie('user', $json, time() + (86400 * 30), "/"); // 86400 = 1 day
}

function getUserCookie()
{
    $temp = new stdClass();
    if (isset($_COOKIE['user']) && $_COOKIE['user'] != "" && $_COOKIE['user'] != "0") {
        $json = json_decode($_COOKIE['user']);
        $temp = (object) $json;
    }
    return $temp;
}



function show404($msg = '')
{
    $html = '<div style="text-align:center;background-color:white;">';
    $html .= '<h3>System Error: Content Not Avaialble</h3>';
    if ($msg != "") {
        $html .= '<h2>Message:' . $msg . '</h2>';
    }
    $html .= '</div>';
    echo $html;
    exit;
}

function permission_denied()
{
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





function generate_slug($title) {   
    $slug = strtolower($title);
    $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', $slug);
    $slug = trim($slug, '-');    
    return $slug;
}


/***************************
 *  JSON DECODE
 ***************************/

function get_json_decode($json_string, $is_array = FALSE)
{
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
        $sn = $page_size * ($_GET['page'] - 1);
    }
    return $sn;
}

/***********************************************
CI-3 BASE URL AND ROOT PATH SETUP
 **********************************************/

//root index.php
function is_localhost()
{
    return $_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1';
}
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

if (is_localhost()) {
    define('ENVIRONMENT', 'development');
} else {
    define('ENVIRONMENT', 'production');
}

//config/config.php
$config['base_url'] = get_base_url(ENVIRONMENT);
$config['root_path'] = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;


//create dummy image in php8
 protected function createDummyImage($width, $height, $backgroundColor = [0, 0, 0], $textColor = [255, 255, 255], $text = 'Dummy Image')
    {
        // Create a blank image
        $image = imagecreatetruecolor($width, $height);

        // Allocate background color
        $bgColor = imagecolorallocate($image, $backgroundColor[0], $backgroundColor[1], $backgroundColor[2]);
        imagefill($image, 0, 0, $bgColor);

        // Allocate text color
        $txtColor = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);

        // Add text to the image
        $fontPath = __DIR__ . '/arial.ttf'; // Path to a TrueType font
        $fontSize = 20; // Adjust font size as needed
        $textBox = imagettfbbox($fontSize, 0, $fontPath, $text);
        $textWidth = $textBox[2] - $textBox[0];
        $textHeight = $textBox[7] - $textBox[1];
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2;
        imagettftext($image, $fontSize, 0, $x, $y, $txtColor, $fontPath, $text);

        // Save the image to a file
        $filePath = self::DATA_DIRECTORY . 'dummy_image.png';
        imagepng($image, $filePath);

        // Clean up
        imagedestroy($image);

        return $filePath;
    }