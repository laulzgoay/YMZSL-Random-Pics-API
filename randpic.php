<?php
/*
API Name:云梦泽深林随机图片API
Version:1.0.0
ForPHP:5.6+
Origin Author:倾丞(Jochen)/瑾忆(自醉)
Author Url:https://blog.qcair.cc/
Author Email:admin@qcair.cc
Secondary Development Author:小俊(LaulzGoay)
Secondary Development Author Url:https://www.smalljun.com
Secondary Development Author Email:lgy@ymzsl.com
*/

//使用Curl获取远程数据模块
function get_curl($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_URL, $url);
	$response = curl_exec($ch);
	curl_close($ch);
	//-------如果请求为空
	if (empty($response)) {
		return false;
	}
	return $response;
}

//------------设置区域开始------------
$APIname = "YMZSL-Random-Pics-API";
//此处填写API名称
$PicdomainPrefix = 'www.Your-API-Domain.com'; 
//无需添加协议头与 / （默认https，若不使用https，请移至 Line47 进行修改）
//API图片储存域名设置
$base64Times = "10";
//由于Base64转码会消耗服务器资源，此处填写每分钟限制Base64数据输出次数，例如填写10，则单用户每分钟只可调用返回数据10次，填写0或负数则不限制每分钟调用次数
//------------设置区域结束------------


//读取文本
$file='imgs.txt'; //图片文件名所在文件
$data = file_get_contents($file);
$arr = explode("\n", $data);
$img_names = $arr[array_rand($arr,1)];
//生成返回的图像URL
$imageUrl='https://'.$PicdomainPrefix.'/'.$img_names;
$imageUrl = trim($imageUrl);


//反爬虫,反扫描器模块
//获取用户UA信息
$UserUA = $_SERVER['HTTP_USER_AGENT'];

//将恶意USER_AGENT存入数组
$BAN_UA = array("FeedDemon", "BOT/0.1 (BOT for JCE)", "CrawlDaddy", "Java", "Feedly", "UniversalFeedParser", "ApacheBench", "Swiftbot", "ZmEu", "Indy Library", "oBot", "jaunty", "YandexBot", "AhrefsBot", "MJ12bot", "WinHttp", "EasouSpider", "HttpClient", "Microsoft URL Control", "YYSpider", "Python-urllib", "lightDeckReports Bot", "HTTrack ", "Apache-HttpClient", "Audit ", "DirBuster", "Pangolin", "Nmap", "sqln", "Hydra", "Parser", "Libwww", "BBBike", "sqlmap", "w3af", "OWASP", "Nikto", "Fimap", "Havij", "BabyKrokodil", "Netsparker", "httperf");


function is_BAN_UA($val)
{
	$UserUA = $_SERVER['HTTP_USER_AGENT'];
	return stripos($UserUA, $val);
}

$is_BAN_UA_Arr = array_filter($BAN_UA, "is_BAN_UA");

//禁止空USER_AGENT
if (!$UserUA) {
	header("Content-type: text/html; charset=utf-8");
	die('您的访问USER_AGENT被系统判定空，已被安全模块拦截！');
} else {
	//判断是否为恶意UA
	if (count($is_BAN_UA_Arr)) {
		header("Content-type: text/html; charset=utf-8");
		die('您的访问USER_AGENT被系统判定为恶意用户，已被安全模块拦截！');
	}
}

//根据用户的浏览器cookie确定同一用户访问API次数
if (!isset($_COOKIE['visits'])) $_COOKIE['visits'] = 0;
$visits = $_COOKIE['visits'] + 1;
setcookie('visits',$visits,time()+50);

//XML返回
function arrayXml($array, $wrap='RETURN', $upper=true) {
    // set initial value for XML string
#    $xml = '';
    // wrap XML with $wrap TAG
    if ($wrap != null) {
        $xml = "<$wrap>\n";
    }
    // main loop
    foreach ($array as $key=>$value) {
        // set tags in uppercase if needed
        if ($upper == true) {
            $key = strtoupper($key);
        }
        // append to XML string
        $xml .= "<$key>" . htmlspecialchars(urldecode(trim($value))) . "</$key>";
    }
    // close wrap TAG if needed
    if ($wrap != null) {
        $xml .= "\n</$wrap>\n";
    }
    // return prepared XML string
    return $xml;
}

//XML格式生成
$result['sever']=$APIname;
$result['code']=200;
$result['img']='//'.$PicdomainPrefix.'/'.$img_names;

//json格式
$json = array(
	"server" => "$APIname",
	"code" => "200",
	"type" => "image"
);

//Base64转码格式
//获取图像
$base64ImgCode = get_curl($imageUrl);
//file_get_contents('$imageUrl');
//将图像转换为字符串
//将图像字符串数据编码为base64
$base64ImgData = base64_encode($base64ImgCode);
//获取图像信息
$imageInfo = getimagesize($imageUrl);
//生成返回的完整Baes64图像码
if ($visits <= $base64Times) { 
$base64ImgReturn = 'data:' . $image_info['mime'] . ';base64,' .$base64ImgData;
 } else {
            $base64ImgReturn = "<strong>Api-Warning:</strong> 该参数调用限制每分钟"."$base64Times"."次，等等再来试试看吧！（づ￣3￣）づ╭❤～";
 }       
 
$returnType = $_GET['return'];
switch ($returnType) {
	case 'url':
		echo $imageUrl;
		echo "<br>";
		echo "200-OK()";
		echo "<br>";
		echo "Get Url Information Success from " . $APIname;
		break;

	case 'img':
		$img = file_get_contents($imageUrl, true);
		header("Content-Type: image/jpeg;");
		echo $img;
		break;

	case 'json':
		$json['PicUrl'] = $imageUrl;
		$imageInfo = getimagesize($imageUrl);
		$json['width'] = "$imageInfo[0]";
		$json['height'] = "$imageInfo[1]";
		header('Content-type:text/json');
		echo json_encode($json);
		break;

    case 'xml':
        header("Content-type:text/xml");
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo arrayXml($result);
        break;	
        
    case 'base64Img':
        if ($visits <= $base64Times) {
	echo '<img src="' . $base64ImgReturn . '" />';
} else {
	echo "<strong>Api-Warning:</strong> 该参数调用限制每分钟"."$base64Times"."次，等等再来试试看吧！（づ￣3￣）づ╭❤～";
}
        break;
       
    case 'base64Code':
        echo $base64ImgReturn;
        echo "<br>";
		echo "200-OK()";
		echo "<br>";
		echo "Get Base64 Information Success from " . $APIname;
        break;	
        
    case 'https':
	header("Location:".$imageUrl);
	break;
                            
	case 'http':
	$returnUrl=str_replace("https","http", $imageUrl);
	header("Location:" . $returnUrl);
	break;
	
	default:
		header("Location:" . $imageUrl);
		break;
}

//统计API调用次数
//@session_start();  //若访问压力大可尝试同一访客不重复记录,删去该行前//注释符即可
$Count = file_get_contents("./count.txt");
//读取数据文件
if (!$_SESSION['#']) {
	$_SESSION['#'] = true;
	$Count++;
	//刷新一次+1
	$ApiTimes = fopen("./count.txt", "w");
	//以写入的方式，打开文件，并赋值给变量ApiTimes
	fwrite($ApiTimes, $Count);
	//将变量ApiTimes的值+1
	fclose($ApiTimes);
}