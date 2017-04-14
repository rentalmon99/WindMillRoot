<?php
class companiesController {

    public $aLayout = array('index' => 'admin', 'company' => 'admin', 'companyProfile' => 'admin', 'addCompany' => 'admin', 'users' => 'admin', 'addUser' => 'admin', 'projects' => 'admin', 'addProject' => 'admin');
    public $aLoginRequired = array('index' => true, 'company' => false, 'companyProfile' => false, 'addCompany' => false, 'users' => false, 'addUser' => false, 'projects' => false, 'addProject' => true);

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

    public function callCompany() {
        require("company.tpl.php");
    }

    public function callCompanyProfile() {
        require("companyProfile.tpl.php");
    }

    public function callAddCompany() {
        require("addCompany.tpl.php");
    }
    
}
