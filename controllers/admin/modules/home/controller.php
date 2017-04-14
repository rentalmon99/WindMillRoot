<?php

class homeController {

    public $aLayout = array('index' => 'admin','users' => 'admin', 'addUser' => 'admin');
    public $aLoginRequired = array('index' =>true, 'users' => false, 'addUser' => false);

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
        $oProjects = new projects();
        $aProjectLists = $oProjects->getProjectList();
        require("index.tpl.php");
    }
    public function callUsers() {
        
        global $oUser, $oSession;
        $oUsers = new users();
        $aUserLists = $oUsers->getUserList();
        require("users.tpl.php");
    }
    
    public function callAddUser() {

        global $oSession, $oUser;
        $oUsers = new users();
        $aUserRoles = $oUsers->getUserRole();

        $sUserName = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        $sUserEmail = isset($_POST['user_email']) ? $_POST['user_email'] : '';
        $sUserAddress = isset($_POST['user_address']) ? $_POST['user_address'] : '';
        $sUserMobile = isset($_POST['user_mobile']) ? $_POST['user_mobile'] : '';
        $sUserRole = isset($_POST['user_role']) ? $_POST['user_role'] : '';
        $sUserGender = isset($_POST['user_gender']) ? $_POST['user_gender'] : '';
        $sUserCity = isset($_POST['user_city']) ? $_POST['user_city'] : '';
        $sUserImage = isset($_POST['user_city']) ? $_POST['user_city'] : '';
        $sFile = isset($_POST['user_image']) ? $_POST['user_image'] : '';
        
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) 
        {
                $sFile = $_FILES['user_image']['name'];
                if(!empty($sFile))
                {
                    $aExtension= (explode(".",$sFile));
                    $sFile_Name = prepareUniqueName($aExtension);
                }
                else
                {
                    $sFile_Name = $sUserImage;
                }

            $aFields = array
                (
               array
                    (
                    'field' => 'user_name',
                    'value' => $sUserName,
                    'validation' => 'required',
                    'message' => __('user_name_required')
                ),
                array
                    (
                    'field' => 'user_email',
                    'value' => $sUserEmail,
                    'validation' => 'required',
                    'message' => __('user_email_required')
                ),
                array
                    (
                    'field' => 'user_address',
                    'value' => $sUserAddress,
                    'validation' => 'required',
                    'message' => __('user_address_required')
                ),
                 array
                    (
                    'field' => 'user_mobile',
                    'value' => array($sUserMobile,10),
                    'validation' => 'minimumlength',
                    'message' => __('contact_number_should_be_10_numbers')
                    ),    
                array
                    (
                    'field' => 'user_mobile',
                    'value' => $sUserMobile,
                    'validation' => 'required',
                    'message' => __('user_mobile_required')
                ),
                array
                    (
                    'field' => 'user_role',
                    'value' => $sUserRole,
                    'validation' => 'required',
                    'message' => __('select_user_role')
                ),
                array
                    (
                    'field' => 'user_gender',
                    'value' => $sUserGender,
                    'validation' => 'required',
                    'message' => __('select_gender')
                ),
                array
                    (
                    'field' => 'user_city',
                    'value' => $sUserCity,
                    'validation' => 'required',
                    'message' => __('enter_user_city')
                ), array
                    (
                    'field' => 'user_image',
                    'value' => $sFile_Name,
                    'validation' => 'required',
                    'message' => __('select_user_image')
                )

            );
            $bIsValid = $oUser->validateData($aFields);
            if (!empty($bIsValid)) {
                $aUsersRecord = array
                                        (
                                            'user_name' => $sUserName,
                                            'user_email' => $sUserEmail,
                                            'user_address' => $sUserAddress,
                                            'user_mobile' => $sUserMobile,
                                            'user_role' => $sUserRole,
                                            'user_gender' => $sUserGender,
                                            'user_city' => $sUserCity,
                                            'user_image'=> $sFile_Name    
                                        );

                $oObjectImage = new  image($_FILES);
                $oObjectImage->uploadAt(getConfig('uploadFilePath').'/'.$sFile_Name);
                $oUser->addUser($aUsersRecord, $nUserId);
//                $sMessage = !empty($nUserId) ? __('update_user_success') : __('create_user_success');
//                $oSession->setSession('sDisplayMessage', $sMessage);
                redirect(getConfig('siteUrl') . '/home/users');
            }
            
        }
       require("addUser.tpl.php");
    }
}