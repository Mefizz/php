<?php

declare(strict_types=1);

namespace App\Application\Service\FileUploader\S3;

interface S3Manager
{
    public function getTemporaryLink($fileName, string $timeOfAccess);
}