<?php

namespace App\Clients;

/* Libraries */
use Aws\S3\Exception\S3MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;

/* Facades */
use Illuminate\Support\Facades\Log;

/**
 * Class AwsS3Client
 *
 * AWS S3 client, used for:
 * 1. Uploading / downloading files to / from s3 buckets.
 * 2. Uploading and chunk files.
 *
 * @package App\Clients
 */
class AwsS3Client
{
    /**
     * Upload a large file to s3 in chunks.
     *
     * @param string $fileName  - file name
     * @param string $filePath  - file path
     * @param string $directory - path of the destination folder
     *
     * @return bool
     *
     * @throws S3MultipartUploadException
     */
    public function storeWithChunking(string $fileName, string $filePath, string $directory): bool
    {
        try {
            // Instantiate stream
            $stream = new MultipartUploader(
                $this->client(),
                $filePath,
                [
                    'bucket' => env('AWS_BUCKET'),
                    'key'    => "{$directory}/{$fileName}"
                ]
            );

            // Upload file
            $result = $stream->upload();

            // Access outcome
            if ($result['@metadata']['statusCode'] === 200) {
                Log::info($result);
                return true;
            } else {
                Log::error($result);
                return false;
            }
        } catch (S3MultipartUploadException $exception) {
            Log::error("unexpected exception: ", [
                'exception'   => $exception->getMessage(),
                'stack_trace' => $exception->getTraceAsString()
            ]);

            // Throw exception
            throw $exception;
        }
    }

    /**
     * Instantiate S3Client.
     *
     * @return S3Client
     */
    private function client(): S3Client
    {
        return new S3Client([
            'version'     => 'latest',
            'region'      => env('AWS_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
    }

    /**
     * Fetch file from Bucket
     *
     * @param string $fileName  - file name
     *
     * @return bool
     *
     * @throws S3MultipartUploadException
     */
    public function fetchS3File(string $fileName)
    {
        $expiry = "+1440 minutes";

        $client = $this->client();

        $command = $client->getCommand('GetObject', [
            'Bucket' =>  env('AWS_BUCKET'),
            'Key'    => $fileName
        ]);

        $request = $client->createPresignedRequest($command, $expiry);

        return (string) $request->getUri();
    }
}
