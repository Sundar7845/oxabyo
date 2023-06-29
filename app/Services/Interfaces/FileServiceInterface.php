<?php

namespace App\Services\Interfaces;

interface FileServiceInterface
{
    /**
     * Upload chunked file.
     *
     * @param string $fileName  - file name
     * @param string $filePath  - file path
     * @param string $directory - path of the destination folder
     *
     * @return bool
     */
    public function storeWithChunking(string $fileName, string $filePath, string $directory): bool;

    /**
     * Fetch file from Bucket
     *
     * @param string $fileName  - file name
     * @param string $filePath  - file path
     * @param string $directory - path of the destination folder
     *
     * @return 
     */
    public function fetchS3File(string $fileName);
}
