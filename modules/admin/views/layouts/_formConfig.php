<?php
use kartik\select2\Select2;
use app\helpers\Configuration;
use yii\bootstrap\Html; 
?>
<div class="" id="">  
        <h3 class="control-sidebar-heading"><?= Yii::t('app','General Settings'); ?></h3> 
    <?php if(Yii::$app->user->can("developer")){ ?>
    <form method="post"> 
        <div class="form-group">
            <label class="control-sidebar-subheading">
                Theme Skins
            </label>
            <?php

            echo Select2::widget([
                'id' => 'selSkin',
                'name' => 'language',
                'value' => \app\helpers\Configuration::getDefaultSkin(),
                'data' => \app\helpers\Configuration::GET_SKINS_ARRAY,
                'options' => ['placeholder' => 'Select Skin'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents' => [
                    "change" => "function() { 
                                
                                 $.post( '/admin/settings/skin',{id:$('#selSkin').val()}, function(data) {
                                location.reload();
                                 });
                           
                                 }", 
                ]
            ]);
            ?>

        </div> 


        <!-- /.form-group -->
    </form> 
<?php } ?>  
    <?= Html::beginForm(['/admin/settings/config'], 'post', ['id' => 'general_setting', 'enctype' => 'multipart/form-data']) ?>
        <div class="form-group">
            <?= Html::label(Yii::t('app','Site name'), 'site_name', ['class' => 'control-sidebar-subheading']) ?>
            <?= Html::textInput('site_name', \app\helpers\Configuration::getSiteData('site_name'), ['class' => 'form-control', 'id' => 'site_name']) ?>
        </div> 
        <div class="form-group">
            <?= Html::label(Yii::t('app','Site email'), 'site_email', ['class' => 'control-sidebar-subheading']) ?>
            <?= Html::textInput('site_email', \app\helpers\Configuration::getSiteData('site_email'), ['class' => 'form-control', 'id' => 'site_email']) ?>
        </div>
        <div class="form-group">
            <?= Html::label(Yii::t('app','Site address'), 'site_address', ['class' => 'control-sidebar-subheading']) ?>
            <?= Html::textInput('site_address', \app\helpers\Configuration::getSiteData('site_address'), ['class' => 'form-control', 'id' => 'site_address']) ?>
        </div>
        <div class="form-group">
            <?= Html::label(Yii::t('app','Site phone number'), 'site_phone_number', ['class' => 'control-sidebar-subheading']) ?>
            <?= Html::textInput('site_phone_number', \app\helpers\Configuration::getSiteData('site_phone_number'), ['class' => 'form-control', 'id' => 'site_phone_number']) ?>
        </div>
        <div class="form-group">
            <?= Html::label(Yii::t('app','Site fax number'), 'site_fax_num', ['class' => 'control-sidebar-subheading']) ?>
            <?= Html::textInput('site_fax_num', \app\helpers\Configuration::getSiteData('site_fax_num'), ['class' => 'form-control', 'id' => 'site_fax_num']) ?>
        </div>  
        <div class="form-group">
            <?= Html::label(Yii::t('app','Site currency'), 'site_currency', ['class' => 'control-sidebar-subheading']) ?>
            <?= Html::textInput('site_currency', \app\helpers\Configuration::getSiteData('site_currency'), ['class' => 'form-control', 'id' => 'site_currency']) ?>
        </div> 
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Update'), ['class' => 'btn btn-primary']) ?>
        </div>

    <?php Html::endForm() ?> 

</div>


<?php

$this->registerJs("
$(function () {
 $('#site_name').keyup(function() {
    var value = $( this ).val();
    $('.site-name' ).text( value );
  }).keyup();
  
        $('#general_setting').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: '/admin/settings/config',
            data: $('#general_setting').serialize(),
            success: function (data) {
        
             
            }
          });

        });

      });
");

?>