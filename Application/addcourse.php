<?php
	sleep(3);
	session_start();
	//connect to database
	include("../connect/database.php");
	//$_SESSION[username]="app4";
	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());
	$result=false;
	if(strcmp($_GET[action],"Taught")==0){
		pg_prepare($dbconn,"Taught",'INSERT INTO DDL.has_taught VALUES ($1,$2)');
		$result = pg_execute($dbconn,"Taught",array($_SESSION[username],$_GET[course]));
	}
	elseif(strcmp($_GET[action],"Teaching")==0){
		pg_prepare($dbconn,"Teaching",'INSERT INTO DDL.are_teaching VALUES ($1,$2)');
		$result = pg_execute($dbconn,"Teaching",array($_SESSION[username],$_GET[course]));
	}
	elseif(strcmp($_GET[action],"Wants")==0){
		pg_prepare($dbconn,"Wants",'INSERT INTO DDL.wants_to_teach VALUES ($1,$2,$3)');
		$result = pg_execute($dbconn,"Wants",array($_SESSION[username], $_GET[grade],$_GET[course]));
	}
	if(!$result)
		if (strpos(pg_last_error(), 'exists') !== FALSE)
			echo 0;
		else echo 1;
	else
		echo 0;
	pg_close($dbconn);
?>