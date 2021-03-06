<?php
//require_once('./includes/db_connect.php');
require_once('./includes/db_connect_web.php');

$airportLocations=[];
//$cursor=$airports->find();
$cursor = airports();
foreach($cursor as $key=>$value)
{
	$airportLocations[$value['airport']]=$value['loc'];
}

if(isset($_GET['lon']))
{
	$lon = floatval($_GET['lon']);
	$lat = floatval($_GET['lat']);
	$query = array(
		'origin'=>true,
		'loc'=>array(
			'$near'=>array($lon,$lat)));
	//$doc=$airports->findOne($query);
	$doc = nearestAirport($query);
	$airportCode=$doc['airport'];
}
else
{
	$airportCode=$_GET['airport'];
}
if($airportCode=='JFK'&&!isset($_GET['price']))
{
	echo file_get_contents('./includes/jfk.json');
}
else
{
	$query = array('Origin'=>$airportCode);
	if(isset($_GET['price']))
	{
		$query['JetBlue Package Price/Person']=array('$lt'=>floatval($_GET['price']));
	}
	//$cursor = $packages->find($query,array('Destination'=>1,'JetBlue Package Price/Person'=>1,'_id'=>0));
	//$fields=array('Destination'=>1,'JetBlue Package Price/Person'=>1,'_id'=>0);
	$fields=array('Destination'=>1,'JetBlue Package Price/Person'=>1,'_id'=>0);
	$cursor = packages($query,$fields);
	$destinations=[];
	$destinations['Origin']=$airportCode;
	foreach($cursor as $key=>$value)
	{
		if(!isset($destinations[$value['Destination']]))
			$destinations[$value['Destination']]=$value;
		else if(floatval($destinations[$value['Destination']]['JetBlue Package Price/Person'])>floatval($value['JetBlue Package Price/Person']))
			$destinations[$value['Destination']]=$value;
	}
	foreach($destinations as $key=>$value)
	{
		if($key!='Origin')
		{
			$destinations[$key]["loc"]=$airportLocations[$value['Destination']];
			$destinations[$key]['airport']=$destinations[$key]['Destination'];
			unset($destinations[$key]['Destination']);
			$destinations[$key]['price']=$destinations[$key]['JetBlue Package Price/Person'];
			unset($destinations[$key]['JetBlue Package Price/Person']);
		}
	}
	$destinationsList=[];
	foreach($destinations as $key=>$value)
	{
		array_push($destinationsList, $value);
	}
	echo json_encode($destinationsList);
}
?>