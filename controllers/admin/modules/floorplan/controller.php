<?php
class floorPlanController {

    public $aLayout = array('index'=>'main','floorplanDetail'=>'main');
    public $aLoginRequired = array('index'=>true,'floorplanDetail'=>true);

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
        $oProjectArea = new projectArea();
        $aProjectAreas = $oProjectArea->getProjectAreas();
        require("index.tpl.php");
    }
    public function callFloorPlandetail(){
        $oFloorPlan = new floorplan();
        $aFloorPlans = $oFloorPlan->getFloorPlans();
  
        require("floorplanDetail.tpl.php");
    }
   
}