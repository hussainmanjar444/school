<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use dektrium\user\filters\AccessRule;

use dektrium\user\controllers\AdminController as BaseAdminController;

class UserActionController extends BaseAdminController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete'          => ['post'],
                    'confirm'         => ['post'],
                    'resend-password' => ['post'],
                    'block'           => ['post'],
                    'switch'          => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(), 
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['delete','block','confirm','resend-password'],
                        'roles' => ['admin','developer'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin','developer'],
                    ],
                ],
            ],
        ];
    }
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $event = $this->getUserEvent($model);

        $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);
        $model->confirm();
        $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

        \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been confirmed'));

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionBlock($id)
    {
        if ($id == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'You can not block your own account'));
        } else {
            $user  = $this->findModel($id);
            $event = $this->getUserEvent($user);
            if ($user->getIsBlocked()) {
                $this->trigger(self::EVENT_BEFORE_UNBLOCK, $event);
                $user->unblock();
                $this->trigger(self::EVENT_AFTER_UNBLOCK, $event);
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been unblocked'));
            } else {
                $this->trigger(self::EVENT_BEFORE_BLOCK, $event);
                $user->block();
                $this->trigger(self::EVENT_AFTER_BLOCK, $event);
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been blocked'));
            }
        }

       return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * Generates a new password and sends it to the user.
     *
     * @return Response
     */
    public function actionResendPassword($id)
    {
        $user = $this->findModel($id);
        if ($user->isAdmin) {
            throw new ForbiddenHttpException(Yii::t('user', 'Password generation is not possible for admin users'));
        }

        if ($user->resendPassword()) {
            Yii::$app->session->setFlash('success', \Yii::t('user', 'New Password has been generated and sent to user'));
        } else {
            Yii::$app->session->setFlash('danger', \Yii::t('user', 'Error while trying to generate new password'));
        }

       return $this->redirect(Yii::$app->request->referrer);
    }
}