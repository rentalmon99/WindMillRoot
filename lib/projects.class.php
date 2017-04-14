<?php

class projects extends siCommon {

    public function __construct() {
        $this->oSession = new sessionManager();
        $sDbHost = getconfig('dbHost');
        $sDbUser = getconfig('dbUser');
        $sDbPassword = getconfig('dbPassword');
        $sDbName = getconfig('dbName');
        parent::__construct($sDbHost, $sDbUser, $sDbPassword, $sDbName);
    }

    public function getProjectList() {
        $sAndWhere = " 1=1 ";
        $sAndWhere = " deleted = 0 ";
        $sQuery = "SELECT 
                            p.project_id As project_id,	
                            p.project_title As project_title,	
                            p.project_owner As project_owner,
                            p.project_description As project_description,
                            p.project_image As project_image,
                            p.project_location As project_location
                        FROM
                            projects p
                        WHERE $sAndWhere";                
	   			
        $aGetProjectData = $this->getList($sQuery);
        $aProjectList['records'] = $this->getData($aGetProjectData, $sChoice = "ARRAY");
        $mRecordQueryHandler = $this->getList($sQuery, array());
        $aProjectList['total_records'] = $this->countQueryRow($mRecordQueryHandler);        

        return $aProjectList;
        }
        public function getProjectDetails($nProjectId) {
        $nProId = $nProjectId;    
        $sAndWhere = " project_id = $nProjectId "
        ."AND". " deleted = 0 ";
        
        $sQuery = "SELECT 
                            project_id,	
                            project_title,	
                            project_owner,
                            project_description,
                            project_image,
                            project_location
                        FROM
                            projects
                        WHERE $sAndWhere";                
	
        $aGetProjectData = $this->getList($sQuery);
        $aProjectDetail['records'] = $this->getData($aGetProjectData, $sChoice = "ARRAY");
        $mRecordQueryHandler = $this->getList($sQuery, array());
        $aProjectDetail['total_records'] = $this->countQueryRow($mRecordQueryHandler);        

        return $aProjectDetail;
        }

    public function addProject($aProjectsRecord)
    {
        $sTableName = 'projects';
        $sDateTimeFormat = getConfig('dtDateTime');
        $dCreatedAt = date($sDateTimeFormat);
        $dUpdateAt = date($sDateTimeFormat);
                            
        $aInsertFieldArray = array
                                (
                                    'project_title',
                                    'project_description',
                                    'project_owner',
                                    'project_location',          
                                    'project_image',
                                    'created_at',
                                    'updated_at',
                                    'deleted',
                                    'activated'
                                );	
        $aInsertValueArray = array
                                (
                                    array   (
                                                $aProjectsRecord['project_title'],
                                                $aProjectsRecord['project_description'],
                                                $aProjectsRecord['project_owner'],
                                                $aProjectsRecord['project_location'],
                                                $aProjectsRecord['project_image'],
                                                $dCreatedAt,
                                                $dUpdateAt,
                                                0,
                                                1
                                                
                                            )
                                );                                
        return $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
    } 
}