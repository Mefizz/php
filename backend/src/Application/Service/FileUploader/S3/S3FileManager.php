<?php
declare(strict_types=1);

namespace App\Application\Service\FileUploader\S3;

use App\Application\Service\FileUploader\FileManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Finder\SplFileInfo;
use Ramsey\Uuid\Uuid;
use Aws\S3\S3Client;
use AWS\Result;

class S3FileManager implements FileManager, S3Manager
{
    public S3Client $client;

    private string $bucket;

    public function __construct(string $key, string $secret, string $region, string $bucket)
    {
         $this->client = new S3Client([
            'region' => $region,
            'version' => 'latest',
            'credentials' => [
                'key' => $key,
                'secret' => $secret,
            ]
        ]);
         $this->bucket = $bucket;
    }

    /**
     * @param File | SplFileInfo $file
     * @param string $folderName
     * @param string $fileName
     * @return string
     * @throws \Exception
     */
    public function upload($file, string $folderName = '', string $fileName = '')
    {
        $fileName = $folderName . ($fileName ?: Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension());
          $this->client->putObject([
            'Bucket' => $this->bucket,
            'Key' => $fileName,
            'SourceFile' => $file->getPathname(),
        ]);
        return $fileName;
    }

    public function get(string $fileName) : string
    {
        return $this->client->getObjectUrl($this->bucket, $fileName);

    }

    public function delete(string $keyName) : Result
    {

        return $this->client->deleteObject([
            'Bucket' => $this->bucket,
            'Key'    => $keyName
        ]);
    }

    public function createTemporaryLink(string $timeOfAccess = '+1 hour')
    {
        $cmd = $this->client->getCommand('PutObject', [
            'Bucket' => $this->bucket,
            'Key' => Uuid::uuid4(),
//            'ACL' => 'public-read'
        ]);
        $request =  $this->client->createPresignedRequest($cmd, $timeOfAccess);
        return (string) $request->getUri();
    }

    public function getTemporaryLink($fileName, string $timeOfAccess = '+1 hour') : string
    {
        $objectData = $this->client->getCommand('GetObject', ['Bucket' => $this->bucket, 'Key' => $fileName]);
        return (string) $this->client->createPresignedRequest($objectData, $timeOfAccess)->getUri();
    }


}