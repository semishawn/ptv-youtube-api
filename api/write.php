<?php
// General variables
$apiKey = "AIzaSyC9x_rqvKIsbac47mpjcEnPUZ6K2W6SMKc";
$channelId = "UC7PBoxHyuZp1EC2qzgLK71Q";



// Generate API call for last 100 uploads
$recentUploads = preg_replace('/\s/', "", "
	https://www.googleapis.com/youtube/v3/search?
	key=$apiKey
	&channelId=$channelId
	&part=snippet,id
	&order=date
	&maxResults=50
");

// Convert JSON file to database
$uploadsJSON = file_get_contents($recentUploads);
$uploadsArray = json_decode($uploadsJSON, true);

$uploadsNewArray = [];
foreach ($uploadsArray["items"] as $video) {
	$videoElement = new stdClass;
	$title = $video["snippet"]["title"];
	$id = $video["id"]["videoId"];
	$videoElement -> title = $title;
	$videoElement -> id = $id;
	array_push($uploadsNewArray, $videoElement);
}

$uploadsNewJSON = json_encode($uploadsNewArray);


// Generate API call for Parkland Profiles playlist
$playlistId = "PLcTnBmAWjzjRzM5g6vvFbd3Mle6WTMNgn";
$profilesPlaylist = preg_replace('/\s/', "", "
	https://www.googleapis.com/youtube/v3/playlistItems?
	&key=$apiKey
	&part=snippet,id
	&playlistId=$playlistId
");

// Convert JSON file to database
$playlistJSON = file_get_contents($profilesPlaylist);
$playlistArray = json_decode($playlistJSON, true);

$playlistNewArray = [];
foreach ($playlistArray["items"] as $video) {
	$videoElement = new stdClass;
	$title = $video["snippet"]["title"];
	$id = $video["snippet"]["resourceId"]["videoId"];
	$videoElement -> title = $title;
	$videoElement -> id = $id;
	array_push($playlistNewArray, $videoElement);
}

$playlistNewJSON = json_encode($playlistNewArray);



// Upload JSON data to database
$conn = pg_connect(getenv("DATABASE_URL"));

$uploadsQuery = "";
$playlistQuery = "";

foreach ($uploadsNewArray as $video) {
	$title = addslashes($video -> title);
	$id = addslashes($video -> id);
	$uploadsQuery .= "INSERT INTO recent_uploads (title, id) VALUES ('$title', '$id');";
}

foreach ($playlistNewArray as $video) {
	$title = addslashes($video -> title);
	$id = addslashes($video -> id);
	$playlistQuery .= "INSERT INTO profiles_playlist (title, id) VALUES ('$title', '$id');";
}

pg_query($conn, "
	TRUNCATE TABLE recent_uploads;
	TRUNCATE TABLE profiles_playlist;
	$uploadsQuery
	$playlistQuery
");
?>