<div class="row wrapper border-bottom white-bg page-heading" style="padding-top:20px;" id="top-div">
    <div class="col-lg-offset-1 col-lg-10 text-center">
        <a href="<?php echo getconfig('siteUrl') . '/home/index'; ?>" class="btn btn-primary btn-admin" title="<?php echo __('home'); ?>"><?php echo __('home') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/companies/company' ?>" class="btn btn-primary btn-admin" title="<?php echo __('company'); ?>"><?php echo __('company') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/home/users' ?>" class="btn btn-primary btn-admin" title="<?php echo __('users'); ?>"><?php echo __('users') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/projects/addProject' ?>" class="btn btn-primary btn-admin" title="<?php echo __('add_project'); ?>"><?php echo __('add_project') ?></a>
    </div>
</div>
<?php
if ($aProjectLists['total_records'] != '0') {
    ?>              
    <div class="wrapper wrapper-content">
        <div class="col-lg-offset-1 col-lg-10">
        <?php foreach ($aProjectLists['records'] as $aProjectList) { ?>
            <div class="col-lg-3">
                <a href="<?php echo getConfig('siteUrl') .'/dashboard/index?project_id='.$aProjectList['project_id'].'&project_name='.$aProjectList['project_title'];?>" type="submit">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">status</span>
                            <h5><?php echo $aProjectList['project_id'].'.'. $aProjectList['project_title']; ?></h5>
                        </div>
                        <div class="ibox-content" style="height: 200px;">
                            <h1 class="no-margins"><img alt="image" class="img-responsive" src="<?php echo getConfig('mediaUrl').'/'.$aProjectList['project_image']; ?>" style="width: 100%;"></h1>
                        </div>
                        <div class="ibox-content" style="height: 150px;">
                            <h3 class="no-margins">Description</h3>
                            <small><?php echo $aProjectList['project_description']?></small>
                        </div>
                    </div>
                </a>    
            </div>
        <?php
    }
?>      </div>        
    </div>       
<?php
        } else {
    echo __('no_data_found!!!');
}
