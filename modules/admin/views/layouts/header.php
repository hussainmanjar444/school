<?php
use yii\helpers\Html; 

/* @var $this \yii\web\View */
/* @var $content string */
$site_name = \app\helpers\Configuration::getSiteData('site_name'); 

?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">'.$site_name[0].'</span><span class="logo-lg site-name">' .$site_name . '</span>', Yii::$app->homeUrl , ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">  
                <!-- Control Sidebar Toggle Button -->
                <li>
                <?php echo Html::a('<i class="fa fa-sign-out"></i> '.Yii::t("app","Sign out"), ['/user/logout'],[
                        'title'=> Yii::t("app","Sign out"),

                        'data' => [
                                    'method' => 'post',
                                  ],
                            ]
                    );   ?>
                </li>
                <li>

                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i> <?= Yii::t("app","Site settings"); ?></a>
                </li>
            </ul>
        </div>
    </nav>

</header>
