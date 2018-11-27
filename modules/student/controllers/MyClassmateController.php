<?php

namespace app\modules\student\controllers;

use Yii;
use yii\web\Controller;
use app\models\Student;  
 
class MyClassmateController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $me = Student::findOne(\Yii::$app->getRequest()->getCookies()->getValue('studentId'));
        $classMate = Student::find()->where(['school_id' => $me->school_id])->andWhere(['class_id' => $me->class_id ])->andWhere(['section' => $me->section])->andWhere(['status' => \app\helpers\Configuration::ACTIVE ])->andWhere(['!=', 'id', $me->id])->all();
        return $this->render('index', ['classMate' => $classMate]);
        
    }    
}
