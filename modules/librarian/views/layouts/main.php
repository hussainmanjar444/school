<?php
use yii\helpers\Html; 
use app\helpers\Configuration;
use yii\helpers\Url;
use app\assets\AppAdminAsset;
AppAdminAsset::register($this);

/* @var $this \yii\web\View */
/* @var $content string */  

if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        '../../../../views/layouts/main',
        ['content' => $content]
    );
} elseif(Yii::$app->controller->action->id === 'register' || Yii::$app->controller->action->id === 'resend'){
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        '../../../../views/layouts/main',
        ['content' => $content]
    );
    
}  elseif(Yii::$app->controller->action->id === 'profile' || Yii::$app->controller->action->id === 'account'){
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        '../../../../views/layouts/main',
        ['content' => $content]
    );
    
}else {

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist'); 
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['/uploads/favicon.jpg'])]); ?>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition <?= (Configuration::getSiteData(Configuration::DEFAULT_SKIN)) ? Configuration::getSiteData(Configuration::DEFAULT_SKIN) : ''?> sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">  
        <?= $this->render('header',['directoryAsset' => $directoryAsset]);?>
        <?= $this->render('menu',['directoryAsset' => $directoryAsset]);?>
        <?= $this->render('content',['directoryAsset' => $directoryAsset, 'content' =>$content]);?>
        <?= $this->render('footer',['directoryAsset' => $directoryAsset]);?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?> 
<?php } ?>    
