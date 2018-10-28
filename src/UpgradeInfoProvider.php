<?php

namespace zzdjk6\SilverStripe\ImageLinkUpgrade;

use SilverStripe\ORM\DataObject;

class UpgradeInfoProvider
{
    /**
     * @var array
     */
    private $imageMapping;

    /**
     * UpgradeInfoProvider constructor.
     * @param array $imageMapping
     */
    public function __construct(array $imageMapping)
    {
        $this->imageMapping = $imageMapping;
    }

    /**
     * @param TargetClass $targetClass
     * @return UpgradeInfo[]
     */
    public function getUpgradeInfoList($targetClass)
    {
        $upgradeInfoList = [];
        foreach ($targetClass->getFields() as $field) {
            $objects = DataObject::get($targetClass->getClass());
            foreach ($objects as $object) {
                $content = $object->$field;
                $allMatches = [];
                preg_match_all('/src="([^"]*)"/i', $content, $allMatches);
                //preg_match_all('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $content, $allMatches);
                if ($allMatches && !empty($allMatches[1])) {
                    $matchPairs = [];
                    /** @noinspection ForeachSourceInspection */
                    foreach ($allMatches[1] as $oldSrc) {
                        $newSrc = $this->getNewSrc($oldSrc, $this->imageMapping);
                        if ($newSrc == $oldSrc) {
                            continue;
                        }
                        $matchPairs[] = (new MatchPair)->setOldSrc($oldSrc)->setNewSrc($newSrc);
                    }

                    if (empty($matchPairs)) {
                        continue;
                    }

                    $upgradeInfo = (new UpgradeInfo)->setClassName($object->ClassName)
                        ->setID($object->ID)
                        ->setField($field)
                        ->setMatchPairs($matchPairs);

                    $upgradeInfoList[] = $upgradeInfo;
                }
            }
        }
        return $upgradeInfoList;
    }

    /**
     * @param string $oldSrc
     * @return string
     */
    private function getNewSrc($oldSrc)
    {
        $hasDBFile = isset($this->imageMapping[$oldSrc]);
        if ($hasDBFile) {
            /* @var ImageInfo $imageInfo */
            $imageInfo = $this->imageMapping[$oldSrc];
            return ltrim($imageInfo->getURL(), '/');
        }

        $isReferToTheme = strpos($oldSrc, 'themes/') === 0;
        if ($isReferToTheme) {
            return 'resources/' . $oldSrc;
        }

        return $oldSrc;
    }
}