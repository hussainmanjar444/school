<?php
$this->title ="Admin dashboard";
?>
<div class="sms-dashboard-index"> 
     <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/admin/school-admin">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','SCHOOL ADMINS') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\SchoolAdmin::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/admin/school-teacher">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','SCHOOL TEACHERS') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\SchoolTeacher::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div> 
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/admin/school-librarian">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','SCHOOL LIBRARIANS') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\SchoolLibrarian::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div> 
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/admin/student">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','SCHOOL STUDENTS') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\Student::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>  
    </div>
      <!-- /.row --> 
     <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/admin/book-category">
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
          <a href="/admin/book-author">
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
          <a href="/admin/book-publisher">
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
          <a href="/admin/book">
            <div class="info-box bg-green">
              <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','BOOKS') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\Book::find()->all()); ?></small></span>
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
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/admin/book-vendor">
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
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/admin/library-room">
            <div class="info-box bg-red">
              <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','TOTAL LIBRARY ROOMS') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\LibraryRoom::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/admin/library-room-rack">
            <div class="info-box bg-red">
              <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','TOTAL ROOMS RACK') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\LibraryRoomRack::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="/admin/inventory">
            <div class="info-box bg-red">
              <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><?= Yii::t('app','TOTAL BOOK INVENTRY') ?></span>
                <span class="info-box-number"><small> <?= Yii::t('app','Total') ?> : <?= count(\app\models\Inventory::find()->all()); ?></small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </a>
        </div>   
    </div>
      <!-- /.row --> 
</div>      