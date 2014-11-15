
        <?php
		error_reporting(-1);
        
          include('htconfig/dbConfig.php');
          include('includes/dbaccess.php');
       /*   $filename = "nhs_backup_" . date("Y-m-d H:m:s") . ".sql";
          system('mysqldump --user=root --password=tony --host=localhost nhs_inventory > /Downloads/$filename');
          set_time_limit(600);
           //system("mysqldump -h localhost -u root -ptony nhs_inventory > /usr/local/www/vhosts/YOURDOMAIN.CO.NZ/private/BACKUPFILENAME.sql");
          echo 'Backup successful'; 
      */
        ob_start();

        $username = $db['username'];
        $password = $db['password'];
        $hostname = $db['hostname'];
        $dbname = $db['database'];
		echo " <h1>UN --> $username</h1>";
		$username = 'root';
        $password = 'vikingso1';
        $hostname = 'localhost';
        $dbname = 'nhs_inventory';

// if mysqldump is on the system path you do not need to specify the full path
// simply use "mysqldump --add-drop-table ..." in this case
//        $command = "C:\\xampp\\mysql\\bin\\mysqldump --add-drop-table --host=$hostname
//    --user=$username ";
                $command = "mysqldump --add-drop-table --add-drop-database --host=$hostname --user=$username ";
  
        if ($password)
            $command.= "--password=" . $password . " ";
        $command.= $dbname;
		echo "<h1>Here1</h1>";
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	
			exec($command,$output,$returnVar);
			echo "<h1>Here2</h1>";
		
		} else {
			system($command);
			echo "<h1>Here3</h1>";
		}
		print_r($returnVar);
        $dump = ob_get_contents();
        ob_end_clean();

// send dump file to the output
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($dbname . "_" .
                        date("Y-m-d_H-i-s") . ".sql"));
        flush();
        echo $dump;
        exit();

        ?>
<h1>UN --> $username</h1>