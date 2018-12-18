<?php
	$flock 		= "/usr/bin/flock -n /tmp/mmo_cache_clean.lockfile";
	$command 	= "/home/gamingcory/www/modules/ps_mmoconnector/cache_clean";
	$log 		= "/home/gamingcory/www/modules/ps_mmoconnector/logs/cache_clean.log";
	
	passthru("$flock $command >> $log");
?>