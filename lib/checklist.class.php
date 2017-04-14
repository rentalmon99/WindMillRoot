<?php

class checklist extends siCommon {

    public function __construct() {
        $this->oSession = new sessionManager();
        $sDbHost = getconfig('dbHost');
        $sDbUser = getconfig('dbUser');
        $sDbPassword = getconfig('dbPassword');
        $sDbName = getconfig('dbName');
        parent::__construct($sDbHost, $sDbUser, $sDbPassword, $sDbName);
    }

        public function getChecklists($sProjectName) {
        $sProName = $sProjectName;    
        $sAndWhere = " project_name = '$sProName' ";
        
        $sQuery = "SELECT 
                            checklist_id,	
                            title,	
                            project_area,
                            project_name,
                            status,
                            created_at
                        FROM
                            checklists
                        WHERE $sAndWhere";                
	
        $aGetChecklistData = $this->getList($sQuery);
        $aChecklist['records'] = $this->getData($aGetChecklistData, $sChoice = "ARRAY");
        $mRecordQueryHandler = $this->getList($sQuery, array());
        $aChecklist['total_records'] = $this->countQueryRow($mRecordQueryHandler);        
        
        return $aChecklist;
        }

        
    public function addChecklist($aChecklistRecord) {
       
        $sTableName = 'checklists';
        $sDateTimeFormat = getConfig('dtDateTime');
        $dCreatedAt = date($sDateTimeFormat);
        $dUpdateAt = date($sDateTimeFormat);

        $aInsertFieldArray = array
                                (
                                    'checklist_id',
                                    'title',
                                    'project_name',
                                    'project_area',
                                    'created_at',
                                    'updated_at',
                                    'status'
                                );	
        $aInsertValueArray = array
                                (
                                    array   (
                                                $aChecklistRecord['checklist_id'],
                                                $aChecklistRecord['checklist_title'],
                                                $aChecklistRecord['checklist_project'],
                                                $aChecklistRecord['checklist_project_area'],
                                                $dCreatedAt,
                                                $dUpdateAt,
                                                1
                                            )
                                ); 

        return $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
    }
}