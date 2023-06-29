<?php

namespace App\Services;

/* Interfaces */
use App\Services\Interfaces\FileServiceInterface;

/* Clients */
use App\Clients\AwsS3Client;


class FileService implements FileServiceInterface
{

    /** @var AwsS3Client */
    private $awsS3Client;

    /**
     * FileService constructor.
     *
     * @param AwsS3Client              $awsS3Client
     */
    public function __construct(
        AwsS3Client $awsS3Client
    ) {
        $this->awsS3Client = $awsS3Client;
    }

    /**
     * Upload chunked file.
     *
     * @param string $fileName  - file name
     * @param string $filePath  - file path
     * @param string $directory - path of the destination folder
     *
     * @return bool
     */
    public function storeWithChunking(string $fileName, string $filePath, string $directory): bool
    {
        return !!$this->awsS3Client->storeWithChunking($fileName, $filePath, $directory);
    }

    /**
     * Fetch file from Bucket
     *
     * @param string $fileName  - file name
     * @param string $filePath  - file path
     * @param string $directory - path of the destination folder
     *
     * @return
     */
    public function fetchS3File(string $fileName)
    {
        return $this->awsS3Client->fetchS3File($fileName);
    }
}
