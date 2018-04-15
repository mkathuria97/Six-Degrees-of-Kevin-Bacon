<!--
Contains function of any common code that is shared between pages-->
<?php 
	//contains the top conetnt of the page including the MyMDb logo
	function topContent(){?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>My Movie Database (MyMDb)</title>
			<meta charset="utf-8" />
			<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" 
				type="image/png" rel="shortcut icon" />
			<!-- Link to CSS file  -->
			<link href="bacon.css" type="text/css" rel="stylesheet" />
		</head>
		
		<body>
			<div id="frame">
				<div id="banner">
					<a href="mymdb.php">
						<img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" 
						alt="banner logo" /></a>
					My Movie Database
				</div>
			<div id="main">
	<?php }

	//contains the bottom content of the page including the forms and the W3C validator
	//button links
	function forms(){?>
	<!-- form to search for every movie by a given actor -->
					<form action="search-all.php" method="get">
						<fieldset> 
							<legend>All movies</legend>
							<div>
								<input name="firstname" type="text" size="12" 
								placeholder="first name" autofocus="autofocus" /> 
								<input name="lastname" type="text" size="12" 
									placeholder="last name" /> 
								<input type="submit" value="go" />
							</div>
						</fieldset>
					</form>
	<!-- form to search for movies where a given actor was with Kevin Bacon -->
					<form action="search-kevin.php" method="get">
						<fieldset>
							<legend>Movies with Kevin Bacon</legend>
							<div>
								<input name="firstname" type="text" size="12" 
									placeholder="first name" /> 
								<input name="lastname" type="text" size="12" 
									placeholder="last name" /> 
								<input type="submit" value="go" />
							</div>
						</fieldset>
					</form>
				</div> <!-- end of #main div -->
			
				<div id="w3c">
					<a href="https://webster.cs.washington.edu/validate-html.php">
						<img src="https://webster.cs.washington.edu/images/w3c-html.png" 
						alt="Valid HTML5" /></a>
					<a href="https://webster.cs.washington.edu/validate-css.php">
						<img src="https://webster.cs.washington.edu/images/w3c-css.png" 
						alt="Valid CSS" /></a>
				</div>
			</div> <!-- end of #frame div -->
		</body>
	</html>
	<?php }
	
	//returns the actor id for the actor name provided by the user
	function mainContent($db, $firstname, $lastname){
		$firstnameAll = $firstname.'%';
		$firstnameAll = $db->quote($firstnameAll);
		$lastname = $db->quote($lastname);

		$actorIds = $db->query("SELECT a.id FROM actors a
								WHERE a.first_name LIKE $firstnameAll AND a.last_name = $lastname 
								ORDER BY a.film_count DESC, a.id ASC LIMIT 1");

		if($actorIds->rowcount()>0){
			$actorIdFirstRow = $actorIds->fetch(); 
			$actorId = $actorIdFirstRow["id"];
			$actorId = $db->quote($actorId);
			return $actorId;
		}
	}

	//outputs table for the movies 
	function tableOutput($movies){?>
			<tr>
				<th>#</th>
				<th>Title</th>
				<th>Year</th>
			</tr>
			<?php $count =0;
			 foreach($movies as $movie){ ?>
				<tr>
				<?php $count=$count+1 ?>
					<td><?= $count ?></td>
					<td><?= $movie["name"] ?></td>
					<td><?= $movie["year"] ?></td>
				</tr>
		<?php } 
	}
?>
