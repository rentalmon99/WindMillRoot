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
            <h2><?php echo __('_documents')?></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo getconfig('siteUrl') . '/home/index' ?>"><?php echo __('home'); ?></a>
                </li>
                <li class="active">
                    <strong><?php echo __('_documents')?></strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2 " style="padding-top:33px; padding-right: 35px;">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal4">
                <?php echo __('create_folder')?>
            </button>
        </div>
    </div>
</div>
<div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-clock-o modal-icon"></i>
                <h4 class="modal-title"><?php echo $sProName = $_GET['project_name']; ?></h4>
                <small>
                    <?php
                    if ($oSession->getSession('sDisplayUserName')) {
                        echo $oSession->getSession('sDisplayUserName', false);
                    }
                    ?>
                </small>
            </div>
            <div class="modal-body">
                <form class="form-inline text-center" method="POST">
                    <div class="form-group">
                        <input class="form-control" type="text" name="name"/>
                        <input class="from-control btn btn-primary" type="submit" name="createFolder" value="create folder"/>
                    </div>
                </form>    
            </div>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="col-lg-offset-2 col-lg-8">
        <?php
        for ($i = 0; $i < $nScannedDirectorySize; $i++) {
            echo'<div class="col-lg-4">'
            . '<a href="#">'
            . '<div class="contact-box">'
            . $aScannedDirectory[0][$i] . ' 
                                       </div>
                                   </a>
                            </div>';
        }
        ?>
    </div>
</div>