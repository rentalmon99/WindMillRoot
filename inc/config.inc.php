<?php
/**
 * StepIn Solutions venture, an MVC framework
 * configuration  file
 *
 * @package stepOne 
 */

     /* Constants */
     
//     define("SITE_URL","http://".$_SERVER["HTTP_HOST"]);
//     define("ROOT_DIR","C:/wamp/www/Addmordel");
//     define("LANGUAGE","en");
//     define("HOME_MODULE","home");
//     define("HOME_ACTION","index");

                    $aConfig['common'] = array(
						'siteUrl' => "http://".$_SERVER["HTTP_HOST"],
						'rootDir' => 'C:/wamp/www/ctrl',
                                                'mediaUrl' => "http://media.ctrl.si",
						'language'=>'en',
                                                'homeModule'=>'home',
                                                'homeAction'=>'index',
                                                'loginModule'=>'users',
                                                'loginAction'=>'login',
                                                'dbHost'=>'localhost',
                                                'dbUser'=>'root',
                                                'dbPassword'=>'',
                                                'dbName'=>'ctrllocal',
                                                'nPagerLength'=>'',
                                                'routerClassName'=>'routers',
                                                'nPerPageRecords'=>'',
                                                'sSessionName'=>'userSession',
                                                'uploadFilePath'=>'C:/wamp/www/ctrl/web/media',
                                                'createFolderPath'=>'C:/wamp/www/ctrl/web/media/docs/',
                                                'dtDateTime'=>'Y-m-d H:i:s',
                                              );

     /* Database Credentials */
//     $sDbHost = "";
//     $sDbUser = "";
//     $sDbPassword = "";
//     $sDbName = "";
//     $nPagerLength = "";
//     $nPerPageRecords = "";
     
