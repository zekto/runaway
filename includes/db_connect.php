<?php
// Connect to a new mongo thingy.
$mongo = new MongoClient("mongodb://localhost");

if ($mongo) {	// If happy...
   $db = $mongo -> Jetblue;
   $users = $db-> flyingHotels;
} else {
   echo json_encode(['status' => 'mongo connection error']);
   exit; 
}
?> 