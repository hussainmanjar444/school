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
                        'url' => '/student',
                        'label' => Yii::t('app','Home'),
                        'icon' => 'home'
                    ],    
                    [
                        'url' => '/student/my-classmate',
                        'label' => Yii::t('app','My classmates'),
                        'icon' => 'users'
                    ],   
                    [
                        'url' => '#',
                        'label' => Yii::t('app','My library'),
                        'icon' => 'database',
                        'items' => [
                            [
                                'url' => '/student/inventory-issue',
                                'label' => Yii::t('app', 'Library histroy'),
                                'icon' => 'history'
                            ],
                            [
                                'url' => '/student/inventory-issue/search-book',
                                'label' => Yii::t('app', 'Request New Book'),
                                'icon' => 'search'
                            ],
                        ]
                    ],    
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Setting'),
                        'icon' => 'gear',
                        'items' => [
                            [
                                'url' => '/student/profile',
                                'label' => Yii::t('app', 'My Profile'),
                                'icon' => 'user'
                            ],
                            [
                                'url' => '/student/profile/my-school',
                                'label' => Yii::t('app', 'My school'),
                                'icon' => 'bank'
                            ],
                            [
                                'url' => '/student/user-settings/account',
                                'label' => Yii::t('app', 'Change Password'),
                                'icon' => 'key'
                            ],
                        ]
                    ],  


                ],
            ]
        ) ?> 

    </section>

</aside>
