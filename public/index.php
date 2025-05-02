<?php
require_once __DIR__ . '/../get-aws-metadata.php';

$az = getAwsMetadata('placement/availability-zone');
$region = getRegionFromAz($az);

header('Content-Type: application/json');
echo json_encode([
    'region' => $region,
    'availability_zone' => $az
]);