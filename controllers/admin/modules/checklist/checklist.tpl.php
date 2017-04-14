<div class="navbar-menu">
    <a href="<?php echo getConfig('siteUrl') . '/dashboard/index?project_id=' . $nProId . '&project_name=' . $sProName; ?>"><i class="fa fa-home"></i><?php echo __('_home')?></a>
    <a href="<?php echo getConfig('siteUrl') . '/documents/documents?project_id=' . $nProId . '&project_name=' . $sProName; ?>"><i class="fa fa-folder"></i><?php echo __('_documents')?></a>
    <a href="<?php echo getConfig('siteUrl') . '/checklist/checklist?project_id=' . $nProId . '&project_name=' . $sProName; ?>"><i class="fa fa-check"></i><?php echo __('_checklist')?></a>
    <a href="<?php echo getconfig('siteUrl') . '/floorplan/index?project_id=' . $nProId . '&project_name=' . $sProName; ?>"><i class="fa fa-copy"></i> <?php echo __('_floorplans')?></a>
</div>
<ul class="nav navbar-top-links navbar-right">
    <li>
        <span class="m-r-sm text-muted welcome-message">Welcome <?php
            if ($oSession->getSession('sDisplayUserName')) {
                echo $oSession->getSession('sDisplayUserName', false);
            }
            ?></span>
    </li>
    <li>
        <img class="img-circle " src="<?php echo getConfig('mediaUrl') . '/images/logo.png' ?>" alt="*" style="width:50px; height:50px;"/>
    </li>
    <li>
        <a href="<?php echo getconfig('siteUrl') . '/users/logout' ?>" title="<?php echo __('logout'); ?>"><i class="fa fa-sign-out"></i><?php echo __('logout') ?></a>
    </li>
</ul>
</nav>
</div>
<div style="padding: 5px">

</div>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="row">
        <div class="col-lg-offset-2 col-lg-8">
            <h2><?php echo __('checklists'); ?></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo getconfig('siteUrl') . '/home/index' ?>"><?php echo __('home'); ?></a>
                </li>
                <li class="active">
                    <strong><?php echo __('checklists'); ?></strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2 " style="padding-top:33px; padding-right: 35px;">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal4"><?php echo __('add_checklist'); ?></button>
        </div>
    </div>
</div>
<div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-clock-o modal-icon"></i>
                <h4 class="modal-title"><?php echo __('add_project_name_here'); ?></h4>
                <small><?php echo __('floor_plan_shown_here'); ?></small>
            </div>
            <div class="modal-body">
                <form name="addChecklist" method="POST" enctype="multipart/form-data" action="" role="form">
                    <div class="form-group"><label><?php echo __('checklist_id'); ?></label> <input type="text" placeholder="Id" class="form-control" name="checklist id"></div>
                    <div class="form-group"><label><?php echo __('checklist_title'); ?></label> <textarea class="form-control" placeholder="Checklist title" name="checklist_title"></textarea></div>
                    <div class="form-group"><label><?php echo __('select_project_area'); ?></label>
                        <select class="form-control m-b" name="checklist_project_area"><?php
                            foreach ($aProjecAreas['records'] as $aProjecArea) {
                                echo '<option>' . $aProjecArea['project_area_title'] . '</option>';
                            }
                            ?>    
                        </select>
                    </div>    
                    <div>
                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="add_checklist"><strong><?php echo __('add_checklist') ?></strong></button>
                    </div>
                </form>    
            </div>
        </div>
    </div>
</div>
</div>
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="row">
        <div class="col-lg-offset-1 col-lg-10">
            <div class="wrapper wrapper-content animated fadeInUp">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="project-list">
                            <table class="table table-hover">
                                <thead class="ibox-heading">
                                    <tr>
                                        <td>
                                            <?php echo __('_id') ?>
                                        </td>
                                        <td>
                                            <?php echo __('_title') ?>
                                        </td>
                                        <td>
                                            <?php echo __('_status') ?>
                                        </td>

                                        <td>
                                            <?php echo __('project_area') ?>
                                        </td>
                                        <td class="project-actions">
                                            <?php echo __('_actions') ?>
                                        </td>
                                    </tr>
                                </thead>
                                <?php if ($aChecklists['total_records'] != 0) {
                                    ?>
                                    <tbody>

                                        <?php
                                        foreach ($aChecklists['records'] as $aChecklist) {
                                            ?>
                                            <tr>
                                                <td class="project-status">
                                                    <?php echo $aChecklist['checklist_id']; ?>
                                                </td>
                                                <td class="project-title">
                                                    <a href="project_detail.html"><?php echo $aChecklist['title']; ?></a>
                                                    <br/>
                                                    <small>Created <?php echo $aChecklist['created_at']; ?></small>
                                                </td>
                                                <td class="project-completion">
                                                    <?php
                                                    if ($aChecklist['status'] == 0) {
                                                        echo '<span class = "label label-default">Done</span>';
                                                    } else {
                                                        echo '<span class="label label-primary">Pending</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $aChecklist['project_area']; ?>    
                                                </td>
                                                <td class="project-actions">
                                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
                                                    <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    <?php
                                } else {
                                    echo '<tbody><tr><td colspan = "5"><center><strong>!!! You Don\'t have any check list<strong></center></td></tr></tbody>';
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>