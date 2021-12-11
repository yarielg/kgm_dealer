<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf8a3400ea277f2f2d7e721093b475b08
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Kgm\\Inc\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Kgm\\Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf8a3400ea277f2f2d7e721093b475b08::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf8a3400ea277f2f2d7e721093b475b08::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}