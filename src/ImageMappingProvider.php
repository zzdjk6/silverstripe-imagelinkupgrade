<?php

namespace zzdjk6\SilverStripe\ImageLinkUpgrade;

use SilverStripe\Assets\Image;

class ImageMappingProvider
{
    /**
     * Return the mapping from filename to ImageInfo
     *
     * @return array
     */
    public function getUserImageMapping()
    {
        $images = Image::get();
        $mapping = [];

        foreach ($images as $image) {
            /* @var Image $image */
            $filename = $image->Filename;
            if (!strpos($filename, 'assets/')) {
                $filename = 'assets/' . $filename;
            }

            $mapping[$filename] = (new ImageInfo)
                ->setID($image->ID)
                ->setFilename($image->Filename)
                ->setURL($image->getURL());
        }
        return $mapping;
    }
}