<?php
error_reporting(0);
$db_config_path = '../application/config/database.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST) {
    
	require_once('taskCoreClass.php');
	require_once('includes/databaseLibrary.php');

	$core = new Core();
	$database = new Database();

	if($core->checkEmpty($_POST) == true)
	{
		if($database->create_database($_POST) == false)
		{
			$message = $core->show_message('error',"The database could not be created, make sure your the host, username, password, database name is correct.");
		} 
		else if ($database->create_tables($_POST) == false)
		{
			$message = $core->show_message('error',"The database could not be created, make sure your the host, username, password, database name is correct.");
		} 
		else if ($core->checkFile() == false)
		{
			$message = $core->show_message('error',"File application/config/database.php is Empty");
		}
		else if ($core->write_config($_POST) == false)
		{
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
		}

		if(!isset($message)) {
            $urlWb = $core->getAllData($_POST['url']);
            header( 'Location: ' . $urlWb ) ;
		}
	}
	else {
		$message = $core->show_message('error','The host, username, password, database name, and URL are required.');
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Install | Welcome to Installer CodeIginter by Abed Putra</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
    <div class="container">
        <div class="col-md-4 col-md-offset-4">
            <h1>Installer</h1>
            <hr>
            <?php 
            if(is_writable($db_config_path))
            {
            ?>
                <?php if(isset($message)) {
                echo '
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                ' . $message . '
                </div>';
                }?>
                
                <form id="install_form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="hostname">Hostname</label>
                    <input type="text" id="hostname" value="localhost" class="form-control" name="hostname" />
                    <p class="help-block">Your Hostname.</p>
                </div>
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" class="form-control" name="username" />
                    <p class="help-block">Your Username.</p>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" name="password" />
                    <p class="help-block">Your Password.</p>
                </div>
                
                <div class="form-group">
                    <label for="database">Database Name</label>
                    <input type="text" id="database" class="form-control" name="database" />
                    <p class="help-block">Your Database Name.</p>
                </div>
                
                <div class="form-group">
                    <label for="database">URL</label>
                    <input type="text" id="url" class="form-control" name="url" placeholder="http://abedputra.com/" />
                    <p class="help-block">Your URL Website.</p>
                </div>
                
                <div class="form-group">
                    <label for="database">CodeIgniter Version</label>
                    <select class="form-control" id="template" name="template" />
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                    <p class="help-block">Your CodeIgniter Version.</p>
                </div>
                
                <input type="submit" value="Install" class="btn btn-primary btn-block" id="submit" />
                </form>
        
                <?php 
                } 
                else {
                ?>
                <p class="alert alert-danger">
                    Please make the application/config/database.php file writable.<br>
                    <strong>Example</strong>:<br />
                    <code>chmod 777 application/config/database.php</code>
                    </p>
                <?php 
                } 
                ?>
            </div>
            
            <footer>
                <div class="col-md-12" style="text-align:center;margin-bottom:20px">
                    <hr>
                    Copyright - 2017 | <a href="http://abedputra.com">abedputra.com</a>
                </div>
            </footer>
      </div>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>
