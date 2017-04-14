<?php
class dashboardController {

    public $aLayout = array('index'=>'main');
    public $aLoginRequired = array('index'=> true);

    public function __construct() {
        global $sAction;
        global $oUser;
        global $oSession;

        if ($this->aLoginRequired[$sAction]) {

            if (!$oUser->isLoggedin()) {
                redirect(getConfig('siteUrl') . '/' . getConfig('loginModule') . '/' . getConfig('loginAction'));
            }
        }
    }
     public function callIndex() {
        global $oUser, $oSession;
        $nProId = $_GET['project_id'];
        $sProName = $_GET['project_name'];
        $oProjects = new projects();
        $aProjectDetails = $oProjects->getProjectDetails($nProId);
        require("index.tpl.php");
    }
}