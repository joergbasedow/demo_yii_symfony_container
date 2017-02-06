<?php

class UserService
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @param array $user
     *
     * @return string
     */
    public function getPhotoForUser(array $user)
    {
        return Yii::app()->basePath.$this->directory.$user['username'].'.jpg';
    }
}
