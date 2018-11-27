<?php

namespace app\modules\school\controllers;

use Yii;
use yii\web\Controller; 
use app\models\StudentLibrary;
use app\models\InventoryIssue;
use yii\web\NotFoundHttpException;
use app\helpers\Configuration;
/**
 * Library inout controller for the `school` module
 */
class LibraryInoutController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new StudentLibrary();
        return $this->render('index',[
            'model' => $model
        ]);
    }

    public function actionShowStudentLibrary()
    { 
        $msg = "";
        $model = new StudentLibrary();
        if($model->load(Yii::$app->request->get()))
        {
            $searchData = StudentLibrary::find()->where(['card_no' => $model->card_no ])->andWhere(['status' => Configuration::ACTIVE])->andWhere(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])->one(); 
            if($searchData)
            {
                $checkStudent = \app\models\Student::findOne($searchData->student_id);
                if($checkStudent->status != Configuration::ACTIVE)
                {
                    $msg = "<span style='color:red'></b><i class='fa fa-warning'></i> The student you are looking for is currently inactive from school. Please contact your school administrator for account activation.  <b></span>"; 
                    return $this->render('index', [
                        'msg' => $msg,
                        'model' => $model
                    ]); 
                }
                else
                { 
                    return $this->render('_student_library_issued_details', [ 
                        'studentDetails' => $searchData,
                    ]);
                }
            } 
            else
            {
                $msg = "<span style='color:red'></b><i class='fa fa-warning'></i> The student you are looking for is not found with this credential. <b></span>"; 
                return $this->render('index', [
                    'msg' => $msg,
                    'model' => $model
                ]); 
            }     
        }  
    }
 
}
