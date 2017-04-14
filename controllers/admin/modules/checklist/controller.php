<?php
class checklistController {

    public $aLayout = array('index'=>'main','documents' => 'main','checklist'=>'main','floorplan'=>'main');
    public $aLoginRequired = array('index'=> true,'documents' => true,'checklist'=>true,'floorplan'=>true);

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
    public function callCheckList() {
        
        global $oUser, $oSession;

        $nProId = $_GET['project_id'];
        $sProName = $_GET['project_name'];

        $oChecklist = new checklist();
        $aChecklists = $oChecklist->getChecklists($sProName);

        $oProjects = new projects();
        $aProjectLists = $oProjects->getProjectList();

        $oProjectArea = new projectArea();
        $aProjecAreas = $oProjectArea->getProjectAreas();
        
        require("checklist.tpl.php");

        $nChecklistStatus = 1;
        $sChecklistId = isset($_POST['checklist_id']) ? $_POST['checklist_id'] : '';
        $sChecklistTitle = isset($_POST['checklist_title']) ? $_POST['checklist_title'] : '';
        $sChecklistProjectName = $sProName;
        $sChecklistProjectArea = isset($_POST['checklist_project_area']) ? $_POST['checklist_project_area'] : '';
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_checklist'])){
            
            $aFields = array
                (
                array
                    (
                    'field' => 'checklist_id',
                    'value' => $sChecklistId,
                    'validation' => 'required',
                    'message' => __('checklist_id_required')
                ),
                array
                    (
                    'field' => 'checklist_title',
                    'value' => $sChecklistTitle,
                    'validation' => 'required',
                    'message' => __('checklist_title_required')
                ),
                array
                    (
                    'field' => 'checklist_project',
                    'value' => $sChecklistProjectName,
                    'validation' => 'required',
                    'message' => __('checklist_project_required')
                ),
               array
                    (
                   'field' => 'checklist_project_area',
                   'value' => $sChecklistProjectArea,
                   'validation' => 'required',
                   'message' => __('checklist_project_area_required')
                )
            );
             
            $bIsValid = $oChecklist->validateData($aFields);
            if (!empty($bIsValid)) {
                $aChecklistRecord = array
                                        (
                                            'checklist_id' => $sChecklistId,
                                            'checklist_title' => $sChecklistTitle,
                                            'checklist_project' => $sChecklistProjectName,
                                            'checklist_project_area' => $sChecklistProjectArea
                                        );
                $oChecklist->addChecklist($aChecklistRecord);
                $sMessage = __('add_checklist_success');
                $oSession->setSession('sDisplayMessage', $sMessage);
                redirect(getConfig('siteUrl') . '/checklist/checklist');
            }

        }
    }
}