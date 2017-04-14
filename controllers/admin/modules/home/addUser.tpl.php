<div class="row wrapper border-bottom white-bg page-heading" style="padding-top:20px;">
    <div class="col-lg-offset-1 col-lg-10 text-center">
        <a href="<?php echo getconfig('siteUrl') . '/home/index' ?>" class="btn btn-primary btn-admin" title="<?php echo __('home'); ?>"><?php echo __('home') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/companies/company' ?>" class="btn btn-primary btn-admin" title="<?php echo __('company'); ?>"><?php echo __('company') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/projects/projects' ?>" class="btn btn-primary btn-admin" title="<?php echo __('projects'); ?>"><?php echo __('projects') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/home/users' ?>" class="btn btn-primary btn-admin" title="<?php echo __('users'); ?>"><?php echo __('users') ?></a>
    </div>
</div>
                
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-offset-1 col-lg-10">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo __('add_user')?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form name="addUser" method="POST" enctype="multipart/form-data" action ="" role="form" class="form-horizontal">
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('first_name')?></label>
                            <div class="col-sm-10"><input type="text" placeholder="<?php echo __('enter_first_name')?>" class="form-control" name="first_name"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('last_name')?></label>
                            <div class="col-sm-10"><input type="text" placeholder="<?php echo __('enter_last_name')?>" class="form-control" name="last_name"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('user_email')?></label>
                            <div class="col-sm-10"><input type="text" placeholder="<?php echo __('enter_mail')?>" class="form-control" name="user_email"></div>
                        </div>
                            <?php
                              if ($oSession->getSession('user_email')) {
                                echo "<div class='col-sm-offset-2 col-sm-10 validation_message'><span>" . $oSession->getSession('user_email', true) . "</span></div>";
                              }
                            ?>
<!--                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('user_name')?></label>
                            <div class="col-sm-10"><input type="text" placeholder="<?php echo __('enter_name')?>" class="form-control" name="user_name"></div>
                            <?php
                              if ($oSession->getSession('user_name')) {
                                echo "<div class='col-sm-offset-2 col-sm-10 validation_message'><span>" . $oSession->getSession('user_name', true) . "</span></div>";
                              }
                            ?>
                        </div>-->
                       <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('user_password')?></label>
                            <div class="col-sm-10"><input type="text" placeholder="<?php echo __('enter_password')?>" class="form-control" name="password"></div>
                        </div>
                            <?php
                              if ($oSession->getSession('password')) {
                                echo "<div class='col-sm-offset-2 col-sm-10 validation_message'><span>" . $oSession->getSession('password', true) . "</span></div>";
                              }
                            ?>
<!--                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('date_of_birth')?></label>
                        <div class="col-sm-2 input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                        </div>                        </div>-->
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('user_mobile')?></label>
                            <div class="col-sm-10"><input type="text" placeholder="<?php echo __('enter_mobile')?>" class="form-control" name="user_mobile"></div>
                            <?php
                              if ($oSession->getSession('user_mobile')) {
                                echo "<div class='col-sm-offset-2 col-sm-10 validation_message'><span>" . $oSession->getSession('user_mobile', true) . "</span></div>";
                              }
                            ?>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('pincode')?></label>
                            <div class="col-sm-10"><input type="text" placeholder="<?php echo __('enter_pincode')?>" class="form-control" name="pincode"></div>
                         <?php
                              if ($oSession->getSession('pincode')) {
                                echo "<div class='col-sm-offset-2 col-sm-10 validation_message'><span>" . $oSession->getSession('pincode', true) . "</span></div>";
                              }
                            ?>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __('user_city')?></label>
                            <div class="col-sm-10"><input type="text" placeholder="<?php echo __('enter_city')?>" class="form-control" name="user_city"></div>
                         <?php
                              if ($oSession->getSession('user_city')) {
                                echo "<div class='col-sm-offset-2 col-sm-10 validation_message'><span>" . $oSession->getSession('user_city', true) . "</span></div>";
                              }
                            ?>
                        </div>
                           
                        <div class="form-group"><label class="col-sm-2 control-label" >Role</label>
<!--                            <div class="col-sm-10">
                                <select class="form-control m-b" name="user_role">
                              <?php
                                    if ($aUserRoles['total_records'] != '0') {
                                        foreach ($aUserRoles['records'] as $aUserRole) {
                                    
                                ?>    
                                    <option><?php echo $aUserRole['role_title']; ?></option>
                               <?php
                                }
                                ?> 
                                    <?php
        } else {
    echo '<option>Not Available</option>';
}
?> 
                                </select>
                            </div>-->
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="file"  name="user_image" id="user_image"  value="" >
                            </div>
                            <?php
                              if ($oSession->getSession('user_image')) {
                                echo "<div class='col-sm-offset-2 col-sm-10 validation_message'><span>" . $oSession->getSession('user_image', true) . "</span></div>";
                              }
                            ?>

                            <div class="form-group">
                                <div class="col-lg-4 col-lg-offset-4 text-center">
                                    <button class="btn btn-white btn-form" type="submit">Cancel</button>
                                    <button class="btn btn-primary btn-form" type="submit" name="submit">Submit</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>