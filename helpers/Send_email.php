<?php
namespace app\helpers;

use Yii;

CLass Send_email
{
	public static function send($setTo, $setFrom, $setFromName, $setSubject, $setHtmlBody)
	{
		Yii::$app->mailer->compose('@app/mail/mailer',['setFromName' => $setFromName, 'setHtmlBody' => $setHtmlBody])
    	->setTo($setTo)
    	->setfrom([$setFrom =>  $setFromName])
    	->setSubject($setSubject) 
    	->send(); 		
	}
}

?>