<?php
	require 'configuration.php';
	require 'twilio-php/Services/Twilio.php';
	$text = trim(strtolower($_REQUEST["Body"]));

	

	if($text === "fortune")
	{
	$account_id = $TWILIO_ACCOUNT_SID;
	$token = $TWILIO_AUTH_TOKEN;

	$client = new Services_Twilio($account_id, $token);

	$mongo_db= $MONGO_URI;
	$m= new Mongo($mongo_db);

    $url = parse_url($mongo_db);

    $db_name = preg_replace('/\/(.*)/', '$1', $url['path']);

    // use the database we connected to
    $db = $m->selectDB($db_name);

    $collection = $db->selectCollection("Fortunes");

    $results = $collection->find();
    

    var_dump($results->count());
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
	var_dump($doc);
	}
}
	$fortune_to_get = rand(0, count($all_fortunes)-1);

	$message = $client->account->sms_messages->create(
	"+14159686840",
	$_REQUEST["From"],
	$all_fortunes[$fortune_to_get]);
}
	
	
?>
