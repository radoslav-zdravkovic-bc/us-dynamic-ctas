<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit79a18f617f1247fbd8673af37630070e
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'USDynamicCTAs\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'USDynamicCTAs\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit79a18f617f1247fbd8673af37630070e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit79a18f617f1247fbd8673af37630070e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
