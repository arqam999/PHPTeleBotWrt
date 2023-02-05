<?php
error_reporting(E_ALL); ini_set('display_errors', 1);

$oc_ip = shell_exec('uci get network.lan.ipaddr'); // '192.168.1.1';
$oc_port = shell_exec('uci get openclash.config.cn_port'); // '9090';
$oc_secret = shell_exec('uci get openclash.config.dashboard_password'); // '1111';

function seeURL($url){
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
}

function delayColor($input){
    if ($input == 0) {
        return "⬛️";
    }elseif ($input >= 1 && $input <= 150) {
        return "🟩";
    }elseif ($input >= 151 && $input <= 300) {
        return "🟨";
    }elseif ($input >= 300 && $input <= 350) {
        return "🟧";
    }elseif ($input > 350) {
        return "🟥";
    }
}

function readXL(){

        $rawConfig = file_get_contents("./xl");
        $raw = explode("\n",$rawConfig);
        $number = $raw[0];
        return $number;
    
}

function ADB(){

        // Execute the ADB command for battery status and store the output in a variable
$battery_status = shell_exec('adb shell dumpsys battery');

// Execute the ADB command for signal strength and store the output in a variable
$signal_status = shell_exec('adb shell dumpsys telephony.registry');

// Execute the ADB command for device model and store the output in a variable
$device_model = shell_exec('adb shell getprop ro.product.model');

// android ver
$android_ver = shell_exec('adb shell getprop ro.build.version.release');

// Use regular expressions to extract the battery level
preg_match('/level: (\d+)/', $battery_status, $matches);
$battery_level = $matches[1];

// Use regular expressions to extract the battery status numeric value
preg_match('/status: (\d+)/', $battery_status, $matches);
$battery_status_numeric = $matches[1];

// Use regular expressions to extract the signal level
preg_match('/mSignalStrength=(\d+)/', $signal_status, $matches);
$signal_level = $matches[1];

// Trim the device model string to remove whitespaces
$device_model = trim($device_model);

// Check the numeric value of the battery status
if($battery_status_numeric == 2){
    $battery_status = "Charging";
}elseif($battery_status_numeric == 3){
    $battery_status = "Discharging";
}elseif($battery_status_numeric == 5){
    $battery_status = "Full";
}else{
    $battery_status = "Unknown";
}

// Print the battery level, status, signal level and device model
$result = "ADB Information
Battery Level   : $battery_level %
Battery Status  : $battery_status
Signal Level    : $signal_level
Device Model    : $device_model
Android Version : $android_ver";

return $result;

}

function MyXL($number){
    if ($number == "") {
        if (readXL() == null) {
            return "Nomor kosong, Setting nomor dengan /setxl 087x";
        }else{
            $data = seeURL("https://sidompul.cloudaccess.host/cek.php?nomor=".readXL());
            return $data;
        } 
    }else{
        $data = seeURL("https://sidompul.cloudaccess.host/cek.php?nomor=$number");
        return $data;
    }
}

function Proxies(){
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://192.168.1.1:9090/providers/proxies');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
$headers[] = 'Authorization: Bearer '. $GLOBALS["oc_secret"] .'';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Cookie: filemanager=ee057d392316be9bec05f297f2037536';
$headers[] = 'Referer: http://'. $GLOBALS["oc_ip"] .':'. $GLOBALS["oc_port"] .'/ui/yacd/?hostname='. $GLOBALS["oc_ip"] .'&port='. $GLOBALS["oc_port"] .'&secret='. $GLOBALS["oc_secret"] .'';
$headers[] = 'Sec-Gpc: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$data = json_decode($result,true);

$data = $data['providers']['default']['proxies'];
$final = "⏱ Type | Name | Delay\n";

    foreach ($data as $key => $value) {
        $name = $value['name'];
        $delay = $value['history'][-0]['delay'];
        $type = $value['type'];
        $color = delayColor($delay);
        $final .= "$color $type | $name | $delay ms \n";
    }
return $final."Alpha Ver - PHPTeleBotWrt";
}

function Rules(){
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://192.168.1.1:9090/rules');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: en-US,en;q=0.9';
$headers[] = 'Authorization: Bearer '. $GLOBALS["oc_secret"] .'';
$headers[] = 'Connection: keep-alive';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Cookie: filemanager=ee057d392316be9bec05f297f2037536';
$headers[] = 'Referer: http://'. $GLOBALS["oc_ip"] .':'. $GLOBALS["oc_port"] .'/ui/yacd/?hostname='. $GLOBALS["oc_ip"] .'&port='. $GLOBALS["oc_port"] .'&secret='. $GLOBALS["oc_secret"] .'';
$headers[] = 'Sec-Gpc: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$data = json_decode($result,true);

$data = $data['rules'];
$final = "Type | Payload | Proxy\n";

    foreach ($data as $key => $value) {
        $proxy = $value['proxy'];
        $payload = $value['payload'];
        $type = $value['type'];
        $final .= "$type | $payload | $proxy \n";
    }
return $final;
}

function myip(){
    $data = json_decode(seeURL("http://ip-api.com/json/"),true);
    $country = $data['country'];
    $countryCode = $data['countryCode'];
    $region = $data['regionName'];
    $city = $data['city'];
    $isp = $data['isp'];
    $timezone = $data['timezone'];
    $as = $data['as'];
    $ip = $data['query'];
    $result = "ISP : $isp\n↳ Address : $as \n↳ IP : $ip \n↳ Region | City : $region | $city \n↳ Timezone : $timezone \n↳ Country : $country | $countryCode \n↳ PHPTeleBotWrt";
    return $result;
}

function Speedtest(){

$result = shell_exec('speedtest > result && cat result');
return $result;

}
