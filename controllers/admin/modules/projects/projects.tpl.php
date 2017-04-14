<div class="row wrapper border-bottom white-bg page-heading" style="padding-top:20px;" id="top-div">
    <div class="col-lg-offset-1 col-lg-10 text-center">
        <a href="<?php echo getconfig('siteUrl') . '/home/index'; ?>" class="btn btn-primary btn-admin" title="<?php echo __('home'); ?>"><?php echo __('home') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/companies/company' ?>" class="btn btn-primary btn-admin" title="<?php echo __('company'); ?>"><?php echo __('company') ?></a>
        <a href="<?php echo getconfig('siteUrl') . '/home/users' ?>" class="btn btn-primary btn-admin" title="<?php echo __('users'); ?>"><?php echo __('users') ?></a>
        <a class="btn btn-primary btn-admin" title="<?php echo __('add_project'); ?>" data-toggle="modal" data-target="#addProjectModal"><?php echo __('add_project') ?></a>
    </div>
</div>    
<div class="modal inmodal" id="addProjectModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?php echo __('add_project'); ?></h4>
                <small><?php echo __('new_project_will_be_added_from_here'); ?></small>
            </div>
            <div class="modal-body">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12 b-r"><h3 class="m-t-none m-b"><?php echo __('company_name'); ?></h3>
                            <form name="addProject" method="POST" enctype="multipart/form-data" action="" role="form">
                                <div class="form-group"><label>Project Title</label> <input type="text" placeholder="Title" class="form-control" name="project_title"></div>
                                <div class="form-group"><label>Project Description</label> <textarea class="form-control" placeholder="Describe project" name="project_description"></textarea></div>
                                <div class="form-group"><label>Project Owner</label> <input type="text" placeholder="Owner's name" class="form-control" name="project_owner"></div>
                                <div class="form-group"><label>Project Location</label>
                                    <select class="form-control m-b" name="project_location">
                                        <option>Ahmedabad</option>
                                        <option>Surat</option>
                                        <option>Baroda</option>
                                    </select>
                                </div>    
                                <div>
                                    <input type="file"  name="project_image" id="project_image"  value="" >
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit" name="submit_project"><strong><?php echo __('add_project') ?></strong></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($aProjectLists['total_records'] != '0') {
    ?>              
    <div class="wrapper wrapper-content">
        <div class="col-md-2">
            <h5 class="row ibox-title">Projects</h5>
            <ul class="project-side-nav ibox-content">
                <?php foreach ($aProjectLists['records'] as $aProjectList) { ?>
                    <li><a href="<?php echo '#' . $aProjectList['project_id']; ?>"><?php echo $aProjectList['project_title']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="container-fluid">
                <?php foreach ($aProjectLists['records'] as $aProjectList) { ?>
                    <div id="<?php echo $aProjectList['project_id']; ?>">
                        <h5 class="row ibox-title"><?php echo $aProjectList['project_id'] . '.' . $aProjectList['project_title']; ?></h5>
                        <div class="row ibox-content">    
                            <div class="col-md-6">    
                                <img alt="image" class="img-responsive" src="<?php echo getConfig('mediaUrl') . '/' . $aProjectList['project_image']; ?>" width="80%">
                                <h4><strong><?php echo $aProjectList['project_owner']; ?></strong></h4>
                                <p><i class="fa fa-map-marker"></i> <?php echo $aProjectList['project_location']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <h5><?php echo __('about_project'); ?></h5>
                                <p><?php echo $aProjectList['project_description']; ?></p>
                            </div>
                        </div>
                        <div class="row ibox-content">
                            <form method="POST">
                                <a href="<?php echo getConfig('siteUrl') . '/projects/editProject?project_id=' . $aProjectList['project_id'] ?>" class=" btn btn-info btn-sm" type="submit" name="addProject">Edit</a>
                                <a href="<?php echo getConfig('siteUrl') . '/projects/removeProject?project_id=' . $aProjectList['project_id'] ?>" class=" btn btn-info btn-sm" type="submit" name="deleteProject">Delete</a>
                            </form>
                        </div>
                        <?php
                    }
                    ?>              
                </div>
            </div>       
            <?php
        } else {
            echo __('no_data_found!!!');
        }
        ?> 
    </div>
</div> 
<a class="btn btn-info goto-top-button" href="#top-div">top</a>
