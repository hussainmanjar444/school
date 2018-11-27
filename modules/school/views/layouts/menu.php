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
                        'url' => '/school',
                        'label' => Yii::t('app','Home'),
                        'icon' => 'home'
                    ],       
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Users'),
                        'icon' => 'users',
                        'items' => [ 
                            [
                                'url' => '/school/school-admin',
                                'label' => Yii::t('app','School admin'),
                                'icon' => 'user',
                            ],
                            [
                                'url' => '/school/student',
                                'label' => Yii::t('app','School student'),
                                'icon' => 'user',
                            ],
                            [
                                'url' => '/school/school-teacher',
                                'label' => Yii::t('app','School teacher'),
                                'icon' => 'user',
                            ],
                            [
                                'url' => '/school/school-librarian',
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
                                'url' => '/school/book-category',
                                'label' => Yii::t('app','Book category'), 
                            ],
                            [
                                'url' => '/school/book-author',
                                'label' => Yii::t('app','Book author'),
                                'icon' => 'user',
                            ],
                            [
                                'url' => '/school/book-publisher',
                                'label' => Yii::t('app','Book publisher'),
                                'icon' => 'pencil',
                            ],
                            [
                                'url' => '/school/book-vendor',
                                'label' => Yii::t('app','Book vendor'),
                                'icon' => 'bank',
                            ], 
                        ]
                    ],     
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Library inventory'),
                        'icon' => 'bank',
                        'items' => [
                            [
                                'url' => '/school/library-room',
                                'label' => Yii::t('app','Room'), 
                            ], 
                            [
                                'url' => '/school/inventory',
                                'label' => Yii::t('app','Inventory'), 
                            ],  
                        ]
                    ],     
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Library'),
                        'icon' => 'bank',
                        'items' => [ 
                            [
                                'url' => '/school/library-inout',
                                'label' => Yii::t('app','Manage library In/out'), 
                            ],
                        ]
                    ],     
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Setting'),
                        'icon' => 'gear',
                        'items' => [
                            [
                                'url' => '/school/profile',
                                'label' => Yii::t('app', 'My Profile'),
                                'icon' => 'user'
                            ],
                            [
                                'url' => '/school/profile/my-school',
                                'label' => Yii::t('app', 'My school'),
                                'icon' => 'bank'
                            ],
                            [
                                'url' => '/school/user-settings/account',
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
