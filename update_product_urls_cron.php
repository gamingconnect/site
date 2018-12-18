<?php
	$flock 		= "/usr/bin/flock -n /tmp/mmo_update_product.lockfile";
	$command 	= "/usr/bin/curl http://www.gamingconnect.fr/modules/ps_mmoconnector/updateProductURLsCron.php";
	$log 		= "/home/gamingcory/www/modules/ps_mmoconnector/logs/update_product_urls_cron.log";
	
	passthru("$flock $command >> $log");
?>