<?php
/**
 * StepIn Solutions venture, an MVC framework
 * Application configuration  file
 *  
 * @package stepOne 
 */

     /* Constants */
     
//     define("SITE_URL","http://".$_SERVER["HTTP_HOST"]);
//     define("ROOT_DIR","C:/wamp/www/stepone");
//     define("LANGUAGE","en");
//     define("HOME_MODULE","home");
//     define("HOME_ACTION","index");
                   $aConfig[$sAppName] = array(
                                                    'siteUrl' => "http://".$_SERVER["HTTP_HOST"],
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
                                                    'nPerPageRecords'=>'',
                                                    'checkSlug'=> false
                                                    
                                                );

     /* Database Credentials */
//     $sDbHost = "";
//     $sDbUser = "";
//     $sDbPassword = "";
//     $sDbName = "";
//     $nPagerLength = "";
//     $nPerPageRecords = "";
