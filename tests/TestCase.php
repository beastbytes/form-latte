<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Tests;

use BeastBytes\View\Latte\Form\FormExtension;
use BeastBytes\View\Latte\LatteFactory;
use Latte\Engine;
use PHPUnit\Framework\Attributes\AfterClass;
use PHPUnit\Framework\Attributes\BeforeClass;
use Yiisoft\Files\FileHelper;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected const CACHE_DIR = __DIR__ . '/generated/cache';
    protected const TEMPLATE_DIR = __DIR__ . '/generated/template';

    protected static Engine $latte;

    #[BeforeClass]
    public static function beforeClass(): void
    {
        FileHelper::ensureDirectory(self::CACHE_DIR);
        FileHelper::ensureDirectory(self::TEMPLATE_DIR);
        $factory = new LatteFactory(self::CACHE_DIR, extensions: [new FormExtension()]);
        self::$latte = $factory->create();
    }

    #[AfterClass]
    public static function afterClass(): void
    {
        FileHelper::removeDirectory(self::CACHE_DIR);
        FileHelper::removeDirectory(self::TEMPLATE_DIR);
    }

    protected function renderToString(string $name, array $parameters = []): string
    {
        return self::$latte->renderToString(self::TEMPLATE_DIR . "/$name.latte", $parameters);
    }
}