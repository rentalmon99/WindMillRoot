<?php
/**
 * StepIn Solutions venture
 * 
 *
 * @package Stepone
 */
class siCommon extends mySql {

    //Constructer
    public function __construct($sDbHost = "", $sDbUser = "", $sDbPassword = "", $sDbName = "") {
        parent::__construct($sDbHost, $sDbUser, $sDbPassword, $sDbName);
    }

    //Get List
    public function getList($sQuery, $aLimit = array(), $aGroupBy = array(), $aSearch = array(), $aSort = array(), $sMode = '', $aHaving = array()) {
        $ssSearch = '';
        $ssGroupBy = '';
        $ssSort = '';
        $limit = '';
        $ssHaving = '';
        if ($aLimit != '') {
            foreach ($aLimit as $sLimit) {
                foreach ($sLimit as $sLimitValue => $limitValue) {
                    $limit = $limitValue;
                }
            }
        }
        if (count($aSearch)) {
            switch ($sMode) {
                case 'LIKE':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch = $sSearch . ' ' . 'LIKE' . ' ' . '"%' . $sSearchValue . '%"' . ' ';
                        }
                    }
                    break;
                case 'IN':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch = $sSearch . ' IN ' . "('" . '' . $sSearchValue . "') ";
                        }
                    }
                    break;
                case '=':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch .= $sSearch . ' = ' . "'" . '' . $sSearchValue . "' ";
                        }
                    }
                    break;
                case '!=':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch = $sSearch . ' != ' . "'" . '' . $sSearchValue . "' ";
                        }
                    }
                    break;
                case '>=':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch = $sSearch . ' >= ' . "'" . '' . $sSearchValue . "' ";
                        }
                    }
                    break;
                case '<=':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch = $sSearch . ' <= ' . "'" . '' . $sSearchValue . "' ";
                        }
                    }
                    break;
            }
        }
        if ($aSort != '') {
            foreach ($aSort as $sSort) {
                foreach ($sSort as $sSortValues => $sSortRow) {
                    $ssSort = $sSortValues;
                    foreach ($sSortRow as $sSortValue) {
                        $ssSort.= $sSortValue;
                    }
                }
            }
        }
        if ($aGroupBy != '') {
            foreach ($aGroupBy as $sGroupBy => $eValue) {
                $ssGroupBy = $sGroupBy;
                $ssGroupBy .= $eValue;
            }
        }
        if ($aHaving != '') {
            foreach ($aHaving as $sHaving => $eValue) {
                $ssHaving = $sHaving;
                $ssHaving .= $eValue;
            }
        }
        $aQuery = $sQuery . $ssSearch . $ssGroupBy . $ssHaving . $ssSort . $limit;
        return $this->executeQuery($aQuery);
    }

    // Delete Record
    public function deleteRecordById($sTableName, $aFieldId, $bPhDelete, $aFieldName) {
        global $sDbHost, $sDbUser, $sDbPassword, $sDbName;
        if ($bPhDelete) {
            $sDelete = "DELETE FROM " . $sTableName . " WHERE " . $aFieldName . " IN (" . implode(",", $aFieldId[0]) . ")";
        return $this->executeQuery($sDelete);
        } else {
            $sUpdate = "UPDATE " . $sTableName . " SET deleted = " . "'" . "1" . "'" . " WHERE " . $aFieldName . " IN (" . implode(",", $aFieldId[0]) . ")";
            return $this->executeQuery($sUpdate);
        }
    }

    public function validateData($aValidation) {
        $oSession = new sessionManager();

        $bIsValid = true;
        foreach ($aValidation as $aValidationDetails) {
            if ($aValidationDetails['validation'] == "required") {
                if ($aValidationDetails['value'] == "") {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if($aValidationDetails['validation'] == "isIp")
            {
                if (!filter_var($aValidationDetails['value'], FILTER_VALIDATE_IP)) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "isNumeric") {
                if (!is_numeric($aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "isAlpha") {
                if (!ctype_alpha($aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "email") {
                if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "fileType") {
                $mType = isset($aValidationDetails['value']['type']) ? strtolower($aValidationDetails['value']['type']) : '';
                $validTypes = $aValidationDetails['validTypes'];
                if (!in_array($mType, $validTypes)) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "unique") {
                $sQuery = " SELECT "
                        . $aValidationDetails['table_field_name'] .
                        " FROM "
                        . $aValidationDetails['table_name'] .
                        " WHERE "
                        . $aValidationDetails['table_field_name'] . " = '" . $aValidationDetails['value'] . "' AND " . $aValidationDetails['table_field_id'] . "!= '" . $aValidationDetails['id'] . "' AND deleted = '0' " . " LIMIT 1";
                $mQueryHandler = $this->executeQuery($sQuery);
                $aInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aInfo);
                if ($nCountRecord != '') {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            //for GTC admin side host validation
            if ($aValidationDetails['validation'] == "uniquefield") {
                $sQuery = " SELECT "
                        . $aValidationDetails['table_field_id'] .
                        ',' . $aValidationDetails['table_field_name'] .
                        " FROM "
                        . $aValidationDetails['table_name'] .
                        " WHERE "
                        . $aValidationDetails['table_field_name'] . " = '" . $aValidationDetails['value'] . "' AND " . $aValidationDetails['table_field_id'] . "!= '" . $aValidationDetails['id'] . "' AND deleted = '0' " . " LIMIT 1";
                $mQueryHandler = $this->executeQuery($sQuery);
                $aInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aInfo);
                if ($nCountRecord > 0) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $oSession->setError('validation', 'uniquefield');
                    $oSession->setError('id_user', $aInfo[0][$aValidationDetails['table_field_id']]);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "alphanumeric") {
                if (!ctype_alnum($aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "confirm") {
                if ($aValidationDetails['value'][0] != $aValidationDetails['value'][1]) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "currentPass") {

                $sSql = "SELECT
                                      password
                                FROM " . $aValidationDetails['tableName'] . "
                                WHERE " . $aValidationDetails['idField'] . "
                                = " . $aValidationDetails['idValue'];

                $mQueryHandler = $this->executeQuery($sSql);
                $aUserInfo = $this->getData($mQueryHandler, "ARRAY");

                $sPassword = $aUserInfo[0]['password'];
                $sCurrentPassword = md5($aValidationDetails['value']);

                if ($sPassword != $sCurrentPassword) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }

            if ($aValidationDetails['validation'] == "currentPassword") {
                $sSql = "SELECT
                                      salt,password
                                FROM " . $aValidationDetails['tableName'] . "
                                WHERE " . $aValidationDetails['idField'] . "
                                = " . $aValidationDetails['idValue'];

                $mQueryHandler = $this->executeQuery($sSql);
                $aInfo = $this->getData($mQueryHandler, "ARRAY");

                $sPassword = $aInfo[0]['password'];
                $sCurrentPassword = sha1($aInfo[0]['salt'] . $aValidationDetails['value']);

                if ($sPassword != $sCurrentPassword) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                } else {
                    $bIsValid = $aInfo;
                }
            }
            if ($aValidationDetails['validation'] == "minimumlength") {
                if (strlen($aValidationDetails['value'][0]) < $aValidationDetails['value'][1]) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
             if ($aValidationDetails['validation'] == "maximumlength") {
                if (strlen($aValidationDetails['value'][0]) > $aValidationDetails['value'][1]) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "fileSize") {
                    if (!empty($aValidationDetails['value'][0]) && ($aValidationDetails['value'][0] < $aValidationDetails['validSize']['width'] || $aValidationDetails['value'][1] < $aValidationDetails['validSize']['height'])) {
                        $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                        $bIsValid = false;
                    }
            }
            if ($aValidationDetails['validation'] == "isValidUrl") {
                if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "isValidDateFormat") {
                if (!preg_match("/(0[1-9]|1[012])[ \/.](0[1-9]|[12][0-9]|3[01])[ \/.](19|20)\d\d/",$aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            /* if($aValidationDetails["validation"] == 'number')
              {
              if(isNaN($aValidationDetails['value']))
              {
              $oSession->setError($aValidationDetails['field'],$aValidationDetails['message']);
              $bIsValid = false;
              }
              } */
            if ($aValidationDetails['validation'] == "isLoggedin") {
                $sAndWhere = '1 = 1';
            
                $sAndWhere .= ' AND ' . $aValidationDetails['aCredentials'][0] . '="' . $aValidationDetails['value'][0] . '"';
                //$sAndWhere .= ' AND '.$aValidationDetails['aCredentials'][1].'="'.$aValidationDetails['value'][1].'"';
                //$sAndWhere .= ' AND activated = 1 AND deleted = 0';

                $sSql = "SELECT
                                    salt,password," . implode(",", $aValidationDetails['aDataForSession']) .
                        " FROM "
                        . $aValidationDetails['tableName'] .
                        " WHERE " . $sAndWhere;
                $mQueryHandler = $this->executeQuery($sSql);

                $aUserInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aUserInfo);
                if (!$nCountRecord || sha1($aUserInfo[0]['salt'] . $aValidationDetails['value'][1]) != $aUserInfo[0]['password']) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                } else {
                    unset($aUserInfo[0]['salt']);
                    unset($aUserInfo[0]['password']);
                    $bIsValid = $aUserInfo;
                }
            }
            if ($aValidationDetails['validation'] == "isVerified") {
                $sAndWhere = '1 = 1';

                $sAndWhere .= ' AND ' . $aValidationDetails['aCredentials'][0] . '="' . $aValidationDetails['value'][0] . '"';
                $sAndWhere .= ' AND ' . $aValidationDetails['aCredentials'][2] . '="' . $aValidationDetails['value'][2] . '"';
                $sAndWhere .= ' AND activated = 1 AND deleted = 0';

                $sSql = "SELECT
                                    salt,password," . implode(",", $aValidationDetails['aDataForSession']) .
                        " FROM "
                        . $aValidationDetails['tableName'] .
                        " WHERE " . $sAndWhere;

                $mQueryHandler = $this->executeQuery($sSql);

                $aUserInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aUserInfo);


                if (!$nCountRecord || sha1($aUserInfo[0]['salt'] . $aValidationDetails['value'][1]) != $aUserInfo[0]['password']) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                } else {
                    unset($aUserInfo[0]['salt']);
                    unset($aUserInfo[0]['password']);
                    $bIsValid = $aUserInfo;
                }
            }
            if ($aValidationDetails['validation'] == "isLogged") {
                $sAndWhere = '1 = 1';

                $sAndWhere .= ' AND ' . $aValidationDetails['aCredentials'][0] . '="' . $aValidationDetails['value'][0] . '"';
                //$sAndWhere .= ' AND '.$aValidationDetails['aCredentials'][1].'="'.$aValidationDetails['value'][1].'"';
                //$sAndWhere .= ' AND activated = 1 AND deleted = 0';

                $sSql = "SELECT
                                    password," . implode(",", $aValidationDetails['aDataForSession']) .
                        " FROM "
                        . $aValidationDetails['tableName'] .
                        " WHERE " . $sAndWhere;

                $mQueryHandler = $this->executeQuery($sSql);

                $aUserInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aUserInfo);

                if (!$nCountRecord || md5($aValidationDetails['value'][1]) != $aUserInfo[0]['password']) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                } else {
                    $bIsValid = $aUserInfo;
                }
            }
        }

        return $bIsValid;
    }

    //Insert Record
    //Update Record

    public function saveRecords($sTableName, $aFields, $aData) {
        
        $sInsertQuery = "INSERT INTO " . $sTableName . "(" . implode(",", $aFields) . ") VALUES ";
        
        foreach ($aData as $aValues) {
            $sInsertQuery .= "('" . implode("','", $aValues) . "'),";
        }
        $sInsertQuery = trim($sInsertQuery, ",") . " ON DUPLICATE KEY UPDATE ";
        
        foreach ($aFields as $sField) {
            $sInsertQuery .= $sField . " = VALUES(" . $sField . "),";
        }

        $sInsertQuery = trim($sInsertQuery, ",");
        return $this->getLastInsertedId($sInsertQuery);
    }

}

