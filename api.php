<?php

// General variables
$apiKey = "AIzaSyC9x_rqvKIsbac47mpjcEnPUZ6K2W6SMKc";
$channelId = "UC7PBoxHyuZp1EC2qzgLK71Q";

// Generate API call for last 100 uploads
$maxResults = "100";
$recentUploads = preg_replace('/\s/', '', "
	https://www.googleapis.com/youtube/v3/search?
	key=$apiKey
	&channelId=$channelId
	&part=snippet,id
	&order=date
	&maxResults=$maxResults
");

// Copy API JSON data to file
$uploadsJSON = file_get_contents($recentUploads);
$uploadsFile = fopen('recent-uploads.json', 'w');
fwrite($uploadsFile, $uploadsJSON);
fclose($uploadsFile);



// Generate API call for Parkland Profiles playlist
$playlistId = "PLcTnBmAWjzjRzM5g6vvFbd3Mle6WTMNgn";
$profilesPlaylist = preg_replace('/\s/', '', "
	https://www.googleapis.com/youtube/v3/playlistItems?
	&key=$apiKey
	&part=snippet,id
	&playlistId=$playlistId
");

// Copy API JSON data to file
$playlistJSON = file_get_contents($profilesPlaylist);
$playlistFile = fopen('profiles-playlist.json', 'w');
fwrite($playlistFile, $playlistJSON);
fclose($playlistFile);

?>