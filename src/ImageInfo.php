<?php

namespace zzdjk6\SilverStripe\ImageLinkUpgrade;

class ImageInfo
{
    /**
     * @var string
     */
    private $ID;

    /**
     * @var string
     */
    private $URL;

    /**
     * @var string
     */
    private $Filename;

    /**
     * @return string
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param string $ID
     * @return ImageInfo
     */
    public function setID($ID)
    {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return string
     */
    public function getURL()
    {
        return $this->URL;
    }

    /**
     * @param string $URL
     * @return ImageInfo
     */
    public function setURL($URL)
    {
        $this->URL = $URL;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->Filename;
    }

    /**
     * @param string $Filename
     * @return ImageInfo
     */
    public function setFilename($Filename)
    {
        $this->Filename = $Filename;
        return $this;
    }
}