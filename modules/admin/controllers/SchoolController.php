<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\School;
use app\models\search\SchoolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\Configuration;
use app\models\User;
use app\models\Profile;


/**
 * SchoolController implements the CRUD actions for School model.
 */
class SchoolController extends Controller
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
     * Lists all School models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SchoolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy("id DESC");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single School model.
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
     * Creates a new School model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new School();
        $model->scenario = $model::SCENARIO_CREATE; 

        if ($model->load(Yii::$app->request->post())) {

            if($this->checkUserEmail($model->email))
            {
                \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'This email already exist. Please try with another email....'));
            }
            else 
            { 
                $this->createUser($model);
                if($model->userId)
                {
                    if($model->save())
                    {
                        $modelSchoolAdmin = new \app\models\SchoolAdmin();
                        $modelSchoolAdmin->scenario = $modelSchoolAdmin::SCENARIO_CREATE_WITH_SCHOOL;
                        $modelSchoolAdmin->user_id = $model->userId;
                        $modelSchoolAdmin->school_id = $model->id;
                        $modelSchoolAdmin->status = Configuration::ACTIVE;
                        $modelSchoolAdmin->save();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function checkUserEmail($emailID)
    {
        $email = $emailID;
        $checkEmail = User::find()->where(['email' => $email])->one();
        if($checkEmail)
        {
            return true;
        }
        return false;
    }
    public function createUser(&$model)
    {
        $user = new User();
        $email  = $model->email;
        $username = $model->email; 
        $password=$model->password;
        $confirmed_at = time(); 

        $user->setAttributes(
            [
                'email' => $email,
                'username' =>$username,
                'password' => $password,
                'confirmed_at' => $confirmed_at
            ]

        );
  
 
        $profile = \Yii::createObject(Profile::className());
        $profile->setAttributes([
            'name' => $model->name,
            'public_email' => $model->email, 
            'mobile' => $model->contactno,    
            'address_p' => $model->address,  
            'province_p' => $model->province_id,  
            'district_p' => $model->district_id,  
            'municipality_p' => $model->municipality_id,  
            'ward_p' => $model->ward_no,  
            'address_t' => $model->address,  
            'province_t' => $model->province_id,  
            'district_t' => $model->district_id,  
            'municipality_t' => $model->municipality_id,  
            'ward_t' => $model->ward_no
        ]);

        $user->setProfile($profile);  
         

        if ( $user->create()) {
            $userId = $user->id;
            $model->userId = $userId;
            $auth = \Yii::$app->authManager;
            $employeeRole = $auth->getRole(\app\helpers\Configuration::USER_ROLE_SCHOOL);
            if($employeeRole){
                try
                {
                    $auth->assign($employeeRole, $userId); 
                }
                catch(\yii\db\Exception $exception){
                    \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'User role is already assigned....')); 
                } 
            }
            $email = $model->email;
           /* if(self::sendUserMail($email, $user, $password)){
                return true;
            }*/ 
            return true;
        } 
        \Yii::$app->getSession()->setFlash('warning', yii::t('app', 'There is some error on creating user'));
        return false;          
    }

    /**
     * Updates an existing School model.
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


    public function actionActivateSchool($id)
    {
        if($id)
        {
            $model = $this->findModel($id);
            $model->status = Configuration::ACTIVE;
            if($model->save(false))
            {
                \Yii::$app->getSession()->setFlash('success', yii::t('app', 'school activated successfully....'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'school not activated....'));
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionDeactivateSchool($id)
    {  
        if($id)
        {
            $model = $this->findModel($id);
            $model->status = Configuration::INACTIVE;
            if($model->save(false))
            {
                \Yii::$app->getSession()->setFlash('success', yii::t('app', 'school deactivated successfully....'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'school not deactivated....'));
        return $this->redirect(Yii::$app->request->referrer);
    }
 

    /**
     * Finds the School model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return School the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = School::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
