<?php

namespace zzdjk6\SilverStripe\ImageLinkUpgrade;

use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationException;

class ImageLinkUpgradeTask extends BuildTask
{
    private static $segment = 'ImageLinkUpgradeTask';

    protected $title = 'Upgrade Image Links Used In HTMLText and HTMLVar Fields';

    protected $description = 'Note: backup your database before use';

    public function run($request)
    {
        echo '<pre>';

        // Retrieve all DataObject classes contains HTMLText or HTMLVarchar field
        $targetClassesProvider = new TargetClassesProvider(); // TODO: use Injector
        $targetClasses = $targetClassesProvider->getTargetClasses();
        //print_r($targetClasses);exit;

        // Retrieve all image records in DB, get the mapping relation of ID, Filename and the accessible URL
        $imageMappingProvider = new ImageMappingProvider(); // TODO: use Injector
        $imageMapping = $imageMappingProvider->getUserImageMapping();
        //print_r($imageMapping);exit;

        // Get upgrade info by each class
        $upgradeInfoProvider = new UpgradeInfoProvider($imageMapping); // TODO: use Injector

        $allUpgradeInfoList = [];
        foreach ($targetClasses as $targetClass) {
            $upgradeInfoList = $upgradeInfoProvider->getUpgradeInfoList($targetClass);
            if ($upgradeInfoList) {
                $allUpgradeInfoList = array_merge($allUpgradeInfoList, $upgradeInfoList);
            }
        }
        //print_r($allUpgradeInfoList);
        //exit;

        // Apply changes to DB according to matches
        // TODO: Currently, it still require a manual publish after this task
        foreach ($allUpgradeInfoList as $upgradeInfo) {
            /* @var UpgradeInfo $upgradeInfo */
            $dataObject = DataObject::get_by_id($upgradeInfo->getClassName(), $upgradeInfo->getID());
            echo "Upgrading ==> ClassName: {$upgradeInfo->getClassName()}, Field: {$upgradeInfo->getField()}, ID: {$upgradeInfo->getID()}\n";
            echo "\n";
            echo "Original {$upgradeInfo->getField()}:\n";
            $original = $dataObject->{$upgradeInfo->getField()};
            echo htmlentities("{$original}\n");
            echo "\n";
            echo "Modifying: \n";
            $modified = $original;
            foreach ($upgradeInfo->getMatchPairs() as $matchPair) {
                echo "{$matchPair->getOldSrc()} -> {$matchPair->getNewSrc()}\n";
                $modified = str_replace(
                    "src=\"{$matchPair->getOldSrc()}\"",
                    "src=\"{$matchPair->getNewSrc()}\"",
                    $modified);
            }

            echo "Modified {$upgradeInfo->getField()}:\n";
            echo htmlentities($modified);
            $dataObject->{$upgradeInfo->getField()} = $modified;
            try {
                if ($dataObject->hasMethod('writeWithoutVersion')) {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $dataObject->writeWithoutVersion();
                } else {
                    $dataObject->write();
                }
            } catch (ValidationException $e) {
                echo "\n\nError: " . $e->getMessage() . "\n\n";
            }
            echo "\n\n ------ \n\n";
        }
    }
}