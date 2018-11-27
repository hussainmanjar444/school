<?php
use yii\helpers\Url; 
?>
<aside class="main-sidebar">

    <section class="sidebar"> 
       
        <!-- /.search form -->
        
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Main navigation', 'options' => ['class' => 'header']],

                    [
                        'url' => '/teacher',
                        'label' => Yii::t('app','Home'),
                        'icon' => 'home'
                    ],     
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Setting'),
                        'icon' => 'gear',
                        'items' => [
                            [
                                'url' => '/teacher/profile',
                                'label' => Yii::t('app', 'My Profile'),
                                'icon' => 'user'
                            ],
                            [
                                'url' => '/teacher/user-settings/account',
                                'label' => Yii::t('app', 'Change Password'),
                                'icon' => 'user'
                            ],
                        ]
                    ],  


                ],
            ]
        ) ?> 

    </section>

</aside>
