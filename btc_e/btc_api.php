<?php

if($_GET['get_ticker']){
	echo file_get_contents('https://btc-e.com/api/2/'.$_GET['couple'].'/ticker');

}
