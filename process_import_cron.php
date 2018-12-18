<?php
	$flock 		= "/usr/bin/flock -n /tmp/mmo_process_import.lockfile";
	$command 	= "/usr/bin/curl http://www.gamingconnect.fr/modules/ps_mmoconnector/processImportCron.php";
	$log 		= "/home/gamingcory/www/modules/ps_mmoconnector/logs/process_import_cron.log ";
	
	passthru("$flock $command >> $log");
?>