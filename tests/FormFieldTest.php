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

class FormFieldTest extends TestCase
{
    private const CACHE_DIR = __DIR__ . '/generated/cache';
    private const TEMPLATE_DIR = __DIR__ . '/generated/template';

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
        FileHelper::removeDirectory(self::CACHE_DIR);
        FileHelper::removeDirectory(self::TEMPLATE_DIR);
    }

    #[Test]
    #[DataProvider('buttonTagProvider')]
    public function button(string $tag, string $result): void
    {
        $this->createButtonTemplate($tag);

        $field = $this
            ->latte
            ->renderToString(self::TEMPLATE_DIR . "/$tag.latte");

        $this->assertSame($result, $field);
    }

    #[Test]
    #[DataProvider('buttonGroupTagProvider')]
    public function buttonGroup(string $tag, string $result): void
    {
        $this->createButtonGroupTemplate($tag);

        $field = $this
            ->latte
            ->renderToString(self::TEMPLATE_DIR . "/$tag.latte");

        $this->assertSame($result, $field);
    }

    #[Test]
    #[DataProvider('fieldTagProvider')]
    public function field(string $tag, string $result): void
    {
        $formModel = new TestForm();
        $this->createFieldTemplate($tag);

        $field = $this
            ->latte
            ->renderToString(self::TEMPLATE_DIR . "/$tag.latte", ['formModel' => $formModel]);

        $this->assertSame($result, $field);
    }

    #[Test]
    #[DataProvider('optionsFieldTagProvider')]
    public function optionsField(string $tag, string $result): void
    {
        $formModel = new TestForm();
        $this->createOptionsFieldTemplate($tag);

        $field = $this
            ->latte
            ->renderToString(self::TEMPLATE_DIR . "/$tag.latte", ['formModel' => $formModel]);

        $this->assertSame($result, $field);
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

    public static function tagProvider(): Generator
    {
        foreach (self::buttonTagProvider() as $item) {
            yield [$item['tag']];
        }
        foreach (self::fieldTagProvider() as $item) {
            yield [$item['tag']];
        }
        foreach (self::optionsFieldTagProvider() as $item) {
            yield [$item['tag']];
        }
    }

    public static function buttonGroupTagProvider(): Generator
    {
        yield [
            'tag' => 'buttonGroup',
            'result' => "<div>\n"
                . '<button type="reset">Reset</button>' . "\n"
                . '<button type="submit">Send</button>' . "\n"
                . '</div>'
        ];
    }

    public static function buttonTagProvider(): Generator
    {
        yield [
            'tag' => 'button',
            'result' => "<div>\n"
                . '<button type="button">button</button>' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'image',
            'result' => "<div>\n"
                . '<input type="image" src="image@example.com">' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'resetButton',
            'result' => "<div>\n"
                . '<button type="reset">resetButton</button>' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'submitButton',
            'result' => "<div>\n"
                . '<button type="submit">submitButton</button>' . "\n"
                . '</div>'
            ,
        ];
    }

    public static function optionsFieldTagProvider(): Generator
    {
        yield [
            'tag' => 'checkboxList',
            'result' => "<div>\n"
                . '<label>CheckboxList Field</label>' . "\n"
                . "<div>\n"
                . '<label><input type="checkbox" name="TestForm[checkboxList][]" value="one"> One</label>' . "\n"
                . '<label><input type="checkbox" name="TestForm[checkboxList][]" value="two"> Two</label>' . "\n"
                . '<label><input type="checkbox" name="TestForm[checkboxList][]" value="three"> Three</label>' . "\n"
                . "</div>\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'radioList',
            'result' => "<div>\n"
                . '<label>RadioList Field</label>' . "\n"
                . "<div>\n"
                . '<label><input type="radio" name="TestForm[radioList]" value="one"> One</label>' . "\n"
                . '<label><input type="radio" name="TestForm[radioList]" value="two"> Two</label>' . "\n"
                . '<label><input type="radio" name="TestForm[radioList]" value="three"> Three</label>' . "\n"
                . "</div>\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'select',
            'result' => "<div>\n"
                . '<label for="testform-select">Select Field</label>' . "\n"
                . '<select id="testform-select" name="TestForm[select]">' . "\n"
                . '<option value="one">One</option>' . "\n"
                . '<option value="two">Two</option>' . "\n"
                . '<option value="three">Three</option>' . "\n"
                . "</select>\n"
                . '</div>'
            ,
        ];
    }

    public static function fieldTagProvider(): Generator
    {
        yield [
            'tag' => 'checkbox',
            'result' => "<div>\n"
                . '<input type="hidden" name="TestForm[checkbox]" value="0">'
                . '<label>'
                . '<input type="checkbox" id="testform-checkbox" name="TestForm[checkbox]" value="1" checked>'
                . " Checkbox Field</label>\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'date',
            'result' => "<div>\n"
                . '<label for="testform-date">Date Field</label>' . "\n"
                . '<input type="date" id="testform-date" name="TestForm[date]" value>' . "\n"
                . '</div>'
            ,
        ];
        yield [
            'tag' => 'dateTimeLocal',
            'result' => "<div>\n"
                . '<label for="testform-datetimelocal">DateTimeLocal Field</label>' . "\n"
                . '<input type="datetime-local" id="testform-datetimelocal" name="TestForm[dateTimeLocal]" value>' . "\n"
                . '</div>'
            ,
        ];
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
        yield [
            'tag' => 'range',
            'result' => "<div>\n"
                . '<label for="testform-range">Range Field</label>' . "\n"
                . '<input type="range" id="testform-range" name="TestForm[range]" value>' . "\n"
                . '</div>'
            ,
        ];
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
        yield [
            'tag' => 'textarea',
            'result' => "<div>\n"
                . '<label for="testform-textarea">Textarea Field</label>' . "\n"
                . '<textarea id="testform-textarea" name="TestForm[textarea]"></textarea>' . "\n"
                . '</div>'
            ,
        ];
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

    private function createButtonGroupTemplate($tag): void
    {
        $template = "{varType Yiisoft\\FormModel\\FormModel \$formModel}\n\n";
        $template .= "{var \$buttons = [
            Yiisoft\Html\Html::resetButton('Reset'),
            Yiisoft\Html\Html::submitButton('Send'),
        ]}\n\n";
        $template .= '{' . $tag . '|buttons: ...$buttons}';

        file_put_contents(self::TEMPLATE_DIR . "/$tag.latte", $template);
    }

    private function createButtonTemplate($tag): void
    {
        if ($tag === 'image') {
            $template = '{' . $tag . "'$tag@example.com'}";
        } else {
            $template = '{' . $tag . " '$tag'}";
        }

        file_put_contents(self::TEMPLATE_DIR . "/$tag.latte", $template);
    }

    private function createFieldTemplate($tag): void
    {
        $template = "{varType Yiisoft\\FormModel\\FormModel \$formModel}\n\n";
        $template .= '{' . $tag . " \$formModel, '$tag'}";

        file_put_contents(self::TEMPLATE_DIR . "/$tag.latte", $template);
    }

    private function createOptionsFieldTemplate($tag): void
    {
        $template = "{varType Yiisoft\\FormModel\\FormModel \$formModel}\n\n";
        $template .= "{var \$options = ['one'=>'One','two'=>'Two','three'=>'Three']}\n\n";
        $template .= '{' . $tag . " \$formModel, '$tag'|";

        if ($tag === 'select') {
            $template .= 'optionsData:$options';
        } else {
            $template .= 'items:$options';
        }

        $template .= '}';

        file_put_contents(self::TEMPLATE_DIR . "/$tag.latte", $template);
    }
}