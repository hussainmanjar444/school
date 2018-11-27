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
                        'url' => '/admin',
                        'label' => Yii::t('app','Home'),
                        'icon' => 'home'
                    ],      
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Common'),
                        'icon' => 'bars',
                        'items' => [
                            [
                                'url' => '/admin/province',
                                'label' => Yii::t('app','Province'), 
                            ],
                            [
                                'url' => '/admin/district',
                                'label' => Yii::t('app','District'), 
                            ],
                            [
                                'url' => '/admin/municipality',
                                'label' => Yii::t('app','Municipality'), 
                            ], 
                        ]
                    ],   
                    [
                        'url' => '#',
                        'label' => Yii::t('app','School'),
                        'icon' => 'graduation-cap',
                        'items' => [
                            [
                                'url' => '/admin/school',
                                'label' => Yii::t('app','All school'), 
                            ],
                            [
                                'url' => '/admin/school/create',
                                'label' => Yii::t('app','Add new'),
                                'icon' => 'plus',
                            ], 
                        ]
                    ],   
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Users'),
                        'icon' => 'users',
                        'items' => [ 
                            [
                                'url' => '/admin/school-admin',
                                'label' => Yii::t('app','School admin'),
                                'icon' => 'user',
                            ],
                            [
                                'url' => '/admin/student',
                                'label' => Yii::t('app','School student'),
                                'icon' => 'user',
                            ],
                            [
                                'url' => '/admin/school-teacher',
                                'label' => Yii::t('app','School teacher'),
                                'icon' => 'user',
                            ],
                            [
                                'url' => '/admin/school-librarian',
                                'label' => Yii::t('app','School librarian'),
                                'icon' => 'user',
                            ], 
                        ]
                    ],     
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Book information'),
                        'icon' => 'book',
                        'items' => [
                            [
                                'url' => '/admin/book-category',
                                'label' => Yii::t('app','Book category'), 
                            ],
                            [
                                'url' => '/admin/book-author',
                                'label' => Yii::t('app','Book author'),
                                'icon' => 'user',
                            ],
                            [
                                'url' => '/admin/book-publisher',
                                'label' => Yii::t('app','Book publisher'),
                                'icon' => 'pencil',
                            ],
                            [
                                'url' => '/admin/book-vendor',
                                'label' => Yii::t('app','Book vendor'),
                                'icon' => 'bank',
                            ],
                            [
                                'url' => '/admin/book',
                                'label' => Yii::t('app','Book list'),
                                'icon' => 'book',
                            ],
                        ]
                    ],     
                    [
                        'url' => '#',
                        'label' => Yii::t('app','School inventory'),
                        'icon' => 'bank',
                        'items' => [
                            [
                                'url' => '/admin/library-room',
                                'label' => Yii::t('app','Room'), 
                            ],
                            [
                                'url' => '/admin/library-room-rack',
                                'label' => Yii::t('app','Rack'), 
                            ], 
                            [
                                'url' => '/admin/inventory',
                                'label' => Yii::t('app','Inventory'), 
                            ],
                            [
                                'url' => '/admin/library-fine-rule',
                                'label' => Yii::t('app','Library fine rule'), 
                            ],
                            [
                                'url' => '/admin/library-inout',
                                'label' => Yii::t('app','Library inout'), 
                            ],
                        ]
                    ],    
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Setting'),
                        'icon' => 'gear',
                        'items' => [
                            [
                                'url' => '/admin/profile',
                                'label' => Yii::t('app', 'My Profile'),
                                'icon' => 'user'
                            ],
                            [
                                'url' => '/admin/user-settings/account',
                                'label' => Yii::t('app', 'Change Password'),
                                'icon' => 'user'
                            ],
                        ]
                    ],


                ],
            ]
        ) ?>
        <?php  if(Yii::$app->user->can("developer")) { ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [ 

                     [
                        'url' => '/developer/configuration',
                        'label' => 'Configuration',
                        'icon' => 'expeditedssl'
                    ],    
                    [
                        'url' => '/rbac',
                        'label' => 'Users Management',
                        'icon' => 'users'
                    ],   
                ],
            ]
        ) ?>
        <?php } ?>

    </section>

</aside>
