<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller; 
use app\models\StudentLibrary;
use app\models\InventoryIssue;
use yii\web\NotFoundHttpException;
/**
 * Library inout controller for the `admin` module
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
            $searchData = StudentLibrary::find()->where(['card_no' => $model->card_no ])->andWhere(['status' => \app\helpers\Configuration::ACTIVE])->one(); 
            if($searchData)
            {
                $listInventory = InventoryIssue::find()->where(['student_id' => $searchData->id])->orderBy(' issue_tilldate DESC')->all();
                return $this->render('_student_library_issued_details', [
                    'listInventory' => $listInventory,
                    'studentDetails' => $searchData,
                ]);
            } 
            else
            {
                $msg = "<span style='color:red'></b> The student you are looking for is not found with this credential. <b></span>"; 
                return $this->render('index', [
                    'msg' => $msg,
                    'model' => $model
                ]); 
            }     
        }  
    }
 
}
