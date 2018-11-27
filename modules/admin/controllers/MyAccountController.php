<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use dektrium\user\models\User;
use app\models\Profile; 

/**
 * Default controller for the `admin` module
 */
class MyAccountController extends Controller
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


    public function actionChangePassword()
    {
        echo Yii::$app->security->generatePasswordHash("admin123", Yii::$app->getModule('user')->cost);
        $model = User::findOne([Yii::$app->user->identity->id]); 
        return $this->render('_change-password',[ 'model' => $model ]);
    }
 
}
