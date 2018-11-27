<?php

namespace app\modules\librarian\controllers;

use Yii;
use app\models\Student;
use app\models\search\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use dektrium\user\models\User;
use app\models\Profile;
use app\helpers\Configuration;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])->orderBy("id DESC");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelStudentLibrary = new \app\models\StudentLibrary();
        if ($modelStudentLibrary->load(Yii::$app->request->post())) {
            $modelStudentLibrary->student_id = $id;  
            $modelStudentLibrary->card_no = $model->user_id.$model->school_id.$id;  
            $modelStudentLibrary->school_id = $model->school_id;  
            $modelStudentLibrary->status = \app\helpers\Configuration::ACTIVE;   
            $modelStudentLibrary->save();  
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('view', [
            'model' => $model,
            'modelStudentLibrary' => $modelStudentLibrary,
        ]);
    }

 

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::find()->where(['id' => $id])->andWhere(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
