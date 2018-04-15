<!--
The page shows search results for all films with the given actor and Kevin Bacon-->
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
  	//if yes, outputs the table of movies where the given actor was with Kevin Bacon
  	//if not, prints an error message
	if($actorId != ''){
	$movies= $db->query("SELECT m.name, m.year FROM movies m
						JOIN roles r1 ON m.id = r1.movie_id
						JOIN actors a1 ON a1.id = r1.actor_id
						JOIN roles r2 ON m.id = r2.movie_id
						JOIN actors a2 ON a2.id = r2.actor_id
						WHERE a1.first_name ='Kevin' AND a1.last_name= 'Bacon' 
						AND a2.id=$actorId ORDER BY m.year DESC, m.name ASC;");
		//checks whether the given actor was in any movie with Kevin Bacon
		if($movies->rowcount() > 0){?>
			<h1> Results for <?= $firstname." ".$lastname ?></h1> 
			<table>
				<caption>Films with <?=$firstname." ".$lastname ?> and Kevin Bacon</caption>
				<?php tableOutput($movies); ?>
			</table>
		<?php }
		else{
			print("$firstname $lastname wasn't in any films with Kevin Bacon.");
		}
	}

	else{
		print "Actor $firstname $lastname not found." ;
	}
	forms();
?>
