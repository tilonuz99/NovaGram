<?php

namespace skrtdev\NovaGram;

class Beta{
    public static function getComposerLock() {
        $json = file_get_contents(__DIR__."/../../../../../composer.lock");
        return json_decode($json);
    }
    public static function CheckForUpdates() {
        if(self::getLatestShaRef() !== self::getCurrentShaRef()){
            print("A NovaGram update is now available! Do `composer update` to download it".PHP_EOL);
        }
    }

    public static function getPackage(){
        $composer_lock = self::getComposerLock();
        $packages = $composer_lock->packages;
        foreach ($packages as $package) {
            if($package->name === "skrtdev/novagram"){
                break;
            }
        }
        return $package;
    }

    public static function getLatestShaRef(){
        $package = self::getPackageFromPackagist();
        return $package['dev-beta']['source']['reference'];
    }

    public static function getPackageFromPackagist(){
        $json = Bot::curl("https://repo.packagist.org/p/skrtdev/novagram.json");
        $package = json_decode($json, true)['packages']['skrtdev/novagram'];
        return $package;
    }

    public static function getCurrentShaRef(){
        return self::getPackage()->source->reference;
    }

}

?>
