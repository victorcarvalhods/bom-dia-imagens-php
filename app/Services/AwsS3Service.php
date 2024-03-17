<?php

namespace App\Services;

use Aws\S3\S3Client;


class AwsS3Service
{
    protected static $client;
    protected static $bucket;
    protected static $bucketFolder;

    public static function initialize()
    {
        self::$client = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        self::$bucket = env('AWS_BUCKET');
        self::$bucketFolder = env('AWS_BUCKET_FOLDER');
    }

    public static function uploadImage($image)
    {
        if (!self::$client) {
            self::initialize();
        }

        $imageName = $image->getFilename();

        $resultURL = self::$client->putObject([
            'Bucket' => self::$bucket,
            'Key' => self::$bucketFolder . $imageName,
            'Body' => $image,
            'ACL' => 'public-read',
        ]);

        return $resultURL['ObjectURL'];

    }

}