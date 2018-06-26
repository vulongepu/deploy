<?php
 
$ch = curl_init();

$field['username'] = 'longvn';
$field['password'] = '01678592347';
$field['submit'] = 'Đăng nhập';

$datafield = http_build_query($field);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_URL, 'https://erp.nhanh.vn/user/signin');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datafield);
curl_exec($ch);

curl_setopt($ch, CURLOPT_URL, 'https://erp.nhanh.vn');

$ketqua = curl_exec($ch);

echo $ketqua;
curl_close($ch);

// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// var_dump($ketqua);die;
