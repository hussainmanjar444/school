<?php
namespace app\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\helpers\Configuration;
use yii\web\Cookie;
class LoginCheckController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

	public function actionIndex()
	{
		$authItem = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()); 
        foreach ($authItem as $key => $value) { 
            switch($value->name)
            {
                case Configuration::USER_ROLE_ADMIN : return $this->redirect(['/admin']);
                case Configuration::USER_ROLE_DEVELOPER : return $this->redirect(['/developer']);
                case Configuration::USER_ROLE_STUDENT : 
                        $modelStudent = \app\models\Student::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['status' => Configuration::ACTIVE])->one();
                        if(count($modelStudent) != 1)
                        {
                           $this->flush();  
                        } 
                        $this->setCookies('studentId',$modelStudent->id);
                        $this->setCookies('schoolId',$modelStudent->school_id);
                        return $this->redirect(['/student']);

                case Configuration::USER_ROLE_SCHOOL : 
                        $modelSchoolAdmin = \app\models\SchoolAdmin::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['status' => Configuration::ACTIVE])->one();
                        if(count($modelSchoolAdmin) != 1)
                        {
                           $this->flush();  
                        }   
                        $this->setCookies('schoolId',$modelSchoolAdmin->school_id);
                        return $this->redirect(['/school']);

                case Configuration::USER_ROLE_LIBRARIAN : 
                        $modelSchoolLibrarian = \app\models\SchoolLibrarian::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['status' => Configuration::ACTIVE])->one();
                        if(count($modelSchoolLibrarian) != 1)
                        {
                           $this->flush();  
                        }   
                        $this->setCookies('schoolId',$modelSchoolLibrarian->school_id);
                        return $this->redirect(['/librarian']);

                case Configuration::USER_ROLE_TEACHER : 

                        $modelSchoolTeacher = \app\models\SchoolTeacher::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['status' => Configuration::ACTIVE])->one();
                        if(count($modelSchoolTeacher) != 1)
                        {
                           $this->flush(); 
                           
                        }   
                        $this->setCookies('schoolId',$modelSchoolTeacher->school_id);
                        return $this->redirect(['/teacher']);
            } 
        } 
        $this->flush(); 
        return $this->redirect(['/user/login']); 
	}

    function flush()
    {
        \Yii::$app->session->open();
        \Yii::$app->session->close();
        return $this->redirect(['/user/login']); 
    }

    function setCookies($name, $value)
    {
        $cookies = Yii::$app->getResponse()->getCookies();
        $cookies->add(new \yii\web\Cookie(
            [ 
                'name' => $name,
                'value' => $value,   
            ]
        ));   
    }
}

?>