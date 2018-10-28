<?php

namespace zzdjk6\SilverStripe\ImageLinkUpgrade;

class MatchPair
{
    /**
     * @var string
     */
    private $oldSrc;

    /**
     * @var string
     */
    private $newSrc;

    public function isSrcDifferent()
    {
        return $this->oldSrc != $this->newSrc;
    }

    /**
     * @return string
     */
    public function getOldSrc()
    {
        return $this->oldSrc;
    }

    /**
     * @param string $oldSrc
     * @return MatchPair
     */
    public function setOldSrc($oldSrc)
    {
        $this->oldSrc = trim($oldSrc);
        return $this;
    }

    /**
     * @return string
     */
    public function getNewSrc()
    {
        return $this->newSrc;
    }

    /**
     * @param string $newSrc
     * @return MatchPair
     */
    public function setNewSrc($newSrc)
    {
        $this->newSrc = trim($newSrc);
        return $this;
    }
}