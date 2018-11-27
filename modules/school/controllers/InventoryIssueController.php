<?php

namespace app\modules\school\controllers;

use Yii;
use app\models\InventoryIssue;
use app\models\search\InventoryIssueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\helpers\Configuration;
use app\models\Inventory;

/**
 * InventoryIssueController implements the CRUD actions for InventoryIssue model.
 */
class InventoryIssueController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all InventoryIssue models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new InventoryIssueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single InventoryIssue model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "InventoryIssue #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    

    public function actionIssueRequestedBook($id)
    {
        $model = $this->findModel($id);
        $checkStudent = \app\models\Student::find()->where(['id' => $model->student])->andWhere(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])->one();
        if(!$checkStudent)
        {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('app', ' You are not authorized to access this page.'));   
                return $this->redirect(['/school/library-inout']);
        }
        elseif($checkStudent->status != Configuration::ACTIVE)
        {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('app', ' The student you are looking for is currently inactive from school. Please contact your school administrator for account activation.'));   
                return $this->redirect(['/school/library-inout']);
        }
        else
        {
            $model->scenario = $model::SCENARIO_BOOK_REQUEST_ISSUED;
            $model->issued_date = date("Y-m-d");
            /*$model->issue_tilldate = date("Y-m-d", strtotime("+".Configuration::LIBRARY_MAX_ISSUE_TILL_DAYS." days"));*/
            $model->issue_by = Yii::$app->user->identity->id;
            $model->status = Configuration::ISSUED;  
            if($model->load(Yii::$app->request->post()) && $model->save(false))
            { 
                $modelInventory = Inventory::findOne($model->inventory_id);
                $modelInventory->avaliable_quantity -= 1;
                $modelInventory->save(false);
                 \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'This book is issue to this student for '.Configuration::LIBRARY_MAX_ISSUE_TILL_DAYS.' days')); 
            } 
            return $this->render('_issue_requested_book',[ 
                    'model' => $model, 
            ]);
        } 
    }


    public function actionIssueNewBook($id)
    { 
        $checkStudent = \app\models\Student::find()->where(['id' => $id])->andWhere(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])->one();
        if(!$checkStudent)
        {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('app', ' You are not authorized to access this page.'));   
                return $this->redirect(['/school/library-inout']);
        }
        elseif($checkStudent->status != Configuration::ACTIVE)
        {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('app', ' The student you are looking for is currently inactive from school. Please contact your school administrator for account activation.'));   
                return $this->redirect(['/school/library-inout']);
        }
        else
        {
            $model = new InventoryIssue();
            $model->scenario = $model::SCENARIO_NEW_BOOK_ISSUED;
            if($model->load(Yii::$app->request->post()))
             {   
                    $model->student_id = $id;
                    $model->issued_date = date("Y-m-d");  
                    $model->issue_by = Yii::$app->user->identity->id;
                    $model->status = Configuration::ISSUED;
                    if($model->save())
                    { 
                        $modelInventory = Inventory::findOne($model->inventory_id);
                        $modelInventory->avaliable_quantity -= 1;
                        $modelInventory->save(false);  
                    } 
                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Book issued to this student for '.Configuration::LIBRARY_MAX_ISSUE_TILL_DAYS.' days'));
                return $this->redirect(Yii::$app->request->referrer);
             }
             return $this->render('_issue_new_book',[
                'student_id' => $id,
                'model' => $model, 
             ]);
        }
        
    }


    public function actionReceiveWithoutLateFee($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_BOOK_RECEIVE;
        $model->return_date = date("Y-m-d"); 
        $model->recieved_by = Yii::$app->user->identity->id;
        $model->status = Configuration::RETURNED;
        if($model->save())
        {
            $modelInventory = Inventory::findOne($model->inventory_id);
            $modelInventory->avaliable_quantity += 1;
            $modelInventory->save(false);
             \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Book received successfully')); 
        }
        return $this->redirect(Yii::$app->request->referrer);

    }

    public function actionReceiveWithLateFee($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);   
        $model->return_date = date("Y-m-d"); 
        $model->recieved_by = Yii::$app->user->identity->id;
        $model->status = Configuration::RETURNED;
        $modelInventory = Inventory::findOne($model->inventory_id); 
        $fineCalculate = \app\models\LibraryFineRule::find()->where(['school_id' => $modelInventory->school_id])->one();
        $fineDays = (((strtotime(date("Y-m-d")) - strtotime($model->issue_tilldate))/60)/60)/24;
        $actualFine=0;
        $fineCalculate=0;
        if($fineCalculate){
            $actualFine = $fineDays * $fineCalculate->amount;
        } 
        $model->actual_fine = $actualFine;

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Receive book #".$id,
                    'content'=>$this->renderAjax('_recieve_form', [
                        'model' => $model,
                        'actualFine' => $actualFine,
                        'finePerDay' => $fineCalculate
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save(false)){ 
                $modelInventory->avaliable_quantity += 1;
                $modelInventory->save(false);
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "BookAuthor #".$id,
                    'content'=> "Book receive successfully", 
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];    
            }else{
                 return [
                    'title'=> "Receive book #".$id,
                    'content'=>$this->renderAjax('_recieve_form', [
                        'model' => $model,
                        'actualFine' => $actualFine,
                        'finePerDay' => $fineCalculate->amount
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        } 

    }

    /**
     * Delete an existing InventoryIssue model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing InventoryIssue model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the InventoryIssue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InventoryIssue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryIssue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
