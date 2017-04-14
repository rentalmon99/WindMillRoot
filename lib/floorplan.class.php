<?php

class floorplan extends siCommon {

    public function __construct() {
        $this->oSession = new sessionManager();
        $sDbHost = getconfig('dbHost');
        $sDbUser = getconfig('dbUser');
        $sDbPassword = getconfig('dbPassword');
        $sDbName = getconfig('dbName');
        parent::__construct($sDbHost, $sDbUser, $sDbPassword, $sDbName);
    }
    
    public function getFloorPlans() {
    
        $sAndWhere = " 1=1 ";
        $sQuery = "SELECT
                            *
                        FROM
                            floorplans
                        WHERE   $sAndWhere";
                        
        $aGetFloorPlansData = $this->getList($sQuery);
        $aFloorPlans['records'] = $this->getData($aGetFloorPlansData);
        return $aFloorPlans;
    }

}