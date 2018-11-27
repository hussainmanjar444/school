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
                        'url' => '/librarian',
                        'label' => Yii::t('app','Home'),
                        'icon' => 'home'
                    ], 
                    [
                        'url' => '/librarian/student',
                        'label' => Yii::t('app','Student'),
                        'icon' => 'users'
                    ],     
                    [
                        'url' => '#',
                        'label' => Yii::t('app','Book information'),
                        'icon' => 'book',
                        'items' => [
                            [
                                'url' => '/librarian/book-category',
                                'label' => Yii::t('app','Book category'), 
                            ],
                            [
                                'url' => '/librarian/book-author',
                                'label' => Yii::t('app','Book author'),
                                'icon' => 'user',
                            ],
                            [
                                'url' => '/librarian/book-publisher',
                                'label' => Yii::t('app','Book publisher'),
                                'icon' => 'pencil',
                            ],
                            [
                                'url' => '/librarian/book-vendor',
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
                                'url' => '/librarian/library-room',
                                'label' => Yii::t('app','Room'), 
                            ], 
                            [
                                'url' => '/librarian/inventory',
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
                                'url' => '/librarian/library-inout',
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
                                'url' => '/librarian/profile',
                                'label' => Yii::t('app', 'My Profile'),
                                'icon' => 'user'
                            ],
                            [
                                'url' => '/librarian/user-settings/account',
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
