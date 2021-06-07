<?php

namespace App\Services;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function upload($targetDirectory, UploadedFile $file)
    {
        if (!file_exists($targetDirectory) && !is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0775, true);
        }

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug(
            $originalFilename
        );
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($targetDirectory, $fileName);
        } catch (FileException $e) {
            throw new Exception($e->getMessage());
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
