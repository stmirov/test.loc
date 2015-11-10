<?php

class LinguaLeoCheat
{

	private function getCurl($url, $data){
		if( $curl = curl_init() ) {
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_POST, true);
			if(file_get_contents('cookie.txt') !== ''){
				curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__.'/cookie.txt');
			}
			curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__.'/cookie.txt');
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$out = curl_exec($curl);
			curl_close($curl);
			sleep(10);
			return $out;
		}
		else{
			echo 'Error curl init';
			exit;
		}
	}

	private function genStr($length){
		$chars = 'abcdefghijklmnopqrstuvwxyz123456789';
		$numChars = strlen($chars);
		$string = '';
		for ($i = 0; $i < $length; $i++) {
			$string .= substr($chars, mt_rand(1, $numChars) - 1, 1);
		}
		return $string;
	}

	private function regNewUser(){
		file_put_contents(__DIR__.'/cookie.txt', '');
		$refer_url = 'http://lingualeo.com/ru/r/9c1d4p';
		//TODO::make refer register
		$mail_domeins = array('mail.ru', 'list.ru', 'bk.ru', 'yandex.ru', 'gmail.com', 'rambler.ru', 'ukr.net');
		//step 1 Reg user
		$url = 'http://lingualeo.com/ru/register';
		echo $r_email = $this->genStr(mt_rand(8, 12)).'@'.$mail_domeins[mt_rand(0, 6)];
		echo '<br>';
		echo $r_password = $this->genStr(mt_rand(6, 10));
		$data = "r_email=$r_email&r_password=$r_password";
		$this->getCurl($url, $data);
		//step 2 ansver on questions
		$url = 'http://lingualeo.com/survey/save';
		//Age
		$data = 'refererstep=registration&type=personInfo&answers[age]='.mt_rand(17, 45);
		$this->getCurl($url, $data);
		//Activity
		$data = 'refererstep=registration&type=activity&answers[activity]=1';
		$this->getCurl($url, $data);
		//Skill
		$data = 'refererstep=registration&type=skill
			&answers[speaking]='.mt_rand(1, 5).'
			&answers[writing]='.mt_rand(1, 5).'
			&answers[listening]='.mt_rand(1, 5).'
			&answers[reading]='.mt_rand(1, 5).'
		';
		$this->getCurl($url, $data);

		$this->increaseUsersLevel();
	}

	private function increaseUsersLevel(){
		$url = 'http://lingualeo.com/content/setpagelearned';
		$max_pages = mt_rand(20, 30);
		for($i = 0; $i < $max_pages; $i++){
			$data = 'page=1&content_id='.mt_rand(304780, 414788);
			$this->getCurl($url, $data);
		}
	}


	public function init(){
		$this->regNewUser();
	}
}

$leo = new LinguaLeoCheat();
$leo->init();
