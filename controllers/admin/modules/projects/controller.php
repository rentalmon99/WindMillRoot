<?php
class projectsController {

    public $aLayout = array('projects' => 'admin', 'addProject' => 'admin', 'removeProject' => '');
    public $aLoginRequired = array('projects' => false, 'addProject' => true, 'removeProject' => false);

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

    public function callProjects() {
        global $oUser, $oSession;
        
        $oProjects = new projects();
        $aProjectLists = $oProjects->getProjectList();
        
        $sProjectTitle = isset($_POST['project_title']) ? $_POST['project_title'] : '';
        $sProjectDescription = isset($_POST['project_description']) ? $_POST['project_description'] : '';
        $sProjectOwner = isset($_POST['project_owner']) ? $_POST['project_owner'] : '';
        $sProjectLocation = isset($_POST['project_location']) ? $_POST['project_location'] : '';
        $sFile = isset($_POST['project_image']) ? $_POST['project_image'] : '';
        $sProjectFolder = 'c:/wamp/www/ctrl/web/media/docs/';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_project'])){
                $sFile = $_FILES['project_image']['name'];
                if(!empty($sFile))
                {
                    $aExtension= (explode(".",$sFile));
                    $sFile_Name = prepareUniqueName($aExtension);
                }
                else
                {
                    $sFile_Name = $sProjectImage;
                }
                
            $aFields = array
                            (
                            array
                                (
                                    'field' => 'project_title',
                                    'value' => $sProjectTitle,
                                    'validation' => 'required',
                                    'message' => __('project_title_required')
                                ),
                            array
                                (
                                    'field' => 'project_description',
                                    'value' => $sProjectDescription,
                                    'validation' => 'required',
                                    'message' => __('project_description_required')
                                ),
                            array
                                (
                                    'field' => 'project_owner',
                                    'value' => $sProjectOwner,
                                    'validation' => 'required',
                                    'message' => __('owner_name_required')
                                ),
                           array
                                (
                                   'field' => 'project_image',
                                   'value' => $sFile,
                                   'validation' => 'required',
                                   'message' => __('project_image_required')
                                )
                            );

            $bIsValid = $oProjects->validateData($aFields);
            if (!empty($bIsValid)) {
                $aProjectsRecord = array
                                        (
                                            'project_title' => $sProjectTitle,
                                            'project_description' => $sProjectDescription,
                                            'project_owner' => $sProjectOwner,
                                            'project_location' => $sProjectLocation,
                                            'project_image' => $sFile_Name
                                        );
                
                                        mkdir($sProjectFolder.$sProjectTitle);
                                        
                $oObjectImage = new  image($_FILES);
                $oObjectImage->uploadAt(getConfig('uploadFilePath').'/'.$sFile_Name);
                $oProjects->addProject($aProjectsRecord);
                $sMessage = __('create_projcect_success');
                $oSession->setSession('sDisplayMessage', $sMessage);
                redirect(getConfig('siteUrl') . '/projects/projects');
            }

        }

        require("projects.tpl.php");
    }
    
    
    public function callRemoveProject() {

        global $oUser, $oSession;
        $nProjectId = $_GET['project_id']; 
        $sTableName = 'projects';
        $aFieldId = array(array($nProjectId));
        $bPhDelete = FALSE;
        $sFieldName = 'project_id';
        $sMessage = __('delete_project_success');
        $oUser->deleteRecordById($sTableName, $aFieldId, $bPhDelete, $sFieldName);
        $oSession->setSession('sDisplayMessage',$sMessage);
        redirect(getConfig('siteUrl').'/projects/projects');
        
    }
  
}