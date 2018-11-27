<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\SchoolAdmin;
use app\models\search\SchoolAdminSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Profile;
use app\helpers\Configuration;

/**
 * SchoolAdminController implements the CRUD actions for SchoolAdmin model.
 */
class SchoolAdminController extends Controller
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
     * Lists all SchoolAdmin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SchoolAdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy("id DESC");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SchoolAdmin model.
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
     * Creates a new SchoolAdmin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SchoolAdmin();
        $model->scenario = $model::SCENARIO_CREATE; 

        if ($model->load(Yii::$app->request->post())) {
            if($model->email_selection == "create_random" || $model->email == null)
            {
                $model->email = strtolower($model->name).rand(0,1000).\app\helpers\Configuration::EMAIL_EXTENSION;
            } 
            $model->email = preg_replace('/\s+/', '', $model->email);
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
        $password=$model->password;
        $confirmed_at = time(); 

        $user->setAttributes(
            [
                'email' => $email,
                'username' =>$username, 
                'password' =>$password, 
                'confirmed_at' => $confirmed_at
            ]

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
     * Updates an existing SchoolAdmin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = $model::SCENARIO_UPDATE;  
        $modelProfile=Profile::findOne([$model->user_id]);
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
    public function actionActivateSchoolAdmin($id)
    {
        if($id)
        {
            $model = $this->findModel($id);
            $model->status = Configuration::ACTIVE;
            if($model->save(false))
            {
                \Yii::$app->getSession()->setFlash('success', yii::t('app', 'School admin activated successfully....'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'School admin not activated....'));
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionDeactivateSchoolAdmin($id)
    {  
        if($id)
        {
            $model = $this->findModel($id);
            $model->status = Configuration::INACTIVE;
            if($model->save(false))
            {
                \Yii::$app->getSession()->setFlash('success', yii::t('app', 'School admin deactivated successfully....'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        \Yii::$app->getSession()->setFlash('danger', yii::t('app', 'School admin not deactivated....'));
        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionChangePassword($id)
    {
        $modelSchoolAdmin = $this->findModel($id); 
        $model = User::findOne($modelSchoolAdmin->user_id); 
        $model->scenario = $model::UPDATE_ACCOUNT; 
        if($model->load(Yii::$app->request->post()) && $model->save())
        {  
            $model = User::findOne($modelSchoolAdmin->user_id);
            \Yii::$app->getSession()->setFlash('success', yii::t('app', 'Account updated successfully....'));
        }
        return $this->render('_changePassword', [
            'model' => $model
        ]);
    }
 

    /**
     * Finds the SchoolAdmin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SchoolAdmin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SchoolAdmin::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
