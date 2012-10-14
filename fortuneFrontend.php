<?php
	require 'configuration.php';
	$mongo_db=$MONGO_URI;
	$m= new Mongo($mongo_db);

    $url = parse_url($mongo_db);

    $db_name = preg_replace('/\/(.*)/', '$1', $url['path']);

    // use the database we connected to
    $db = $m->selectDB($db_name);

    $collection = $db->selectCollection("Fortunes");

    $results = $collection->find();
    
    $all_fortunes = array();
    /*while($results->hasNext())
    {
	array_push($all_fortunes, $results->next());
    }*/

    foreach($results as $doc)
    {
    if($doc["fortune"] != FALSE)
    {
	array_push($all_fortunes, $doc["fortune"]);
	}
}
	$fortune_to_get = rand(0, count($all_fortunes)-1);
	$fortune = $all_fortunes[$fortune_to_get];
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css" />
	<title>Unfortunate Cookie</title>
</head>

<body>
<div class="navbar navbar-inverse">
     <div class="navbar-inner">
     	  <a class="brand">Unfortunate cookie</a>
	  </div>
</div>
	<div class="container">
	<div class="hero-unit">
	     <center><h2><span class="text-error"> <?php echo $fortune ?></span></h2></center>
	     <center><a href="http://jmaltz.vverma.net/ominousFortune/fortuneFrontend.php">
	     	<button class="btn btn-success">That's weak sauce, I want more</button>
		</a></center>
	</div>
	</div>
</body>