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
use Yiisoft\FormModel\FormModel;

class FormExtensionTest extends TestCase
{
    private const  CACHE_DIR = __DIR__ . '/generated/cache';
    private const  TEMPLATE_DIR = __DIR__ . '/generated/template';

    private Engine $latte;

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
 //       FileHelper::removeDirectory(self::CACHE_DIR);
 //       FileHelper::removeDirectory(self::TEMPLATE_DIR);
    }
    
    #[Test]
    #[DataProvider('fieldTagProvider')]
    public function field(string $tag, string $result): void
    {
        $formModel = new TestForm();
        $this->createFieldTemplate($tag, $formModel);

        $field = $this
            ->latte
            ->renderToString(self::TEMPLATE_DIR . "/$tag-field.latte", ['formModel' => $formModel]);

        $this->assertSame($result, $field);
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
    #[DataProvider('fieldTagProvider')]
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

    public static function fieldTagProvider(): Generator
    {
        /*
        yield [
            'tag' => 'checkbox',
            'result' => '<input type="text" id="testform-text"">',
        ];
        yield [
            'tag' => 'checkboxList',
            'result' => '<input type="text" id="testform-text">',
        ];
        */
        yield [
            'tag' => 'date',
            'result' => "<div>\n"
                . '<label for="testform-date">Date Field</label>' . "\n"
                . '<input type="date" id="testform-date" name="TestForm[date]" value>' . "\n"
                . '</div>'
            ,
        ];
        /*
        yield [
            'tag' => 'dateTimeLocal',
            'result' => "<div>\n"
                . '<label for="testform-time">Time Field</label>' . "\n"
                . '<input type="tel" id="testform-time" name="TestForm[time]" value>' . "\n"
                . '</div>'
            ,
        ];
        */
        yield [
            'tag' => 'email',
            'result' => "<div>\n"
                . '<label for="testform-email">Email Field</label>' . "\n"
                . '<input type="email" id="testform-email" name="TestForm[email]" value>' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'file',
            'result' => "<div>\n"
                . '<label for="testform-file">File Field</label>' . "\n"
                . '<input type="file" id="testform-file" name="TestForm[file]">' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'hidden',
            'result' => '<input type="hidden" id="testform-hidden" name="TestForm[hidden]" value>',
        ];
        yield [
            'tag' => 'image',
            'result' => "<div>\n"
                . '<label for="testform-image">Image Field</label>' . "\n"
                . '<input type="image" id="testform-image" name="TestForm[image]" value>' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'number',
            'result' => "<div>\n"
                . '<label for="testform-number">Number Field</label>' . "\n"
                . '<input type="number" id="testform-number" name="TestForm[number]" value>' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'password',
            'result' => "<div>\n"
                . '<label for="testform-password">Password Field</label>' . "\n"
                . '<input type="password" id="testform-password" name="TestForm[password]" value>' . "\n"
                . '</div>'
            ,
        ];
        /*
        yield [
            'tag' => 'radioList',
            'result' => '',
        ];
        yield [
            'tag' => 'range',
            'result' => '',
        ];
        yield [
            'tag' => 'select',
            'result' => '',
        ];
        */
        yield [
            'tag' => 'telephone',
            'result' => "<div>\n"
                . '<label for="testform-telephone">Telephone Field</label>' . "\n"
                . '<input type="tel" id="testform-telephone" name="TestForm[telephone]" value>' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'text',
            'result' => "<div>\n"
                . '<label for="testform-text">Text Field</label>' . "\n"
                . '<input type="text" id="testform-text" name="TestForm[text]" value>' . "\n"
                . '</div>'
            ,
        ];
        /*
        yield [
            'tag' => 'textarea',
            'result' => '<textarea id="testform-textarea" name="TestForm[textarea]>',
        ];
        */
        yield [
            'tag' => 'time',
            'result' => "<div>\n"
                . '<label for="testform-time">Time Field</label>' . "\n"
                . '<input type="time" id="testform-time" name="TestForm[time]" value>' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'url',
            'result' => "<div>\n"
                . '<label for="testform-url">Url Field</label>' . "\n"
                . '<input type="url" id="testform-url" name="TestForm[url]" value>' . "\n"
                . '</div>'
            ,
        ];
    }

    private function createFieldTemplate($tag)
    {
        $template = "{varType Yiisoft\\FormModel\\FormModel \$formModel}\n\n";
        $template .= '{' . $tag . " \$formModel, '$tag'}";

        file_put_contents(self::TEMPLATE_DIR . "/$tag-field.latte", $template);
    }
}