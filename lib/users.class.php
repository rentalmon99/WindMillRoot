<?php

/**
 * StepIn Solutions venture
 * 
 *
 * @package Stepone 
 */
class users extends siCommon {

    // constructor
    public function __construct() {
        $this->oSession = new sessionManager();
        $sDbHost = getconfig('dbHost');
        $sDbUser = getconfig('dbUser');
        $sDbPassword = getconfig('dbPassword');
        $sDbName = getconfig('dbName');

        //$this->oObject = new siCommon($sDbHost,$sDbUser,$sDbPassword,$sDbName);
        parent::__construct($sDbHost, $sDbUser, $sDbPassword, $sDbName);
    }

    // Do Login
    public function doLogin($sUserCredential, $aSaveUserSession = array()) {
        if (!empty($aSaveUserSession)) {
            $nIdUser = isset($sUserCredential[0]['id_admin']) ? $sUserCredential[0]['id_admin'] : $sUserCredential[0]['id_user'];
            $nVerificationKey = isset($aSaveUserSession['verification_key']) ? $aSaveUserSession['verification_key'] : '';
            $sDeviceId = isset($aSaveUserSession['device_id']) ? $aSaveUserSession['device_id'] : '';
            $sRegistrationId = isset($aSaveUserSession['registration_id']) ? $aSaveUserSession['registration_id'] : '';
            $sDateTimeFormat = getConfig('dtDateTime');
            $dCreatedAt = date($sDateTimeFormat);

            if (!empty($nIdUser)) {
                $sTableName = 'admin';
                $aInsertFieldArray = array
                                            (
                                            'id_user',
                                            'login_datetime',
                                            'logout_datetime',
                                            'verification_key',
                                            'device_id',
                                            'registration_id'
                                        );
                $aInsertValueArray = array
                                            (
                                            array
                                                (
                                                $nIdUser,
                                                $dCreatedAt,
                                                '',
                                                $nVerificationKey,
                                                $sDeviceId,
                                                $sRegistrationId
                                            )
                                        );
                $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
                $nId = mysql_insert_id();
                $sUserCredential[0]['id_user_session'] = $nId;
            }
        }
        $this->oSession->setSession(getconfig('sSessionName'), $sUserCredential);
    }

    // Is Logedin
    public function isLoggedin() {
      
        return $this->oSession->getSession(getconfig('sSessionName'));
    }

    // Do LogOut
     public function doLogOut() 
        {
            $this->oSession->removeSession();
        }

        
        public function getUserEmailInfo($sEmail = '')
        {
            $sAndWhere = " 1 = 1";
            $sAndWhere .= " AND a.email = '$sEmail' ";
            $sAndWhere .= " AND a.activated='1' AND a.deleted = '0'";
            
           $sQuery = "SELECT
                                   a.id_admin AS id_admin,
                                   a.first_name AS first_name,
                                   a.last_name AS last_name,
                                   a.email AS email,
                                   a.login_name AS login_name
                          FROM
                                   admin a
                          WHERE " . $sAndWhere;
          
            $sUSerSiteHandler = $this->getList($sQuery);
            return $this->getData($sUSerSiteHandler, "ARRAY");
        }
    /**
     * function for varification of registered user
     * @param type $sVerificationKey
     * @return boolean
     */
    public function getLoginSessionAfterVerification($sVerificationKey) {
        if (empty($sVerificationKey))
            return false;
        $sAndWhere = ' 1 = 1';
        $sAndWhere .= " AND u.deleted = '0' AND u.activated = '1'";
        $sAndWhere .= " AND u.verification_key ='" . $sVerificationKey . "'";

        $sSql = "SELECT 
                            u.id_user,
                            u.first_name,
                            u.email,
                            u.verification_key,
                            u.mobile_number
                    FROM
                            users u
                    WHERE" . $sAndWhere;

        $sQueryHendler = $this->oObject->getList($sSql, array(), array(), array(), array(), array());
        return $this->oObject->getData($sQueryHendler, "ARRAY");
    }

