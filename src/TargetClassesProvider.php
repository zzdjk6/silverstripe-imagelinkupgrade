<?php

namespace zzdjk6\SilverStripe\ImageLinkUpgrade;

use Generator;
use SilverStripe\Core\ClassInfo;
use SilverStripe\ORM\DataObject;

class TargetClassesProvider
{
    /**
     * @return TargetClass[]
     */
    public function getTargetClasses()
    {
        $targetClasses = [];
        $dataClasses = array_values(ClassInfo::getValidSubClasses(DataObject::class));

        foreach ($dataClasses as $class) {
            $fields = $this->getHTMLTextFields($class);
            if ($fields) {
                if (!count($fields)) {
                    continue;
                }

                $targetClass = (new TargetClass)->setClass($class)->setFields($fields);
                $targetClasses[] = $targetClass;
            }
        }

        return $targetClasses;
    }

    /**
     * @param $class
     * @return string[]
     */
    private function getHTMLTextFields($class)
    {
        $fields = [];
        foreach ($this->getDBFields($class) as $field => $type) {
            if ($type === 'HTMLText' || $type === 'HTMLVarchar') {
                $fields[] = $field;
            }
        }

        return $fields;
    }

    /**
     * @param $class
     * @return Generator
     */
    private function getDBFields($class)
    {
        foreach (DataObject::singleton($class)->getSchema()->fieldSpecs($class) as $field => $type) {
            yield $field => $type;
        }
    }
}