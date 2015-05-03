<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: index.php");
	}
	include("../../connect/database.php");
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());
		$result=pg_query('SELECT c_id,numb,name,section,professor FROM DDL.Course');
		//=pg_execute($dbconn,"courses",array($_POST[semester].$_POST[year],$_POST[studentstart],$_POST[studentend],$_POST[facultystart],$_POST[facultyend]));
		$addall=pg_query('SELECT c_id FROM DDL.Course');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Add Courses</title>
		<script type="text/javascript" src="../../js/ajax.js"></script>
		<script type="text/javascript">
			function addcourse(course,action){
		if(action=="Wants"){
			var e = document.getElementById(course);
			var grade = e.options[e.selectedIndex].value;
			console.dir(grade);
		}
		var xmlHttp = xmlHttpObjCreate();
		if(!xmlHttp){
			alert("This browser doesn't support this action");
			return
		}

		xmlHttp.onload = function(){
			var response = xmlHttp.responseText;
			var isnert = document.getElementById('selected');
			console.dir(response);
			document.getElementById('selected').innerHTML = JSON.parse(response);
		}
		document.getElementById('selected').innerHTML = 'adding...';
		var reqURL = "addcoures.php?action="+action+"&course="+course;
	    xmlHttp.open("GET", reqURL, true);
	    xmlHttp.send();

	}
		function addall(){
		<? while($add=pg_fetch_array($addall,null,PGSQL_ASSOC)){
			echo "addcourse(\"$add[c_id]\",\"add\");";
			}

		?>
		}

		function removecourse(course,action){
	if(action=="Wants"){
		var e = document.getElementById(course);
		var grade = e.options[e.selectedIndex].value;
		console.dir(grade);
	}
	var xmlHttp = xmlHttpObjCreate();
	if(!xmlHttp){
		alert("This browser doesn't support this action");
		return
	}

	xmlHttp.onload = function(){
		var response = xmlHttp.responseText;
		var isnert = document.getElementById('selected');
		console.dir(response);
		document.getElementById('selected').innerHTML = JSON.parse(response);
	}
	document.getElementById('selected').innerHTML = 'adding...';
	var reqURL = "addcoures.php?action="+action+"&course="+course;
    xmlHttp.open("GET", reqURL, true);
    xmlHttp.send();

	}
		function removeall(){
			<? $addall=pg_query('SELECT c_id FROM DDL.Course');
			while($add=pg_fetch_array($addall,null,PGSQL_ASSOC)){
			echo "addcourse(\"$add[c_id]\",\"remove\");";
			}

		?>

		}

		</script>

	</head>
	<body>
		<button onclick="addall()">Add all</button> &nbsp<button onclick="removeall()">REMOVE</button><br>
		<?
			while( $basicinfo = pg_fetch_array($result, null, PGSQL_ASSOC)){
				$i=0;
				foreach( $basicinfo as $col_value ){
					if($i==0){
						$i++;
						continue;
					}
						echo "\t\t$col_value &nbsp\n";
					}
				echo "<button onclick=\"addcourse('$basicinfo[c_id]','add')\">ADD</button>&nbsp<button onclick=\"addcourse('$basicinfo[c_id]','remove')\">REMOVE</button>";
				echo "\t<br>\n";
			}
			?>

			<button onclick="window.location.href='createcourse.php'">Create a new course</button>
			<button onclick="window.location.href='index.php'">Finish</button>
		<div id="selected"></div>

	</body>
</html>