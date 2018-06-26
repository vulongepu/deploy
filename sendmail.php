<?php
	//goi thu vien
	include('class.smtp.php');
	include "class.phpmailer.php"; 
	include "functions.php"; 
	$title = 'Hướng dẫn gửi mail bằng phpmailer';
	$content = 'Bạn đang tìm hiểu về cách gửi email bằng php mailler trên freetuts.net chúc các bạn có những phút giây vui vẻ.';
	$nTo = 'Huudepzai';
	$mTo = 'vulongepu@gmail.com';
	$diachi = 'vulongepu@gmail.com';
	//test gui mail
	$mail = sendMail($title, $content, $nTo, $mTo,$diachicc='');
	var_dump($mail);die;
	if($mail==1){
	echo 'mail của bạn đã được gửi đi hãy kiếm tra hộp thư đến để xem kết quả. ';
    }else{ 
    	echo 'Co loi!';
    }
?>