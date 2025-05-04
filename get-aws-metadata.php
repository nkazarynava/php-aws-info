<?php
require 'vendor/autoload.php';

use Aws\Ec2Metadata\Ec2MetadataClient;

function getAwsMetadataFromSdk() {
    try {
        $client = new Ec2MetadataClient();
        $az = $client->getAvailabilityZone();
        $region = substr($az, 0, -1);
        return [
            'region' => $region,
            'availability_zone' => $az
        ];
    } catch (Exception $e) {
        return [
            'error' => 'Could not fetch metadata: ' . $e->getMessage()
        ];
    }
}