<?php declare(strict_types=1);

use Shopware\Core\TestBootstrapper;

if (is_readable(__DIR__ . '/../vendor/shopware/platform/src/Core/TestBootstrapper.php')) {
    require __DIR__ . '/../vendor/shopware/platform/src/Core/TestBootstrapper.php';
} else {
    require __DIR__ . '/../../../../vendor/shopware/core/TestBootstrapper.php';
}

return (new TestBootstrapper())
    ->setProjectDir($_SERVER['PROJECT_ROOT'] ?? dirname(__DIR__, 4))
    ->setLoadEnvFile(true)
    ->setForceInstallPlugins(true)
    ->addCallingPlugin()
    ->bootstrap()
    ->setClassLoader(require dirname(__DIR__) . '/../../../vendor/autoload.php')
    ->getClassLoader();
