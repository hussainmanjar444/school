<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\StudentParent;
use app\models\search\StudentParentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use dektrium\user\models\User;
use app\models\Profile;

/**
 * StudentParentController implements the CRUD actions for StudentParent model.
 */
class StudentParentController extends Controller
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
     * Lists all StudentParent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentParentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentParent model.
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
     * Creates a new StudentParent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudentParent();

        if ($model->load(Yii::$app->request->post()))  {
            if($model->email_selection == "create_random")
            {
                $model->email = strtolower($model->name).rand(0,100000).\app\helpers\Configuration::EMAIL_EXTENSION;
            } 
            if($this->checkUserEmail($model->email))
            {
                \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'This email already exist. Please try with another email....'));
            }
            else 
            { 
                $this->createUser($model);
                if($model->userId)
                {
                    $model->user_id = $model->userId;
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
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
        $password=uniqid();

        $user->setAttributes(
            [
                'email' => $email,
                'username' =>$username,
                'password' => $password,
            ]

        );

        $user->password_hash = Yii::$app->security
                    ->generatePasswordHash(
                        $password, 
                        Yii::$app->getModule('user')->cost
                    );
 
        $profile = \Yii::createObject(Profile::className());
        $profile->setAttributes([
            'name' => $model->name,
            'public_email' => $model->email, 
            'mobile' => $model->mobile, 
            'gender' => $model->gender,  
            'blood_group' => $model->blood_group,  
            'address_p' => $model->address_p,  
            'province_p' => $model->province_p,  
            'district_p' => $model->district_p,  
            'municipality_p' => $model->municipality_p,  
            'ward_p' => $model->ward_p,  
            'address_t' => $model->address_t,  
            'province_t' => $model->province_t,  
            'district_t' => $model->district_t,  
            'municipality_t' => $model->municipality_t,  
            'ward_t' => $model->ward_t
        ]);

        $user->setProfile($profile);  
         

        if ( $user->register()) {
            $userId = $user->id;
            $model->userId = $userId;
            $auth = \Yii::$app->authManager;
            $employeeRole = $auth->getRole(\app\helpers\Configuration::USER_ROLE_PARENT);
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
        var_dump($model); die();
        \Yii::$app->getSession()->setFlash('warning', yii::t('app', 'There is some error on creating user'));
        return false;          
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE;  
        $modelProfile=Profile::find(['user_id' => $model->user_id])->one();
        $model->setUserInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            $modelProfile->name = $model->name;
            $modelProfile->mobile = $model->mobile;
            $modelProfile->gender = $model->gender; 
            $modelProfile->blood_group = $model->blood_group; 
            $modelProfile->address_p = $model->address_p; 
            $modelProfile->province_p = $model->province_p; 
            $modelProfile->district_p = $model->district_p; 
            $modelProfile->municipality_p = $model->municipality_p; 
            $modelProfile->ward_p = $model->ward_p; 
            $modelProfile->address_t = $model->address_t; 
            $modelProfile->province_t = $model->province_t; 
            $modelProfile->district_t = $model->district_t; 
            $modelProfile->municipality_t = $model->municipality_t; 
            $modelProfile->ward_t = $model->ward_t;
            $modelProfile->save(); 
            return $this->redirect(['view','id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        if (($model = StudentParent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
