<?php

class projectArea extends siCommon {

    public function __construct() {
        $this->oSession = new sessionManager();
        $sDbHost = getconfig('dbHost');
        $sDbUser = getconfig('dbUser');
        $sDbPassword = getconfig('dbPassword');
        $sDbName = getconfig('dbName');
        parent::__construct($sDbHost, $sDbUser, $sDbPassword, $sDbName);
    }

    public function getProjectAreas()    {
        $sAndWhere = " 1=1 ";
        $sQuery = "SELECT
                            project_area_id,
                            project_area_title
                        FROM
                            project_areas
                        WHERE   $sAndWhere";
                        
        $aGetProjectAreasData = $this->getList($sQuery);
        $aProjecAreas['records'] = $this->getData($aGetProjectAreasData);
        return $aProjecAreas;
    }
}