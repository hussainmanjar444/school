<?php

use yii\helpers\Html; 
use kartik\grid\GridView; 
use yii\widgets\Pjax; 
use yii\helpers\Url;
use app\models\InventoryIssue;
use app\helpers\Configuration;
use yii\widgets\ActiveForm;
 
$this->title = Yii::t('app','Search library'); 
$this->params['breadcrumbs'][] = $this->title;                                    
?> 
<section class="content">
        <div class="row">
            <div class="login-box" style="margin: 0% auto;">
                <div class="login-box-body"> 
                     <span><b><?= @$msg; ?></b></span>  
                        <?php $form = ActiveForm::begin([
                            'action' => ['search-book'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                        ]); ?>  

                                <?= $form->field($model, 'keyword')->textInput(['placeholder' => "Search By Book Name, ISBN, Author & Publisher"])->label(false); ?>
                                
                                <div class="form-group"> 
                                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-search"></i> Search Books'), ['class' => 'btn btn-success btn-flat','options'=> ['height' => '34px']]) ?> 
                                    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?> 
                                </div> 
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>


<?php if($model->load(Yii::$app->request->get())){ ?><hr/>
    <p><b style="font-size: 18px"><?= Yii::t('app',count($searchModel).' results found for'). ' : "'.$keyword.'"';  ?> </b></p>
<div class="row docs-premium-template">
    <?php foreach($searchModel as $data): ?>
    <div class="col-sm-12 col-md-4">
        <div class="box box-solid">
            <div class="box-body">
                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                    <?= $data->book->name;?>  - <?= $data->book->isbn;?>
                </h4>
                <div class="media">
                    <div class="media-left"> 
                            <img src="<?= $data->book->avatar;?>" alt="MaterialPro" class="media-object" style="width: 120px; height: auto;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);"> <br/>
                             <p">
                               <?php
                               $checkIssuedBook = InventoryIssue::find()->select(['id'])->where(['student_id' =>  \Yii::$app->getRequest()->getCookies()->getValue('studentId')])->andWhere(['!=','status',Configuration::RETURNED])
                                ->andWhere(['inventory_id' => $data->id])->one(); 
                                if($data->avaliable_quantity < 1){
                                    echo "<button class='btn btn-danger btn-sm ad-click-event'>OUT OF STOKE</button>";
                                } 
                                elseif($data->status != Configuration::ACTIVE){
                                    echo "<button class='btn btn-danger btn-sm ad-click-event'>INACTIVE BOOK</button>";
                                } 
                                elseif($checkIssuedBook){
                                    echo "<button class='btn btn-danger btn-sm ad-click-event'>PENDING APPROVAL</button>";
                                } 
                                else {
                                    echo '<a data-method="POST" class="btn btn-success btn-sm ad-click-event" data-confirm="' . Yii::t('user', 'Are you sure?') . '" href="' . Url::to(['/student/inventory-issue/issue-request', 'id' => $data->id]) . '"> <i class="fa fa-check">REQUEST NOW</i> </a>';
                                }  
                               ?>
                                
                            </p>
                            
                    </div>
                    <div class="media-body">
                        <div class="clearfix"> 
 
                            <p style="margin-top: 0"><b> </b><?= $data->book->author->name ?></p>
                            <p style="margin-top: 0"><b> </b><?= $data->book->publisher->name ?> </p>
                            <p style="margin-top: 0">Edition: <?= $data->book->edition ?></p>
                            <p style="margin-top: 0"><b></b><?= $data->book->category->name ?></p>
                              
                            <p style="margin-bottom: 0">
                                <i class="fa fa-shopping-cart margin-r5"></i> <?= $data->avaliable_quantity  ?> <b>Books Avaliable.</b>
                            </p>   
 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
<?php  endforeach; ?>    
</div>        
<?php } else{ ?>
    <p><b style="font-size: 18px"><?= Yii::t('app',' Recent added book');  ?> </b></p>
    <div class="row docs-premium-template">
    <?php foreach(\app\models\Inventory::find() 
            ->where(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])   
            ->orderBy("updated_on DESC")
            ->limit(6)
            ->all() as $data): ?>
    <div class="col-sm-12 col-md-4">
        <div class="box box-solid">
            <div class="box-body">
                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                    <?= $data->book->name;?>  - <?= $data->book->isbn;?>
                </h4>
                <div class="media">
                    <div class="media-left"> 
                            <img src="<?= $data->book->avatar;?>" alt="MaterialPro" class="media-object" style="width: 120px; height: auto;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);"> <br/>
                             <p">
                               <?php
                               $checkIssuedBook = InventoryIssue::find()->select(['id'])->where(['student_id' =>  \Yii::$app->getRequest()->getCookies()->getValue('studentId')])->andWhere(['!=','status',Configuration::RETURNED])
                                ->andWhere(['inventory_id' => $data->id])->one(); 
                                if($data->avaliable_quantity < 1){
                                    echo "<button class='btn btn-danger btn-sm ad-click-event'>OUT OF STOCK</button>";
                                } 
                                elseif($data->status != Configuration::ACTIVE){
                                    echo "<button class='btn btn-danger btn-sm ad-click-event'>INACTIVE BOOK</button>";
                                } 
                                elseif($checkIssuedBook){
                                    echo "<button class='btn btn-danger btn-sm ad-click-event'>PENDING APPROVAL</button>";
                                } 
                                else {
                                    echo '<a data-method="POST" class="btn btn-success btn-sm ad-click-event" data-confirm="' . Yii::t('user', 'Are you sure?') . '" href="' . Url::to(['/student/inventory-issue/issue-request', 'id' => $data->id]) . '"> <i class="fa fa-check">REQUEST NOW</i> </a>';
                                }  
                               ?>
                                
                            </p>
                            
                    </div>
                    <div class="media-body">
                        <div class="clearfix"> 
 
                            <p style="margin-top: 0"><b> </b><?= $data->book->author->name ?></p>
                            <p style="margin-top: 0"><b> </b><?= $data->book->publisher->name ?> </p>
                            <p style="margin-top: 0">Edition: <?= $data->book->edition ?></p>
                            <p style="margin-top: 0"><b></b><?= $data->book->category->name ?></p>
                              
                            <p style="margin-bottom: 0">
                                <i class="fa fa-shopping-cart margin-r5"></i> <?= $data->avaliable_quantity  ?> <b>Books Avaliable.</b>
                            </p>   
 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
<?php  endforeach; ?>    
</div>   
<?php } ?>    
    </section> 
 
