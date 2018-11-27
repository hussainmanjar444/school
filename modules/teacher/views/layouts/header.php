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
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="<?= Yii::$app->user->identity->profile->avatar; ?>" class="user-image" alt="<?= Yii::$app->user->identity->profile->name; ?>">
                      <span class="hidden-xs"><?= Yii::$app->user->identity->profile->name; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header">
                        <img src="<?= Yii::$app->user->identity->profile->avatar; ?>" class="img-circle" alt="<?= Yii::$app->user->identity->profile->name; ?>">

                        <p>
                          <?= Yii::$app->user->identity->profile->name; ?>
                          <small><?= Yii::$app->user->identity->profile->memeberSince; ?></small>
                        </p>
                      </li> 
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="/teacher/profile" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right"> 
                            <?php echo Html::a('<i class="fa fa-sign-out"></i> '.Yii::t("app","Sign out"), ['/user/logout'],[
                                'title'=> Yii::t("app","Sign out"),
                                'class' => 'btn btn-default btn-flat',
                                'data' => [
                                        'method' => 'post',
                                      ],
                                ]
                            );   ?>
                        </div>
                      </li>
                    </ul>
                  </li>
                  <!-- Control Sidebar Toggle Button -->
            </ul>
        </div>
    </nav>

</header>
