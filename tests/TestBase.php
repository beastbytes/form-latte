<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Tests;

use BeastBytes\View\Latte\Form\FormExtension;
use BeastBytes\View\Latte\Form\Tests\Support\TestForm;
use BeastBytes\View\Latte\LatteFactory;
use Generator;
use Latte\Engine;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Files\FileHelper;

class TestBase extends TestCase
{
    protected const CACHE_DIR = __DIR__ . '/generated/cache';
    protected const TEMPLATE_DIR = __DIR__ . '/generated/template';

    protected Engine $latte;

    protected function setUp(): void
    {
        parent::setUp();
        FileHelper::ensureDirectory(self::CACHE_DIR);
        FileHelper::ensureDirectory(self::TEMPLATE_DIR);
        $factory = new LatteFactory(self::CACHE_DIR, extensions: [new FormExtension()]);
        $this->latte = $factory->create();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        //FileHelper::removeDirectory(self::CACHE_DIR);
        //FileHelper::removeDirectory(self::TEMPLATE_DIR);
    }
}