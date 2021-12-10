<?php
header('Access-Control-Allow-Origin: *');
ini_set('display_errors', 1); 
error_reporting(E_ALL);

// Read contents of JSON files as strings
$recentUploads = file_get_contents("../data/recent-uploads.json");
$profilesPlaylist = file_get_contents("../data/profiles-playlist.json");

// Encode both objects in array, encode into true JSON
$data = json_encode(array($recentUploads, $profilesPlaylist));

// Return encoded data
echo $data;
?>