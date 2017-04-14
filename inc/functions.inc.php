<?php

/**
 * StepIn Solutions venture, an MVC framework
 * procedural helper file
 *
 * @package stepOne 
 */
function __autoload($sClassName) {
    require(getconfig('rootDir') . "/lib/" . $sClassName . ".class.php");
}

function __($sString, $aDynamicValues = array()) {
    global $aLanguage;
    return isset($aLanguage[getconfig('language')][$sString]) ? vsprintf($aLanguage[getconfig('language')][$sString], $aDynamicValues) : $sString;
}

//Pagging Component
function add_component($sComponentName, $aParameters = array()) {
    global $sAppName;

    $sAction = '';

    if (file_exists(getconfig('rootDir') . "/controllers/" . $sAppName . "/modules/components/" . $sComponentName . "Component/controller.php")) {
        //if controller exists get the file otherwise return __(missing component)
        require_once(getconfig('rootDir') . "/controllers/" . $sAppName . "/modules/components/" . $sComponentName . "Component/controller.php");
        //create object of controller
        $oComponentController = eval("return new " . $sComponentName . "ComponentController();");

        //call component
        eval('$oComponentController->callComponent' . $sAction . '($aParameters);');
    }
}

function getConfig($sConfigurationOption) {
    global $aConfig, $sAppName;
    if (isset($aConfig[$sAppName]) && isset($aConfig[$sAppName][$sConfigurationOption]))
        return $aConfig[$sAppName][$sConfigurationOption];
    elseif ($aConfig['common'][$sConfigurationOption])
        return $aConfig['common'][$sConfigurationOption];
    else
        return false;
}

function redirect($url) {
    ob_clean();
    header('Location: ' . $url);
}

function truncateString($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}
function prepareUniqueName($aLogo)
{
    $sLogo = array_pop($aLogo);
    $sCompanyLogo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10 );
    $sCombineName = $sCompanyLogo .'.'.$sLogo;
    $logo = $sCombineName;
    return $logo;
}
function checkString($checkString)
{
    return htmlspecialchars ($checkString);
}
/**
 * getParamsFromUrl use into routers class
 * @param type $sRequestURL
 * @return type
 */
function getParamsFromUrl($sRequestURL) 
{
    //? thi explode vado code remove kariyo che ene as get parameter ma gane mate
    
    //Add slash because if url is abc.com or abc.com/jaimin then its create issues
    $sRequestURL= $sRequestURL.'/'.DEVELOPERSTRING;
    
    //replace // to / into stringUrl
    $sRequestURL = $_SERVER['REQUEST_SCHEME'].'://'.str_replace("//","/",$sRequestURL);
    $sRequestURL = str_replace(getConfig('siteUrl'), '', $sRequestURL);

    $aParams = explode('/',$sRequestURL);
    
    //Array pop
    array_pop($aParams);
    //Array reverse
    $aRequestParams = array_reverse($aParams);
    //Array pop
    array_pop($aRequestParams);
    //Array reverse
    return array_reverse($aRequestParams);
}
function getRandomPassword() 
{
    $sRandomString    = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4);
    $sRandomString   .= substr(str_shuffle('0123456789'), 0, 2);

    $sRandomPassword = str_shuffle($sRandomString);
    return $sRandomPassword;
}

function roleHasPermissions($aRolePermissions,$permissionConstant)
{
    global $oAdmin;

        
    foreach($aRolePermissions as $aRolePermission)
    {
        if(in_array($permissionConstant, $aRolePermission))
        {
            return 1;
        }
    }
    return 0;
}