    /**
     * 
     * @param type $sEmail
     * @param type $aLimit
     * @param type $aGroupBy
     * @param type $aSearch
     * @param type $aSort
     * @param type $sMode
     * @return type
     */
    public function getUserCredential($sEmail, $aLimit = array(), $aGroupBy = array(), $aSearch = array(), $aSort = array(), $sMode = '') {
        if (empty($sEmail))
            return false;

        $sAndWhere = " 1 = 1 ";
        $sAndWhere .= " AND u.email =" . "'" . $sEmail . "'";
        $sAndWhere .= " AND u.activated = '1' AND u.deleted = '0'";

        $sQuery = "SELECT
                               id_user, 
                               first_name, 
                               last_name, 
                               user_name, 
                               password, 
                               email, 
                               image, 
                               phone, 
                               address, 
                               description                                       
                         FROM
                               users u
                         WHERE" . $sAndWhere;

        $aClientsInformation = $this->getList($sQuery);
        return $this->getData($aClientsInformation, "ARRAY");
    }

    /**
     * 
     * @param type $aUserData
     * @return type
     */
    public function updateUserCredentials($aUserData) {
        if (count($aUserData) == 0 || !is_array($aUserData))
            return false;
        $sTableName = 'users';
        $dTimeFormet = getConfig('dtDateTime');
        $dDate = date($dTimeFormet);

        $aInsertFieldArray = array(
            'id_user',
            'salt',
            'password',
            'updated_at'
        );
        $aInsertValueArray = array(
            array(
                $aUserData['id_user'],
                $aUserData['salt'],
                $aUserData['password'],
                $dDate
            )
        );
        return $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
    }

    /**
     * get owner details from users where id_user = $nIdUser
     * @param type $nIdUser
     * @param type $aLimit
     * @return type
     */
    public function getUserDetail($nIdUser, $aLimit = array()) {
        if (empty($nIdUser) || !is_numeric($nIdUser))
            return false;

        $sAndWhere = " 1 = 1";
        $sAndWhere .= " AND u.deleted = '0'";
        $sAndWhere .= " AND u.id_user = $nIdUser";
        $sQuery = "SELECT
                               u.id_user AS id_user,
                               u.user_name AS user_name,
                               u.first_name AS first_name,
                               u.last_name AS last_name,
                               u.email AS email,
                               u.phone AS phone,
                               u.image AS image,
                               u.password AS password,
                               u.address AS address,
                               u.description AS description 
                      FROM
                               users u
                      WHERE" . $sAndWhere;

        $sUSerSiteHandler = $this->getList($sQuery, $aLimit);
        return $this->getData($sUSerSiteHandler, "ARRAY");
    }

    /**
     * 
     * @param type $aUserRegister
     * @return type
     */
    public function userRegister($aUserRegister) {
        if (count($aUserRegister) == 0 || !is_array($aUserRegister))
            return false;
        $sTableName = 'users';
        $dTimeFormet = getConfig('dtDateTime');
        $dDate = date($dTimeFormet);


        $aInsertFieldArray = array(
                                    'first_name',
                                    'last_name',
                                    'user_name',
                                    'email',
                                    'password',
                                    'salt',
                                    'phone',
                                    'image',
                                    'address',
                                    'description',
                                    'activated',
                                    'created_at',
                                    'updated_at'
                                );
        $aInsertValueArray = array(
                                    array(
                                        $aUserRegister['first_name'],
                                        $aUserRegister['last_name'],
                                        $aUserRegister['user_name'],
                                        $aUserRegister['email'],
                                        $aUserRegister['password'],
                                        $aUserRegister['salt'],
                                        $aUserRegister['phone'],
                                        $aUserRegister['image'],
                                        $aUserRegister['address'],
                                        $aUserRegister['description'],
                                        $aUserRegister['activated'],
                                        $dDate,
                                        $dDate
                                    )
                                );

        return $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
    }

