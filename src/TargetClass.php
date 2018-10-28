<?php

namespace zzdjk6\SilverStripe\ImageLinkUpgrade;

class TargetClass
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var string[]
     */
    private $fields;

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return TargetClass
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string[] $fields
     * @return TargetClass
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }
}