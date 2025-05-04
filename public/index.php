<?php
require_once __DIR__ . '/../get-aws-metadata.php';

header('Content-Type: application/json');
echo json_encode(getAwsMetadataFromSdk());