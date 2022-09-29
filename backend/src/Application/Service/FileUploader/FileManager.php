<?php

namespace App\Application\Service\FileUploader;

interface FileManager
{
    public function upload($file, string $folderName, string $fileName);

    public function delete(string $keyName);

    public function get(string $fileName);
}