    /**
     * 
     * @param type $aUserData
     * @return type
     */
    public function updateProfile($aUserData) {

        if (count($aUserData) == 0 || !is_array($aUserData))
            return false;


        $sTableName = 'users';
        $dTimeFormet = getConfig('dtDateTime');
        $dDate = date($dTimeFormet);

        $aInsertFieldArray = array(
            'id_user',
            'first_name',
            'last_name',
            'email',
            'phone',
            'updated_at'
        );


        $aInsertValueArray = array(
            array(
                isset($aUserData['id_user']) ? $aUserData['id_user'] : '',
                $aUserData['first_name'],
                $aUserData['last_name'],
                /* $aUserData['user_name'], */
                $aUserData['email'],
                $aUserData['phone'],
                $dDate
            )
        );


        if (empty($aUserData['id_user'])) {
            $aImageFieldArray = array(
                'salt',
                'password'
            );

            $aInsertFieldArray = array_merge($aInsertFieldArray, $aImageFieldArray);

            $aImageValueArray = array(
                $aUserData['salt'],
                $aUserData['password']
            );

            $aInsertValueArray[0] = array_merge($aInsertValueArray[0], $aImageValueArray);
        }

        if (!empty($aUserData['image'])) {
            $aImageFieldArray = array(
                'image'
            );

            $aInsertFieldArray = array_merge($aInsertFieldArray, $aImageFieldArray);

            $aImageValueArray = array(
                $aUserData['image']
            );

            $aInsertValueArray[0] = array_merge($aInsertValueArray[0], $aImageValueArray);
        }

        if (!empty($aUserData['address'])) {
            $aAddressFieldArray = array(
                'address'
            );

            $aInsertFieldArray = array_merge($aInsertFieldArray, $aAddressFieldArray);

            $aAddressValueArray = array(
                $aUserData['address']
            );

            $aInsertValueArray[0] = array_merge($aInsertValueArray[0], $aAddressValueArray);
        }

        if (!empty($aUserData['description'])) {
            $aDescFieldArray = array(
                'description'
            );

            $aInsertFieldArray = array_merge($aInsertFieldArray, $aDescFieldArray);

            $aDescValueArray = array(
                $aUserData['description']
            );

            $aInsertValueArray[0] = array_merge($aInsertValueArray[0], $aDescValueArray);
        }

        return $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
    }

    public function getAdminDetail() {
        $sAndWhere = '1 = 1';
        $sAndWhere .= " AND a.deleted = '0'";
        $sAndWhere .= " AND a.activated = '1'";
        $sAndWhere .= " AND a.id_admin = $nIdAdmin";
        $sQuery = 'SELECT
               
                            a.admin_name,
                            a.first_name,
                            a.last_name,
                            a.email,
                            a.salt,
                            a.password,
                            a.deleted,
                            a.activated,
                            a.created_at,
                            a.updated_at
                    FROM
                            admins a
                    WHERE
                            ' . $sAndWhere;
        $sAdminSiteHandler = $this->getList($sQuery);
        return $this->getList($sAdminSiteHandler, 'ARRAY');
    }

    /**
     * get all users details
     */
    public function getUserList($aLimit = '') {
//        $sAndWhere = " 1 = 1";
//        $sAndWhere .= " AND u.activated='1' AND u.deleted = '0'";
//        $sQuery = "SELECT
//                               u.id_user AS id_user,
//                               u.user_name AS user_name,
//                               u.first_name AS first_name,
//                               u.last_name AS last_name,
//                               u.email AS email,
//                               u.phone AS phone,
//                               u.image AS image,
//                               u.password AS password,
//                               u.address AS address,
//                               u.description AS description 
//                      FROM
//                               users u
//                      WHERE" . $sAndWhere;
//
//
//        $sUSerSiteHandler = $this->getList($sQuery, $aLimit);
//        return $this->getData($sUSerSiteHandler, "ARRAY");
        $sAndWhere = " 1=1 ";
        $sQuery = "SELECT 
                               u.id_user AS id_user,
                               u.user_name AS user_name,
                               u.first_name AS first_name,
                               u.last_name AS last_name,
                               u.email AS email,
                               u.phone AS phone,
                               u.image AS image,
                               u.password AS password,
                               u.address AS address,
                               u.description AS description 
                               u.role,
                               u.city
                        FROM
                            users u
                        WHERE $sAndWhere";                
	   				 
        $aGetUserData = $this->getList($sQuery);
        $aUserList['records'] = $this->getData($aGetUserData, $sChoice = "ARRAY");
        $mQueryHandler = $this->getList($sQuery, array());
        $aUserList['total_records'] = $this->countQueryRow($mQueryHandler);        
        return $aUserList;
        
        
    }

