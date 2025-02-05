<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Tests;

use BeastBytes\View\Latte\Form\FormExtension;
use BeastBytes\View\Latte\LatteFactory;
use BeastBytes\View\Latte\Form\Tests\Support\Form\TextForm;
use Generator;
use Latte\Engine;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yiisoft\Files\FileHelper;

class FormExtensionTest extends TestCase
{
    private string $cacheDir = __DIR__ . '/public/tmp';
    private Engine $latte;

    protected function setUp(): void
    {
        parent::setUp();
        FileHelper::ensureDirectory($this->cacheDir);
        $factory = new LatteFactory($this->cacheDir, extensions: [new FormExtension()]);
        $this->latte = $factory->create();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        //FileHelper::removeDirectory($this->cacheDir);
    }
    
    #[Test]
    public function field(): void
    {
        $formModel = new TextForm();

        $result = $this
            ->latte
            ->renderToString(__DIR__ . '/public/views/text-field.latte', ['formModel' => $formModel]);

        $this->assertNotEmpty($result);
        $this->assertStringContainsString('<input type="text" id="textform-framework"', $result);
        $this->assertStringContainsString('<input type="text" id="textform-engine"', $result);
        $this->assertStringContainsString('maxlength="25"', $result);
        $this->assertStringContainsString('minlength="5"', $result);
    }

    #[Test]
    #[DataProvider('filterProvider')]
    public function getFilters(string $filter): void
    {
        $extension = new FormExtension();
        $filters = $extension->getFilters();

        $this->assertIsArray($filters);
        $this->assertArrayHasKey(key: $filter, array: $filters);
    }

    #[Test]
    #[DataProvider('tagProvider')]
    public function getTags(string $tag): void
    {
        $extension = new FormExtension();
        $tags = $extension->getTags();

        $this->assertIsArray($tags);
        $this->assertArrayHasKey(key: $tag, array: $tags);
    }

    public static function filterProvider(): Generator
    {
        yield ['filter' => 'acceptCharset'];
        yield ['filter' => 'autocomplete'];
        yield ['filter' => 'csrf'];
        yield ['filter' => 'enctype'];
        yield ['filter' => 'method'];
        yield ['filter' => 'noValidate'];
        yield ['filter' => 'target'];
    }

    public static function tagProvider(): Generator
    {
        yield ['tag' => 'text'];
    }
}