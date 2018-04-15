
<!-- The page shows search results for all films by a given actor-->
<?php 
	//gets the first name of the actor provided by the user
	$firstname = $_GET["firstname"];
	//gets the last name of the actor provied by the user
	$lastname = $_GET["lastname"];

	//PDO library to connect to the imdb database
  	$db = new PDO("mysql:dbname=imdb; host=localhost", "mkathu", "LurNxTWIrj");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	
  	include("common.php");
	topContent();
  	$actorId = mainContent($db, $firstname, $lastname);
  	
  	//checks whether the actor name provided by the user exists or not in the imdb database
  	//if yes, outputs a table of all film of the given actor
  	//if not, prints an error message
	if($actorId != ''){
		$movies = $db->query("SELECT m.name, m.year FROM movies m 
							JOIN roles r ON r.movie_id = m.id
							JOIN actors a ON r.actor_id = a.id
							WHERE a.id = $actorId ORDER BY m.year DESC, m.name ASC;");?>
		
		<h1> Results for <?= $firstname." ".$lastname ?></h1>
		<table>
			<caption>All Films</caption>
			<?php tableOutput($movies); ?>
		</table>
	<?php } 
	
	else{
		print "Actor $firstname $lastname not found.";
	}
	forms();
?>

