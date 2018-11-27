<?php 
namespace app\helpers;
use Yii;
class Location {

	 public static function getLocation()
	 {
	 	//$ip = Yii::$app->getRequest()->getUserIP();
	 	$ip = '27.34.16.56';
		$location = file_get_contents('http://ip-api.com/json/'.$ip);
 		return json_decode($location); 
	 } 
} 
