<?php
/**
 * This file is part of a Lyssal project.
 *
 * @copyright Rémi Leclerc
 * @author Rémi Leclerc
 */
namespace Lyssal\Entity\Traits;

/**
 * This trait helps to manage an upload file in an entity.
 * You have to create in your entity a property name $uploadedFile.
 */
trait UploadedFileTrait
{
    /**
     * @var bool If the file has been uploaded (generally saved in the server)
     */
    protected $fileUploadIsSuccess = false;


    /**
     * The directory where the file will be saved
     *
     * @return string The file upload directory
     */
    abstract public function getUploadedFileDirectory();

    /**
     * Get the uploaded file.
     *
     * @return mixed The uploaded file
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * Set the uploaded file.
     *
     * @param mixed|null $uploadedFile The uploaded file
     * @return object This
     */
    public function setUploadedFile($uploadedFile = null)
    {
        $this->uploadedFile = $uploadedFile;
        if (null !== $this->uploadedFile && $this->uploadedFileIsValid()) {
            $this->uploadFile();
        }

        return $this;
    }

    /**
     * Return if the uploaded file is valid.
     *
     * @return bool If the file is valid
     */
    public function uploadedFileIsValid()
    {
        return (null !== $this->uploadedFile);
    }

    /**
     * Return if the file has been uploaded with success.
     *
     * @return bool If the file has been uploaded with success
     */
    public function fileUploadIsSuccess()
    {
        return $this->fileUploadIsSuccess;
    }

    /**
     * Upload the file.
     */
    public function uploadFile()
    {
        // Your logic here
    }
}
