<?php
use yii\helpers\Html;
use kartik\grid\GridView;  
use yii\widgets\Pjax;
use app\helpers\Configuration; 
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', 'My classmate');
$this->params['breadcrumbs'][] = $this->title;
?>

 

<div class="row docs-premium-template">
    <?php if(count($classMate) == 0) { echo "<center><h1>Looks like you don’t have classmates this time. Please check back later. </h1></center>"; } else { ?>
    <?php foreach($classMate as $data): ?>
    <div class="col-sm-12 col-md-4">
        <div class="box box-solid">
            <div class="box-body">
                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
                    <?= $data->user->profile->name;?> - <?= $data->rollno;?> 
                </h4>
                <div class="media">
                    <div class="media-left"> 
                            <img src="<?= $data->user->profile->avatar;?>" alt="MaterialPro" class="media-object" style="width: 120px; height: auto;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);"> <br/> 
                            
                    </div>
                    <div class="media-body">
                        <div class="clearfix"> 
  
                            <p style="margin-top: 0"><?= $data->user->profile->blood_group  ?></p> 
 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
<?php  endforeach; ?> 
<?php } ?>    
</div>      
