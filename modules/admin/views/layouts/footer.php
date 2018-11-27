<?php
?>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; <?= date('Y') ?> 
            <a href="#" class="site-name"><?= (Yii::$app->language=='np') ? \app\helpers\Configuration::getSiteData('site_name_nep') : \app\helpers\Configuration::getSiteData('site_name_eng');?></a>.</strong> All rights reserved.
        </footer>
	    <div class='control-sidebar-bg'></div>

	    
         <!-- Control Sidebar -->
	    <aside class="control-sidebar control-sidebar-dark">
	        <!-- Create the tabs -->
	        <!--  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">

	              <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
	          </ul>-->
	        <!-- Tab panes -->
	        <div class="tab-content">


	            <!-- Settings tab content -->
	           <?= $this->render('_formConfig')?>
	            <!-- /.tab-pane -->
	        </div>

	    </aside><!-- /.control-sidebar -->
	    <!-- Add the sidebar's background. This div must be placed
	         immediately after the control sidebar -->