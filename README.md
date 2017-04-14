<h3>Following step to create virtual host and framework setup on local:</h3>

<b> Step - 1 : Create virtual host</b>

              1.1 create virtual host on front, admin and api application.
                  For example - front.demo , admin.demo , api.demo

              1.2 Set file path in front.demo
                  local machine path/<project_name>/web/<application name>/index.php */                               
    
<b>Step - 2 : Set configuration in INC folder (inc/config.inc.php).</b>

              'rootDir' => '<local machine path to www>/<project_name>'
              'uploadFilePath' => '<local machine path to www>/<project_name>'/web/media/uploads, */

              /* To get, set or update media file as following. */ 
              'mediaUrl'=>'http://media.<project_name>',
              'mediaUrl'=>'http://media.demo',

              /* For api call of project */
              'apiUrl'=>'http://api.<project_name>',
              'apiUrl'=>'http://api.demo',

              /* To call home module and home action */
              'homeModule'=>'home',
              'homeAction'=>'index',

              /* Local database configuration on <project path>/inc/config.inc file. */

              'dbHost'=>'<hostname>',
              'dbUser'=>'<username>',
              'dbPassword'=>'<password>',
              'dbName'=>'<dbname>',
