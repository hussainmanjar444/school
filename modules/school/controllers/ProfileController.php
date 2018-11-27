<?php

namespace app\modules\school\controllers;

use Yii;
use yii\web\Controller;
use dektrium\user\models\User;
use app\models\Profile; 
 
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
        $model = \app\models\School::findOne(\Yii::$app->getRequest()->getCookies()->getValue('schoolId'));
        $model->scenario = $model::SCENARIO_UPDATE; 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['my-school']);
        }

        return $this->render('_school_profile', [
            'model' => $model,
        ]);
    }
}
