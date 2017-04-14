<?php
 /**
  * StepIn Solutions venture, an MVC framework index file, landing page for the project
  * 
  *
  * @package stepone 
  */

  ob_start(); 
  require("../../inc/bootstrap.inc.php"); 
  $oRouter = eval("return new ".getConfig('routerClassName')."();");
  $aRouterSlug = $oRouter->mapSlug();
  if(count($aRouterSlug))
  {
      
    $sModule = $aRouterSlug['module'];
    $sAction = $aRouterSlug['action'];
  }
  
  $sLayoutPath = '';
  $getObject = isset($_GET['get_all']) && (strlen($_GET['get_all'])) ? explode("&",$_GET['get_all']): array();
  unset($_GET['get_all']);

  if(count($getObject))
  {
    foreach($getObject as $sGet)
    {
          $aGet = explode("=",$sGet);
          $_GET[$aGet[0]] = $aGet[1];
    }
  }
  if(file_exists(getconfig('rootDir')."/controllers/".$sAppName."/modules/".$sModule."/controller.php"))
  {   
       require(getconfig('rootDir')."/controllers/".$sAppName."/modules/".$sModule."/controller.php");
        
	$oMainController = eval("return new ".$sModule."Controller();");
	if(method_exists($oMainController,'call'.$sAction))
	{
            if($oMainController->aLayout[$sAction])
            {               
                require(getconfig('rootDir')."/controllers/".$sAppName."/templates/".$sLayoutPath.$oMainController->aLayout[$sAction].".layout.php");
            }
            else
            {
                eval('$oMainController->call'.$sAction.'();');
            }
                
	}
  }
  else 
  {   
      redirect(getConfig('siteUrl').'/users/login');
  }