<?php

namespace app\modules\school\controllers;

use Yii;
use app\models\Inventory;
use app\models\search\InventorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Book;
use app\models\InventoryHistory;

/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])->orderBy("id DESC");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inventory model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Inventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   /* public function actionCreate()
    {
        $model = new Inventory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/

    /**
     * Updates an existing Inventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }



    public function actionSearchBook()
    {
        $msg = "";
        $model = new Book();
        if($model->load(Yii::$app->request->get()))
        {
            $searchData = Book::find()->where(['isbn' => $model->isbn])->one();
            if($searchData)
            {
                $msg = "<span style='color:green'>Book ISBN - <b>'".$searchData->isbn."'</b> you are looking for is avaliable in your libaray. <b><a href='/school/inventory/assign-existing-book?id=".$searchData->id."'> Click here</a></b> to add this book in your Inventory.</span>";
            }
            else
            {
                $msg = "<span style='color:red'>Book ISBN - <b>'".$model->isbn."'</b> you are looking for is not avaliable in your libaray. <b><a href='/school/inventory/assign-new-book?isbn=".$model->isbn."'> Click here</a></b> to add this book in your Inventory.</span>";
            }
        }
        return $this->render('_searchBook', [
            'model' => $model,
            'msg' => $msg,
        ]);
    }


    public function actionAssignExistingBook($id)
    {
        if($id)
        {
            $bookModel = Book::find()->where(['id' => $id])->one();
            if(!$bookModel)
            {
                throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
            }
            else
            { 
                $model = new Inventory();
                $model->scenario = $model::SCENARIO_EXISTING_BOOK_INVENTORY;
                $model->book_id = $id;
                $model->school_id = \Yii::$app->getRequest()->getCookies()->getValue('schoolId');
                if ($model->load(Yii::$app->request->post())) {
                    $checkInventory = Inventory::findOne(['school_id' => $model->school_id,'book_id' => $model->book_id]); 
                    if($checkInventory)
                    { 
                        $model->scenario = $model::SCENARIO_UPDATE_EXISTING;
                        $checkInventory->quantity += $model->quantity;
                        $checkInventory->avaliable_quantity += $model->quantity;
                        $checkInventory->status = $model->status;  
                        if($checkInventory->save(false))
                        {
                            $modelInventoryHistory = new InventoryHistory();
                            $modelInventoryHistory->inventory_id = $checkInventory->id;
                            $modelInventoryHistory->quantity = $model->quantity;
                            $modelInventoryHistory->vendor_id = $model->vendor_id;
                            $modelInventoryHistory->amount = $model->amount;
                            $modelInventoryHistory->comment = $model->comment; 
                            $modelInventoryHistory->save();
                            return $this->redirect(['view', 'id' => $checkInventory->id]);
                        }
                    }
                    else
                    {
                        $model->avaliable_quantity = $model->quantity;
                        if($model->save())
                        {
                            $modelInventoryHistory = new InventoryHistory();
                            $modelInventoryHistory->inventory_id = $model->id;
                            $modelInventoryHistory->quantity = $model->quantity;
                            $modelInventoryHistory->vendor_id = $model->vendor_id;
                            $modelInventoryHistory->amount = $model->amount;
                            $modelInventoryHistory->comment = $model->comment; 
                            $modelInventoryHistory->save();
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                }

                return $this->render('create', [
                    'model' => $model,
                    'bookModel' => $bookModel,
                ]);
            }
        }
    }


    public function actionAssignNewBook($isbn)
    {
        if(!empty($isbn))
        {
            $bookModel = Book::find()->where(['isbn' => $isbn])->one();
            if($bookModel)
            {
                return $this->redirect(['assign-existing-book','id' => $bookModel->id]);
            }
            $model = new Inventory(); 
            $model->scenario = $model::SCENARIO_NEW_BOOK_INVENTORY;
            $model->school_id = \Yii::$app->getRequest()->getCookies()->getValue('schoolId');
            if ($model->load(Yii::$app->request->post())) {
                if($book_id = $model->addBook($isbn))
                {
                    $model->book_id = $book_id;
                    $model->avaliable_quantity = $model->quantity;
                    if($model->save())
                    {
                        $modelInventoryHistory = new InventoryHistory();
                        $modelInventoryHistory->inventory_id = $model->id;
                        $modelInventoryHistory->quantity = $model->quantity;
                        $modelInventoryHistory->vendor_id = $model->vendor_id;
                        $modelInventoryHistory->amount = $model->amount;
                        $modelInventoryHistory->comment = $model->comment; 
                        $modelInventoryHistory->save();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
            return $this->render('_assignNewBook', [
                'model' => $model, 
                'isbn' => $isbn, 
            ]);
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Deletes an existing Inventory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Inventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inventory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
