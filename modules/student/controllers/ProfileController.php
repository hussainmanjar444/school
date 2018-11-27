<?php

namespace app\modules\student\controllers;

use Yii;
use yii\web\Controller;
use dektrium\user\models\User;
use app\models\Profile; 
use app\models\Student; 
 
class ProfileController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = Profile::findOne([Yii::$app->user->identity->id]); 
         if ($model->load(Yii::$app->request->post()) && $model->save()) { 
            return $this->redirect(['index']);
        }
        return $this->render('index',[ 'model' => $model ]);
    }   

    public function actionMySchool()
    {
        $model = Student::findOne([\Yii::$app->getRequest()->getCookies()->getValue('studentId')]);  
        return $this->render('my-school',[ 'model' => $model ]);
    }
}
