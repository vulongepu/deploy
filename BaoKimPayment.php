﻿<?php

/**
 *	
 *		Phiên bản: 0.1   
 *		Tên lớp: BaoKimPayment
 *		Chức năng: Tích hợp thanh toán qua baokim.vn cho các merchant site có đăng ký API
 *						- Xây dựng URL chuyển thông tin tới baokim.vn để xử lý việc thanh toán cho merchant site.
 *						- Xác thực tính chính xác của thông tin đơn hàng được gửi về từ baokim.vn.
 *		
 */
class BaoKimPayment 
{
	// URL checkout của baokim.vn
	private $baokim_url = 'https://www.baokim.vn/payment/order/version11';

	// Mã merchante site 
	private $merchant_id = '31909';	// Biến này được baokim.vn cung cấp khi bạn đăng ký merchant site

	// Mật khẩu bảo mật
	private $secure_pass = '787f0e308d1d6b04'; // Biến này được baokim.vn cung cấp khi bạn đăng ký merchant site

	/**
	 * Hàm xây dựng url chuyển đến BaoKim.vn thực hiện thanh toán, trong đó có tham số mã hóa (còn gọi là public key)
	 * @param $order_id				Mã đơn hàng
	 * @param $business 			Email tài khoản người bán
	 * @param $total_amount			Giá trị đơn hàng
	 * @param $shipping_fee			Phí vận chuyển
	 * @param $tax_fee				Thuế
	 * @param $order_description	Mô tả đơn hàng
	 * @param $url_success			Url trả về khi thanh toán thành công
	 * @param $url_cancel			Url trả về khi hủy thanh toán
	 * @param $url_detail			Url chi tiết đơn hàng
	 * @return url cần tạo
	 */
	public function createRequestUrl($data)
	{
		// Mảng các tham số chuyển tới baokim.vn
		$currency = 'VND'; // USD
        $secure_pass = '787f0e308d1d6b04';
		$params = array(
			'merchant_id'		=>	strval('31909'),
			'order_id'			=>	strval('1512382296-100'),
			'business'			=>	strval('20131004@student.hust.edu.vn'),
			'total_amount'		=>	strval('10000'),
			'shipping_fee'		=>  strval('0'),
			'tax_fee'			=>  strval('0'),
			'order_description'	=>	strval('aaaaaaaaa'),
			'url_success'		=>	("http://sanbox.web9c.com/index.php"),
			'url_cancel'		=>	("http://sanbox.web9c.com/index.php"),
			'url_detail'		=>	(""),
			'payer_name'		=>  strval("vu nhu long"),
			'payer_email'		=> 	strval("admin@gmail.com"),
			'payer_phone_no'	=> 	strval("0988404580"),
			'shipping_address'  =>  strval($data['address']),
			'currency' => strval($currency),
		);
		ksort($params);
		
		// update 18/11
		
		$secure_pass1 = '787f0e308d1d6b04';
		// $str_combined = $this->secure_pass.implode('', $params);
		// $params['checksum'] = strtoupper(md5($str_combined));

		$params['checksum']=hash_hmac('SHA1',implode('',$params),$secure_pass1);
		
		// var_dump($params['checksum']);die;
		
		//Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào
		$redirect_url = $this->baokim_url;
		if (strpos($redirect_url, '?') === false)
		{
			$redirect_url .= '?';
		}
		else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false)
		{
			// Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
			$redirect_url .= '&';
		}

		// Tạo đoạn url chứa tham số
		$url_params = '';
		foreach ($params as $key=>$value)
		{
			if ($url_params == '')
				$url_params .= $key . '=' . urlencode($value);
			else
				$url_params .= '&' . $key . '=' . urlencode($value);
		}
		return $redirect_url.$url_params;
	}
	
	/**
	 * Hàm thực hiện xác minh tính chính xác thông tin trả về từ BaoKim.vn
	 * @param $_GET chứa tham số trả về trên url
	 * @return true nếu thông tin là chính xác, false nếu thông tin không chính xác
	 */
	public function verifyResponseUrl()
	{
		$checksum = $_GET['checksum'];
		unset($_GET['checksum']);
		
		ksort($_GET);
		$str_combined = $this->secure_pass.implode('', $_GET);

        // Mã hóa các tham số
		$verify_checksum = strtoupper(md5($str_combined));
		
		// Xác thực mã của chủ web với mã trả về từ baokim.vn
		if ($verify_checksum === $checksum) 
			return true;
		
		return false;
	}
}


$BK = new BaoKimPayment;
$url = $BK->createRequestUrl($data);

echo "<pre>";
echo $url;
echo "</pre><br>";
echo '<a href="'.$url.'">Click Here</a>';
?>