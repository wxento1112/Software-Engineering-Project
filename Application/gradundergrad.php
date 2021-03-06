<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "applicant"){
		header("Location: ../index.php");
	}	
	//if data has been submitted
	if(isset($_POST['submit'])){

		//if(date("y-m-d") <= "2015-05-01"）{

		include("../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());
		if(strcmp($_SESSION[grad],"ta")==0){
			pg_prepare($dbconn, 'grad', 'INSERT INTO DDL.is_a_grad values($1,$2,$3)');
			$result = pg_execute($dbconn, 'grad', array($_SESSION['username'],$_POST[gradpro],$_POST[advisor])); 
		}
		elseif(strcmp($_SESSION[grad],"pla")==0){
			pg_prepare($dbconn, 'ungrad', 'INSERT INTO DDL.is_an_undergrad values($1,$2,$3)') or die('Could not connect: ' . pg_last_error());;
			$result = pg_execute($dbconn, 'ungrad', array($_SESSION['username'],$_POST[program],$_POST[year]))or die('Could not connect: ' . pg_last_error());; 
		}
		if($result==false){
			$_SESSION[insert]=false;
		}
			else
				header("Location: courses.php");
	//	}

		// else{
		// 	$_SESSION['insert']=false;
		// 	header("Location: home.php");	
		// }
	}	

?>


<!DOCTYPE html>
<html>
	<!--ADD ANY USEFUL TIPS, otherwise ... DO NOT FUCK WITH THE COMMENTS. please and thank you.-->
<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">	
	<script src="../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="../js/gradundergrad.js"></script>
</head>
<body>
	<form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
	
	<!-- Header/Footer -->
		
		<!--<div class="header shadowheader">			
			<h1>Step 3: <? if(strcmp($_SESSION[grad],"ta")==0) echo "Graduate"; else echo "Undergraduate";?></h1>		
		</div>-->	
		<div class="header shadowheader">			
			<h1>Step 3: Graduate/Undergraduate</h1>		
		</div>
		
		<div class="footer shadowfooter">			
			<h4>Copyright &copy; Group G - Computer Science Department</h4>		
		</div>		
	
	<!-- Home/Logout -->
	
		<div class="centerlogout">
			<br>
			<!--<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../phpSQL/index.php'">-->
			<input class="logout" type="submit" name="submit" value="Logout" onclick="window.location.href ='../phpSQL/logout.php'">
		</div>
			
	<!-- Graduate/Undergraduate -->
			
		<div class="centerplsgrad">
			<p>
				<label class="floatleft">What type of student are you?</label>
				<select class="floatright" id="type" name="type">
					<option value="type">Select</option>
					<option value="graduate">Graduate</option>
					<option value="undergraduate">Undergraduate</option>
				</select>
			</p>
				<br>
				
	<!-- Undergraduate -->			

			<p id="years" style="display: none">
				<label class="floatleft">What level of student are you?</label>
				<select class="floatright" id="year" name="year">
					<option value="year">Select</option>
					<option value="freshmen">Freshmen</option>
					<option value="sophomore">Sophomore</option>
					<option value="Junior">Junior</option>
					<option value="Senior">Senior</option>
				</select>
				<br>
			</p>
				
			<p id="degrees" style="display: none">
				<label class="floatleft">What degree program are you in?</label>
				<select class="floatright" id="program" name="program">
					<option value="program">Select</option>
					<option value="bacs">Bachelor of Arts in Computer Science</option>
					<option value="bscs">Bachelor of Science in Computer Science</option>
					<option value="bsit">Bachelor of Science in Information Technology</option>
					<option value="bscsit">Dual BS CS and BS IT</option>
					<option value="bsitmba">Dual BS IT and MBA</option>
					<option value="fastrack">Fast-Track BS and MS in Computer Science</option>
				</select>
			</p>
			
	<!-- Graduate -->
			
			<p id="programs" style="display: none">
				<label class="floatleft">What degree program are you in?</label>
				<select class="floatright" id="gradpro" name="gradpro">
					<option value="gradpro">Select</option>
					<option value="MS">MS</option>
					<option value="PHD">PhD</option>
				</select>
			</p>
				<br>
			<p id="advisors" style="display: none">
				<label class="floatleft">Select Advisor:</label>
				<select class="floatright" id="advisor" name="advisor">
					<option value="advisor">Select</option>
					<option value="yin">Yi Shang</option>
					<option value="jodie">Jodie Lenser</option>
				</select>
			</p>
		</div>
			<br>
			
	<!-- Next Page -->

		<div class="centerbuttonsgrad">
			<p id="click" style="display: none">
				<input type="submit" name="submit" value="Proceed to the next step">
			</p>			
		</div>		
</body>
</html>