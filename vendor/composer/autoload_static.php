<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd61a0cb6fcf6ab3ffe7746c206409094
{
    public static $files = array (
        '4cdafd4a5191caf078235e7dd119fdaf' => __DIR__ . '/..' . '/flightphp/core/flight/autoload.php',
    );

    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd61a0cb6fcf6ab3ffe7746c206409094::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd61a0cb6fcf6ab3ffe7746c206409094::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd61a0cb6fcf6ab3ffe7746c206409094::$classMap;

        }, null, ClassLoader::class);
    }
}
