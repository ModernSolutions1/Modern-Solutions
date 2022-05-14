<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit755bc2a2876611d69e408e622fc14b78
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit755bc2a2876611d69e408e622fc14b78::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit755bc2a2876611d69e408e622fc14b78::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit755bc2a2876611d69e408e622fc14b78::$classMap;

        }, null, ClassLoader::class);
    }
}