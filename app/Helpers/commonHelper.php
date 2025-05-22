<?php

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\{Notification,Permission};
use Illuminate\Support\Facades\Storage;

function active_class($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function is_active_route($path) {
    //dd('Request::is', $path, \Request::is($path));
    return call_user_func_array('Request::is', (array)$path) ? true : false;
}

function show_class($path) {
    return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}

function format_text($text)
{
    return strtoupper($text);
}

function checkPermission($requiredPermissions = [])
{
    $hasAccess = false;
    $user = Sentinel::check();
    #This Is Master User? Have a Full permission
    $roles = Sentinel::getRoles()->pluck('slug')->all();
    if (is_array($roles)) {
        if (in_array('master', $roles)) {
            return true;
        }
    }

    # if user is not Master Admin
    foreach ($requiredPermissions as $requiredPermission) {
        $uri = parse_url($requiredPermission);
        $routeCheck = ( strpos($requiredPermission, '?}') === false) ? ltrim($uri['path'], '/') : $uri['path'] . '?}';
        $requiredPermission = Permission::select('permissions_name')->where(['route' => ltrim( $routeCheck, 'udp/' )])->first();
        $permission = ($requiredPermission) ? $requiredPermission->permissions_name : '';
        $hasAccess = ($user->hasAccess($permission)) ? true : (($hasAccess) ? true : false);
        //dd($requiredPermission, $uri, $routeCheck, $permission, $hasAccess);
    }
    return $hasAccess;
}

function format_date($date,$format="d M Y")
{
    date_default_timezone_set('Asia/Dubai');
    $dt = new DateTime($date);
    return $dt->format($format);
}

function getSystemDateNoTimeZone()
{
    date_default_timezone_set('Asia/Dubai');
    $dt = new DateTime();
    return $dt->format('d M Y H:i');
}

function getSystemDate()
{
    date_default_timezone_set('Asia/Dubai');
    $dt = new DateTime();
    return $dt->format('d M Y H:i A O') . " GMT";
}

function changeDateTimezone($timestamp)
{
    date_default_timezone_set('Asia/Dubai');
    $dt = new DateTime($timestamp);
    return $dt->format('d M Y H:i A O') . " GMT";
}

function getcurrentDate($format)
{
    date_default_timezone_set('Asia/Dubai');
    $dt = new DateTime();
    return $dt->format($format);
}
function getnextDate($format)
{
    date_default_timezone_set('Asia/Dubai');
    $dt = new DateTime();
    $dt->modify( 'next month' );
    return $dt->format($format);
}

function getPreviousdate($date,$format)
{
  date_default_timezone_set('Asia/Dubai');
  $dt = new DateTime($date);
  $dt->modify("-1 day");
  return $dt->format($format);
}

function ago($timestamp)
{
    date_default_timezone_set('Asia/Dubai');
    $today = new DateTime(date('y-m-d H:i:s'));
    $thatDay = new DateTime($timestamp);
    $dt = $today->diff($thatDay);
    $number = 0;
    $unit = '';
    if ($dt->y > 0) {
        $number = $dt->y;
        $unit = "year";
    } else if ($dt->m > 0) {
        $number = $dt->m;
        $unit = "month";
    } else if ($dt->d > 0) {
        $number = $dt->d;
        $unit = "day";
    } else if ($dt->h > 0) {
        $number = $dt->h;
        $unit = "hour";
    } else if ($dt->i > 0) {
        $number = $dt->i;
        $unit = "minute";
    } else if ($dt->s > 0) {
        $number = $dt->s;
        $unit = "second";
    }
    $unit .= $number  > 1 ? "s" : "";

    $ret = $number . " " . $unit . " " . "ago";
    return $ret;
}

function VoterSheetHeaders()
{
    $sheetHeading =[
        'FirstName',
        'LastName',
        'Email',
        'Phone',
        'Ward',
        'PollingStation',
        'City',
        'Region',
        'Constituency',
        'Ethnicity',
    ];
    return $sheetHeading;
}

function VoterSheetExportHeaders()
{
    $sheetHeading =[
        'FirstName',
        'LastName',
        'Email',
        'Phone',
        'Constituency',
        'Ward',
        'PollingStation',
        ''
    ];
    return $sheetHeading;
}

function notification($user_from, $message, $user_to = 0, $module_id, $company_id, $group_id = array(0), $role_id = array(0))
{
    $user = Sentinel::check();
    $user_from = ($user_from == '') ? $user->id : $user_from;
    $insertRole = new Notification();
    $insertRole->user_from = $user_from;
    $insertRole->message = $message;
    $insertRole->user_to = $user_to;
    $insertRole->module_id = $module_id;
    $insertRole->company_id = $company_id;
    $insertRole->group_id = implode(",", $group_id);
    $insertRole->role_id = implode(",", $role_id);
    $insertRole->save();
}

function getnotification($limit = 0)
{
    $current_user = Sentinel::check();
    $notification = Notification::whereRaw("? = ANY(string_to_array(group_id,',')) ", [$current_user->group_id])
        ->whereRaw("(role_id = '0' OR ? = ANY(string_to_array(role_id,',')))", [$current_user->roles[0]->id])
        ->whereRaw("(user_to = '0' OR user_to = ?)", $current_user->id)->orderBy('created_at', 'DESC');
    if ($limit != 0) {
        $notification->limit($limit);
    }
    return $notification->paginate(15);
}

function getcurrentUser($key)
{
    return \Request::get('bsLoginUser')->$key;
}

function array_search_partial($arr, $keyword) {
    $is_match = false;
    foreach($arr as $index => $string) {
        $is_match = (preg_match("/$keyword/",$string)) ? true : (($is_match) ? true : false);
    }
    return $is_match;
}

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function encode_url($data) {
    return encrypt($data);
}

function decode_url($data) {
    return decrypt($data);
}

function checkExcelFile($file_ext){
    $valid=array(
        'xls','xlt','xla','xlsx','xltx','xlsm','xltm','xlam','xlsb','sheet'
    );
    return in_array($file_ext,$valid) ? true : false;
}

function generateCardId($defaultFront, $profileImg, $font, $Name, $Gender, $CountryOfResidence, $Constituency, $MembershipID){
    //set the transparency of the source image
    $srcTransparency = 100; //the higher the clearer, max is 100

    //get the size of the source image, needed for imagecopymerge(). Profile Image Uploaded by User
    list($srcWidth, $srcHeight, $srcType) = getimagesize($profileImg);
    //create a new image from the source image

    //If image is jpeg
    if($srcType == IMAGETYPE_JPEG)
	{
        $src = imagecreatefromjpeg($profileImg);
    }
    //If image is gif
    else if($srcType == IMAGETYPE_GIF)
	{
        $src = imagecreatefromgif($profileImg);
    }
    //If image is png
	else if($srcType == IMAGETYPE_PNG)
	{
        $src = imagecreatefrompng($profileImg);
    }
    
    //create a new image from the destination image
    $dest = imagecreatefromjpeg($defaultFront);
    $width = 95;
    $height = 113;
    // Create new image to display
    $new_image = imagecreatetruecolor($width, $height);

    // Create new image with change dimensions
    imagecopyresized($new_image, $src, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
    //set the x and y positions of the source image on top of the destination image
    $src_xPosition = 20; //10 pixels from the left
    $src_yPosition = 5; //10 pixels from the top

    $src_cropXposition = 0; //do not crop at the side
    $src_cropYposition = 0; //do not crop on the top

    imagecolortransparent($new_image,imagecolorat($new_image,0,0));

    $textcolor = imagecolorallocate($dest, 0, 0, 0);
    //font path 
    
    //merge the source and destination images
    imagecopymerge($dest,$new_image,$src_xPosition,$src_yPosition,$src_cropXposition,$src_cropYposition,$width,$height,$srcTransparency);

    // create color
    $black = imagecolorallocate($new_image, 0, 0, 0);
    //
    //merge the source and destination images
    imagecopymerge($dest,$new_image,$src_xPosition,$src_yPosition,$src_cropXposition,$src_cropYposition,$width,$height,$srcTransparency);
    imagettftext($dest, 12, 0, 305, 125, $black, $font, $Name);
    //imagestring($dest, 5, 305, 115, $Name, $textcolor);
    imagettftext($dest, 12, 0, 305, 155, $black, $font, $Gender);
    //imagestring($dest, 5, 305, 145, $Gender, $textcolor);
    imagettftext($dest, 12, 0, 305, 190, $black, $font, 'Member');
    //imagestring($dest, 5, 305, 175, 'Member', $textcolor);
    imagettftext($dest, 12, 0, 305, 220, $black, $font, $CountryOfResidence);
    //imagestring($dest, 5, 305, 205, $CountryOfResidence, $textcolor);
    imagettftext($dest, 12, 0, 305, 255, $black, $font, $Constituency);
    //imagestring($dest, 5, 305, 245, $Constituency, $textcolor);
    imagestring($dest, 5, 85, 290, $MembershipID, $textcolor);

    // This function call can be copied into your project and can be made from anywhere in your code
    //$barcode = barcode( $filepath, $text, $size, $orientation, $code_type, $print, $sizefactor );
    $todayplus1year = date('d-m-y', strtotime('+5 years')); 
    imagestring($dest, 5, 355, 290, 'Expires: ' . $todayplus1year , $textcolor);

    $CardImage = Storage::disk('public')->path('udpCardId/' . $MembershipID . '.jpg');
    header('Content-Type: image/jpeg'); 
    imagejpeg($dest,$CardImage,100);
    
    //destroy the source image
    imagedestroy($src);

    //destroy the destination image
    imagedestroy($dest);
}