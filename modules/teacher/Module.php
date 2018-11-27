<?php

namespace app\modules\teacher;

use Yii;
use yii\helpers\Url;
/**
 * teacher module definition class
 */
use yii\filters\AccessControl;
class Module extends \yii\base\Module
{ 
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\teacher\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if(!Yii::$app->getRequest()->getCookies()->getValue('schoolId'))
        {
            \Yii::$app->session->open();
            \Yii::$app->session->close();
            return Yii::$app->response->redirect(Url::to(['/user/login']));
        }

        // custom initialization code goes here
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['teacher'],
                    ]
                ],
            ],
        ];
    }
    
}
