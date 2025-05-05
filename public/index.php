<?php
require_once __DIR__ . '/../get-aws-metadata.php';

// Step 1: Request metadata token using PUT
$token_url = 'http://169.254.169.254/latest/api/token';
$ch = curl_init($token_url);

// Set the cURL options for requesting the metadata token
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Set method to PUT
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-aws-ec2-metadata-token-ttl-seconds: 21600'  // 6 hours TTL for the token
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request and get the response (the token)
$token = curl_exec($ch);
curl_close($ch);

// Step 2: Use the token to request metadata (e.g., availability zone)
if ($token) {
    $metadata_url = 'http://169.254.169.254/latest/meta-data/placement/availability-zone';

    // Initialize cURL to request the metadata with the token
    $ch = curl_init($metadata_url);

    // Set cURL options including the token in the header
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-aws-ec2-metadata-token: $token"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request to fetch the availability zone
    $az = curl_exec($ch);
    curl_close($ch);

    // Derive region from availability zone (remove last character)
    $region = substr($az, 0, -1);

    // Output the region and availability zone as JSON
    echo json_encode([
        'region' => $region,
        'availability_zone' => $az,
    ]);
} else {
    echo json_encode([
        'error' => 'Failed to retrieve metadata token',
    ]);
}