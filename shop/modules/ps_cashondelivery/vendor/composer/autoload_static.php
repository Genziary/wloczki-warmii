<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd7659830902be3cf055a43974173c955
{
    public static $classMap = array (
        'Ps_Cashondelivery' => __DIR__ . '/../..' . '/ps_cashondelivery.php',
        'Ps_CashondeliveryValidationModuleFrontController' => __DIR__ . '/../..' . '/controllers/front/validation.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitd7659830902be3cf055a43974173c955::$classMap;

        }, null, ClassLoader::class);
    }
}
