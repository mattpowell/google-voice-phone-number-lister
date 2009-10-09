<pre><?php
set_time_limit(0);
$amount=10;
for ($x=0;$x<=$amount;$x+=5) {

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
curl_setopt($ch, CURLOPT_HEADER, 1); 
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)'); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
curl_setopt($ch, CURLOPT_REFERER, "https://www.google.com/voice/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, TRUE);
curl_setopt($ch, CURLOPT_ENCODING , 'gzip'); 
curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
$post=array("service"=>"grandcentral","Email"=>"google-account-email","Passwd"=>"password");
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'C:\\cookies.txt'); 
curl_setopt($ch, CURLOPT_COOKIEJAR, 'C:\\cookies.txt'); 
$cookies = implode("; ",explode("\n",trim(curl_exec($ch))));
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/voice/setup/search/?ac=312&start=".$x);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_COOKIE, $cookies); 
$data = curl_exec($ch);
curl_close($ch);
if ($x>50) exit();
$data=strstr($data,"{");
$amount=json_decode($data)->JSON->num_matches;
$data=json_decode($data)->JSON->vanity_info;
foreach ($data as $k=>$v) {
	$phone=str_replace("+1","",$k);
	echo preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone)."\n";
}
}
?>