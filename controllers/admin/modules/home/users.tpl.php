<div class="row wrapper border-bottom white-bg page-heading" style="padding-top:20px;">
    <div class="col-lg-offset-1 col-lg-10 text-center">
        <a href="<?php echo getconfig('siteUrl') . '/home/index' ?>" class="btn btn-primary btn-admin" title="<?php echo __('home'); ?>"><?php echo __('home') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/companies/company' ?>" class="btn btn-primary btn-admin" title="<?php echo __('company'); ?>"><?php echo __('company') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/projects/projects' ?>" class="btn btn-primary btn-admin" title="<?php echo __('projects'); ?>"><?php echo __('projects') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/home/addUser' ?>" class="btn btn-primary btn-admin" title="<?php echo __('add_user'); ?>"><?php echo __('add_user') ?></a>
    </div>
</div>
<?php
    if ($aUserLists['total_records'] != '0') 
    {
?>              
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
<?php   foreach ($aUserLists['records'] as $aUserList) 
            {
?>      <div class="col-lg-4">
            <div class="contact-box">
                <center><h3><?php echo $aUserList['user_role']; ?></h3></center>
                <div class="col-sm-4">
                    <div id="user-profile-image">
                        <img alt="image" class="profile-image" src="<?php echo getConfig('mediaUrl').'/'.$aUserList['user_image']; ?> "/>
                    </div>
<!--                <div class="text-center">
                    <img alt="image" class="profile-image img-circle" src="<?php echo getConfig('mediaUrl').'/'.$aUserList['user_image']; ?> "/>
                </div>-->
                </div>
                <div class="col-sm-8">
                    <h3><strong><?php echo $aUserList['user_name']; ?></strong></h3>
                    <p><i class="fa fa-envelope"></i> <?php echo $aUserList['user_email']; ?></p>
                    <address>
                        <strong>City</strong><br>
                        <?php echo $aUserList['user_city']; ?><br>
                        <strong>Mobile:</strong><?php echo $aUserList['user_mobile']; ?>
                    </address>
                </div>
                    <div class="clearfix"></div>
                </div>
        </div>
<?php
        }
    } 
    else
    {
        echo __('no_data_found!!!');
    }
?>                
    </div>
</div>
