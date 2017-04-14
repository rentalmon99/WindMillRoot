<div class="navbar-menu">
    <a href="<?php echo getConfig('siteUrl') . '/dashboard/index?project_id=' . $nProId . '&project_name=' . $sProName; ?>"><i class="fa fa-home"></i><?php echo __('_home')?></a>
    <a href="<?php echo getConfig('siteUrl') . '/documents/documents?project_id=' . $nProId . '&project_name=' . $sProName; ?>"><i class="fa fa-folder"></i><?php echo __('_documents')?></a>
    <a href="<?php echo getConfig('siteUrl') . '/checklist/checklist?project_id=' . $nProId . '&project_name=' . $sProName; ?>"><i class="fa fa-check"></i><?php echo __('_checklist')?></a>
    <a href="<?php echo getconfig('siteUrl') . '/floorplan/index?project_id=' . $nProId . '&project_name=' . $sProName; ?>"><i class="fa fa-copy"></i> <?php echo __('_floorplans')?></a>
</div>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="row">
        <div class="col-lg-offset-2 col-lg-8">
            <h2><?php echo __('floor_plans') ?></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo getconfig('siteUrl') . '/home/index' ?>"><?php echo __('_home')?></a>
                </li>
                <li>
                    <?php echo __('floor_plans') ?>
                </li>
                <li class="active">
                    <strong><?php echo __('floor_plan_name') ?></strong>
                </li>
            </ol>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="col-lg-offset-1 col-lg-10">
        <?php foreach($aFloorPlans['records'] as $aFloorPlan){?>
        <div class="col-lg-4">
            <a href="#">
                <div class="contact-box" style="font-size:20px;"><?php echo 'Building '.$aFloorPlan['building_number']?></div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>    