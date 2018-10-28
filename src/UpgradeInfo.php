<?php

namespace zzdjk6\SilverStripe\ImageLinkUpgrade;

class UpgradeInfo
{
    /**
     * @var string
     */
    private $ClassName;

    /**
     * @var string
     */
    private $ID;

    /**
     * @var string
     */
    private $Field;

    /**
     * @var MatchPair[]
     */
    private $MatchPairs;

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->ClassName;
    }

    /**
     * @param string $ClassName
     * @return UpgradeInfo
     */
    public function setClassName($ClassName)
    {
        $this->ClassName = $ClassName;
        return $this;
    }

    /**
     * @return string
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param string $ID
     * @return UpgradeInfo
     */
    public function setID($ID)
    {
        $this->ID = $ID;
        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->Field;
    }

    /**
     * @param string $Field
     * @return UpgradeInfo
     */
    public function setField($Field)
    {
        $this->Field = $Field;
        return $this;
    }

    /**
     * @return MatchPair[]
     */
    public function getMatchPairs()
    {
        return $this->MatchPairs;
    }

    /**
     * @param MatchPair[] $MatchPairs
     * @return UpgradeInfo
     */
    public function setMatchPairs($MatchPairs)
    {
        $this->MatchPairs = $MatchPairs;
        return $this;
    }
}