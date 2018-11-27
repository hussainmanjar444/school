<?php

namespace app\modules\student\controllers;

use Yii;
use yii\web\Controller;
use app\models\Inventory;
use app\models\InventoryIssue;
use app\models\search\InventoryIssueSearch;
use app\models\search\InventorySearch;
use yii\web\NotFoundHttpException;
use app\helpers\Configuration;

/**
 * Default controller for the `student` module
 */
class InventoryIssueController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {   
        $getLibraryModel = \app\models\StudentLibrary::find()->where(['student_id' => \Yii::$app->getRequest()->getCookies()->getValue('studentId')])->one();
        if(count($getLibraryModel) == 0)
        {
            return $this->render('_cardNotIssueMsg');  
        }
        else
        {
        	$searchModel = new InventoryIssueSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['student_id' => \Yii::$app->getRequest()->getCookies()->getValue('studentId')])->orderBy("id DESC");
            return $this->render('index', [
            	'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = InventoryIssue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionSearchBook()
    { 
        $getLibraryModel = \app\models\StudentLibrary::find()->where(['student_id' => \Yii::$app->getRequest()->getCookies()->getValue('studentId')])->one();
        if(count($getLibraryModel) == 0)
        {
            return $this->render('_cardNotIssueMsg');  
        }
        else
        {
            $request = Yii::$app->request;
            $model = new Inventory();  
            if($model->load($request->get()))
            {     
                $model->keyword = trim($model->keyword);
                $searchModel = Inventory::find()
                ->joinWith("book")
                ->joinWith("book.author")
                ->joinWith("book.publisher")
                ->joinWith("book.category")
                ->where(['inventory.school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')]) 
                ->andWhere(['like', 'book.isbn', $model->keyword])
                ->orWhere(['like', 'book.name', $model->keyword])
                ->orWhere(['like', 'book_author.name', $model->keyword])
                ->orWhere(['like', 'book_publisher.name', $model->keyword])
                ->orWhere(['like', 'book_category.name', $model->keyword])
                ->orderBy("inventory.id DESC")
                ->groupBy("book.id")
                ->all(); 
                if($searchModel)
                {
                    return $this->render('_searchBook', [ 
                        'searchModel' => $searchModel,  
                        'keyword' => $model->keyword, 
                        'model' => $model, 
                    ]); 
                } 
                else
                {
                     return $this->render('_searchBook', [
                        'searchModel' => $searchModel,  
                        'keyword' => $model->keyword, 
                        'model' => $model, 
                    ]); 
                }
            }
            else
            {
                return $this->render('_searchBook', [
                    'model' => $model, 
                ]);  
            }
        } 
    }

    public function actionIssueRequest($id)
    {
         $getLibraryModel = \app\models\StudentLibrary::find()->where(['student_id' => \Yii::$app->getRequest()->getCookies()->getValue('studentId')])->one();
        if(count($getLibraryModel) == 0)
        {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('app', 'Looks like you don’t have library card issued. Please contact your school librarian or Admin Department.')); 
                return $this->redirect(Yii::$app->request->referrer);  
        }
        else
        {
            if($id)
            {
                $model = new InventoryIssue();
                $model->scenario = $model::SCENARIO_BOOK_REQUEST;
                $model->inventory_id = $id;
                $model->student_id = \Yii::$app->getRequest()->getCookies()->getValue('studentId'); 
                $model->save();
                \Yii::$app->getSession()->setFlash('success', \Yii::t('app', 'Your request have been sent for this book')); 
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }
}
