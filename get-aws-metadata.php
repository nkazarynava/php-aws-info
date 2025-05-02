<?php
function getAwsMetadata($path) {
    $url = "http://169.254.169.254/latest/meta-data/" . $path;
    $opts = ['http' => ['timeout' => 1]];
    return @file_get_contents($url, false, stream_context_create($opts)) ?: 'Unavailable';
}

function getRegionFromAz($az) {
    return substr($az, 0, -1); // Strip the last character
}