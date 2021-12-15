<?php
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 1); 
error_reporting(E_ALL);

// Connect to database
$conn = pg_connect(getenv('DATABASE_URL'));

// Read contents of JSON files as strings
$recentUploads = pg_query($conn, "SELECT * FROM recent_uploads");
$uploadsArray = pg_fetch_all($recentUploads);

$profilesPlaylist = pg_query($conn, "SELECT * FROM profiles_playlist");
$profilesArray = pg_fetch_all($recentUploads);

// Store both objects in array, encode into true JSON
$data = json_encode(array($uploadsArray, $profilesArray));

// Return encoded data
echo $data;
?>