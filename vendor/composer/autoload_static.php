<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5a3466a8998f8840d2c1dd49b9ac0961
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'D17030752\\Stock\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'D17030752\\Stock\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5a3466a8998f8840d2c1dd49b9ac0961::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5a3466a8998f8840d2c1dd49b9ac0961::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5a3466a8998f8840d2c1dd49b9ac0961::$classMap;

        }, null, ClassLoader::class);
    }
}