    public function addedituser($aFieldValue) {
        $sTableName = 'users';
        $sDateTimeFormat = getConfig('dtDateTime');
        $dCreatedAt = date($sDateTimeFormat);
        $nActivated = '1';
        $nDeleted = '0';
        $aField = array
                        (
                            'id_user',
                            'first_name',
                            'last_name',
                            'email',
                            'salt',
                            'password',
                            'phone_no',
                            'pincode',
                            'city',
                            'file_name',
                            'latitude',
                            'longitude',
                            'created_at',
                            'updated_at',
                            'activated',
                            'deleted'
                        );
        $aFieldValue = array
                            (
                                array
                                    (
                                    $aFieldValue['id_user'],
                                    $aFieldValue['first_name'],
                                    $aFieldValue['last_name'],
                                    $aFieldValue['email'],
                                    $aFieldValue['salt'],
                                    $aFieldValue['password'],
                                    $aFieldValue['phone_no'],
                                    $aFieldValue['pincode'],
                                    $aFieldValue['city'],
                                    $aFieldValue['image_name'],
                                    $aFieldValue['latitude'],
                                    $aFieldValue['longitude'],
                                    $dCreatedAt,
                                    $dCreatedAt,
                                    $nActivated,
                                    $nDeleted
                                )
                        );
        $aAddUser = $this->saveRecords($sTableName, $aField, $aFieldValue);

        return $nLastUserId = empty($aFieldValue['id_user']) ? mysql_insert_id() : $aFieldValue['id_user'];
    }

    public function getEmailUserInfo($sEmail) {
        if (empty($sEmail))
            return false;
        $sAndWhere = " 1 = 1";
        $sAndWhere .= " AND deleted = '0' AND activated = '1'";
        $sAndWhere .= " AND email = '" . $sEmail . "'";
        $sQuery = "SELECT
                               u.id_user AS id_user, 
                               u.first_name AS first_name, 
                               u.last_name AS last_name, 
                               u.email AS email
                         FROM
                               users u
                         WHERE 
                                email =" . "'" . $sEmail . "'";
        $aUsersListHandler = $this->getList($sQuery);
        return $this->getData($aUsersListHandler, "ARRAY");
    }

    public function changePassword($aUsePasswordDetail) {
        $sDateTimeFormat = getConfig('dtDateTime');
        $dUpdatedAt = date($sDateTimeFormat);

        $aFields = array
            (
            'id_user',
            'password',
            'updated_at'
        );
        $asPrepareData = array(
            array(
                $aUsePasswordDetail['id_user'],
                $aUsePasswordDetail['new_password'],
                $dUpdatedAt
            )
        );
        $this->saveRecords("users", $aFields, $asPrepareData);
    }

    public function getLoginSession($bIsValid) {
        $sAndWhere = ' 1 = 1';
        $sAndWhere .= " AND u.deleted = '0' AND u.activated = '1'";
        $sAndWhere .= " AND u.id_user = " . $bIsValid['id_user'];
        $sSql = "SELECT 
                            u.id_user AS id_user,
                            u.first_name AS first_name,
                            u.email AS email,
                            u.file_name AS file_name
                   FROM
                            users u
                   WHERE " . $sAndWhere;

        $sQueryHendler = $this->getList($sSql, array(), array(), array(), array(), array());
        return $this->getData($sQueryHendler, "ARRAY");
    }
    
    /**
    * getUserSessionFromVerification
    * @param type $sVerificationKey
    * @return type
    */
   public function getUserSessionFromVerification($sVerificationKey)
   {
       if(empty($sVerificationKey)) return false;
       $sAndWhere = ' 1 = 1'; 
       $sAndWhere .= " AND u.deleted = '0' AND u.activated = '1'";
       $sAndWhere .= " AND usi.verification_key = ".$sVerificationKey;
       $sSql = "SELECT 
                       usi.id_user as id_user,
                       usi.id_user_session as id_user_session
              FROM
                       user_session usi
              LEFT JOIN
                       users u 
              ON
                       usi.id_user = u.id_user  
              WHERE ".$sAndWhere;
       $sQueryHendler = $this->getList($sSql,array(),array(),array(),array(),array());
       return $this->getData($sQueryHendler,"ARRAY"); 
   }  
   
