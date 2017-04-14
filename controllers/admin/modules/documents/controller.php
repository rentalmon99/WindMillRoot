<?php
class documentsController {

    public $aLayout = array('documents' => 'main');
    public $aLoginRequired = array('documents' => true);

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
    public function callDocuments() {
        global $oUser, $oSession;
        
        $nProId = $_GET['project_id'];
        $sProName = $_GET['project_name'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createFolder'])) {
            
            $sFolderName=$_POST['name'];
            mkdir(getConfig('createFolderPath').$sProName.'/'.$sFolderName);
            
        }
        $aScannedDirectory = array (scandir(getConfig('createFolderPath').$sProName));
        $nScannedDirectorySize = sizeof($aScannedDirectory[0]);
        require("documents.tpl.php");
    }
}