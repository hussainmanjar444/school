<?php 
$this->title = Yii::t("app","Dashboard");
?>

<div class="sms-dashboard-index">  
      <!-- /.row --> 
     <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/librarian/book-category">
            <div class="info-box bg-green">
              <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','BOOK CATEGORIES') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\BookCategory::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>  
        <!-- /.col --> 
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/librarian/book-author">
            <div class="info-box bg-green">
              <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','BOOK AUTHORS') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\BookAuthor::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>  
        <!-- /.col --> 

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div> 
        <!-- /.col --> 
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/librarian/book-publisher">
            <div class="info-box bg-green">
              <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','BOOK PUBLISHER') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\BookPublisher::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>  
        <!-- /.col -->  
        <!-- /.col --> 
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/librarian/inventory">
            <div class="info-box bg-green">
              <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','BOOKS') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\Inventory::find()->where(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>  
        <!-- /.col -->  
    </div>
      <!-- /.row --> 
      <!-- /.row --> 
     <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="/librarian/book-vendor">
            <div class="info-box bg-red">
              <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','TOTAL BOOK VENDOR') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\BookVendor::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="/librarian/library-room">
            <div class="info-box bg-red">
              <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','TOTAL LIBRARY ROOMS') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\LibraryRoom::find()->where(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div> 
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="/librarian/inventory">
            <div class="info-box bg-red">
              <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','TOTAL BOOK INVENTORY') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\Inventory::find()->where(['school_id' => \Yii::$app->getRequest()->getCookies()->getValue('schoolId')])->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>   
    </div>
      <!-- /.row --> 
</div>      