   /**
     * get all users details
     */
    public function getUserInfo($nIdUser ='') 
    {
        $sAndWhere = " 1 = 1";
        if(!empty($nIdUser))
        {
            $sAndWhere .= " AND u.id_user =".$nIdUser;
        }
        $sAndWhere .= " AND u.activated='1' AND u.deleted = '0'";
       
        $sQuery = "SELECT
                               u.id_user AS id_user,
                               u.first_name AS first_name,
                               u.last_name AS last_name,
                               u.email AS email,
                               u.password AS password,
                               u.phone_no AS phone_no,
                               u.pincode AS pincode,
                               u.city AS city,
                               u.file_name AS file_name,
                               u.latitude AS latitude,
                               u.longitude AS longitude
                      FROM
                               users u
                      WHERE ". $sAndWhere;
        $sUSerSiteHandler = $this->getList($sQuery);
        return $this->getData($sUSerSiteHandler, "ARRAY");
    }
    public function getUsersRegistrationId($sDeviceId, $sRegistrationId, $sTitle)
    {
        $sAndWhere = " 1 = 1";
        if(!empty($sDeviceId))
        {
            $sAndWhere .= " AND device_id = '$sDeviceId'";
        }
        if(!empty($sDeviceId) && !empty($sRegistrationId))
        {
            $sAndWhere .= " AND device_id = '$sDeviceId' AND registration_id = '$sRegistrationId' ";
        }
        if(!empty($sTitle))
        {
            $sAndWhere .= " GROUP BY us.registration_id";
        }
        $sQuery = "SELECT
                        us.id_user_session as id_user_session,
                        us.id_user AS id_user,
                        us.logout_datetime AS logout_datetime,
                        us.verification_key AS verification_key,
                        us.device_id AS device_id,
                        us.registration_id AS registration_id
                    FROM
                        user_session us
                    WHERE ". $sAndWhere;
        $sUSerSiteHandler = $this->getList($sQuery);
        return $this->getData($sUSerSiteHandler, 'ARRAY');
    }
    public function getFavouriteBusinessUsersRegistrationId($nIdBusiness)
    {
        $sAndWhere = " 1 = 1";
        if(!empty($nIdBusiness))
        {
            $sAndWhere .= " AND fav.id_business = $nIdBusiness";
        }
        $sAndWhere .= " AND us.logout_datetime IS NULL ";
        $sAndWhere .= " GROUP BY us.registration_id";
        $sQuery = "select 
                                fav.id_business AS id_business,
                                fav.id_user AS id_user,
                                us.registration_id AS registration_id
                            FROM
                                user_favourites fav
                            LEFT JOIN
                                   user_session us
                            ON
                                fav.id_user = us.id_user
                            WHERE" .$sAndWhere;
        $sQueryHendler = $this->getList($sQuery,array());
       return $this->getData($sQueryHendler,"ARRAY"); 
    }
    public function adddeviceinformation($aFieldValues) {
        $sTableName = 'user_session';
        $aField = array
                        (
                            'id_user_session',
                            'id_user',
                            'device_id',
                            'registration_id'
                        );
        $aFieldValue[] = array
                            (
                                '',
                                '', 
                                $aFieldValues['device_id'],
                                $aFieldValues['registration_id']
                        );
        $this->saveRecords($sTableName, $aField, $aFieldValue);
    }
    public function getUsersCount()
    {
        $sQuery ="SELECT 
                        count(*) 
                    FROM
                        users";
        $aActivityTypeHandler = $this->getList($sQuery,  array(), array(), array(), array(), array());
        return $this->getData($aActivityTypeHandler,"ARRAY");
    }
    public function getUserRole()
    {
        $sAndWhere = " 1=1 ";
        $sQuery = "SELECT 
                            role_id,
                            role_title
                        FROM
                            roles
                        WHERE $sAndWhere";                
	$aGetRoleData = $this->getList($sQuery);
        $aUserRole['records'] = $this->getData($aGetRoleData, $sChoice = "ARRAY");
        $mRecordQueryHandler = $this->getList($sQuery, array());
        $aUserRole['total_records'] = $this->countQueryRow($mRecordQueryHandler);        
        return $aUserRole;
        }
    
    public function addUser($aUsersRecord, $nUserId)
    {
        $sTableName = 'users';
        $sDateTimeFormat = getConfig('dtDateTime');
        $dCreatedAt = date($sDateTimeFormat);
        $dUpdateAt = date($sDateTimeFormat);
        $aInsertFieldArray = array
                                    (
                                        'user_name',
                                        'user_image',
                                        'user_email',
                                        'user_address',
                                        'user_mobile',
                                        'user_role',
                                        'user_gender',
                                        'user_city',
                                        'created_at',
                                        'updated_at',
                                        'activated',
                                        'deleted'
                                    );	
        $aInsertValueArray = array
                                (
                                    array   
                                        (
                                            $aUsersRecord['user_name'],
                                            $aUsersRecord['user_image'],
                                            $aUsersRecord['user_email'],
                                            $aUsersRecord['user_address'],
                                            $aUsersRecord['user_mobile'],
                                            $aUsersRecord['user_role'],
                                            $aUsersRecord['user_gender'],
                                            $aUsersRecord['user_city'],
                                            $dCreatedAt,
                                            $dUpdateAt,
                                            1,
                                            0
                                        )
                                );                                
        return $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
    } 

}