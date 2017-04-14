<?php

class usersController {

    public $aLayout = array('login' => 'login','register'=>'login');
    public $aLoginRequired = array('login' =>false,'register' =>false);

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
    public function callRegister() {
 
        require("register.tpl.php");
    }
    public function callLogin() {
        
        global $oSession;
        global $oUser;
        $sDbHost = getconfig('dbHost');
        $sDbUser = getconfig('dbUser');
        $sDbPassword = getconfig('dbPassword');
        $sDbName = getconfig('dbName');
        $sMessage =__('admin_logged_in_successfully');
        $sUserName =  isset($_POST['user_email']) ? $_POST['user_email'] : '';
        $sPassword =  isset($_POST['password']) ? $_POST['password'] : '';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sTableName = 'admin';
            $aFields = array(
                               array (
                                    'field'=>'wrong_credentials',
                                    'aCredentials'=>array('login_name','password'),
                                    'aDataForSession'=>  array('login_name'),
                                    'tableName'=>$sTableName,
                                    'value'=>array($sUserName,$sPassword),
                                    'validation'=>'isLoggedin',
                                    'message'=>__('username_or_password_is_not_valid')
                                )
                             );
            $oSiCommon = new siCommon($sDbHost,$sDbUser,$sDbPassword,$sDbName);
            $bIsValid= $oSiCommon->validateData($aFields);

            if($bIsValid)
                {
                    $oUser->doLogin($bIsValid);
                    $oUser->isLoggedin();

                    $oSession->setSession('sDisplayMessage',$sMessage);
                    $oSession->setSession('sDisplayName', $bIsValid[0]['email']);
                    $oSession->setSession('sDisplayUserName', $aFields[0]['value'][0]);
                    redirect(getConfig('siteUrl').'/'.getConfig('homeModule').'/'.getConfig('homeAction'));
                }
        }
        if($oUser->isLoggedin()) {
            redirect(getConfig('siteUrl').'/'.getConfig('homeModule').'/'.getConfig('homeAction'));
        }
        else {
            require 'login.tpl.php';
        }
    }
    public function callLogOut()
    {
        global $oUser;
        $oUser->doLogOut();
        unset($oUser);
        redirect(getConfig('siteUrl').'/users/login');
    }
 }