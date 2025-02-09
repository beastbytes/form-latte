<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Tests;

use BeastBytes\View\Latte\Form\FormExtension;
use BeastBytes\View\Latte\Form\Tests\Support\TestForm;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class FormFieldTest extends TestBase
{
    #[Test]
    #[DataProvider('buttonTagProvider')]
    public function button(string $tag, string $expected): void
    {
        $this->createButtonTemplate($tag);

        $html = $this
            ->latte
            ->renderToString(self::TEMPLATE_DIR . "/$tag.latte");

        $this->assertSame($expected, $html);
    }

    #[Test]
    #[DataProvider('buttonGroupTagProvider')]
    public function buttonGroup(string $tag, string $expected): void
    {
        $this->createButtonGroupTemplate($tag);

        $html = $this
            ->latte
            ->renderToString(self::TEMPLATE_DIR . "/$tag.latte");

        $this->assertSame($expected, $html);
    }

    #[Test]
    #[DataProvider('fieldTagProvider')]
    public function field(string $tag, string $expected): void
    {
        $formModel = new TestForm();
        $this->createFieldTemplate($tag);

        $html = $this
            ->latte
            ->renderToString(self::TEMPLATE_DIR . "/$tag.latte", ['formModel' => $formModel]);

        $this->assertSame($expected, $html);
    }

    #[Test]
    #[DataProvider('optionsFieldTagProvider')]
    public function optionsField(string $tag, string $expected): void
    {
        $formModel = new TestForm();
        $this->createOptionsFieldTemplate($tag);

        $html = $this
            ->latte
            ->renderToString(self::TEMPLATE_DIR . "/$tag.latte", ['formModel' => $formModel]);

        $this->assertSame($expected, $html);
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
        yield 'buttonGroup' => [
            'tag' => 'buttonGroup',
            'expected' => <<<EXPECTED
<div>
<button type="reset">Reset</button>
<button type="submit">Send</button>
</div>
EXPECTED
        ];
    }

    public static function buttonTagProvider(): Generator
    {
        yield 'button' => [
            'tag' => 'button',
            'expected' => <<<EXPECTED
<div>
<button type="button">button</button>
</div>

EXPECTED,
        ];
        yield 'image' => [
            'tag' => 'image',
            'expected' => <<<EXPECTED
<div>
<input type="image" src="image@example.com">
</div>

EXPECTED,
        ];
        yield 'resetButton' => [
            'tag' => 'resetButton',
            'expected' => <<<EXPECTED
<div>
<button type="reset">resetButton</button>
</div>

EXPECTED,
        ];
        yield 'submitButton' => [
            'tag' => 'submitButton',
            'expected' => <<<EXPECTED
<div>
<button type="submit">submitButton</button>
</div>

EXPECTED,
        ];
    }

    public static function optionsFieldTagProvider(): Generator
    {
        yield 'checkboxList' => [
            'tag' => 'checkboxList',
            'expected' => <<<EXPECTED
<div>
<label>CheckboxList Field</label>
<div>
<label><input type="checkbox" name="TestForm[checkboxList][]" value="one"> One</label>
<label><input type="checkbox" name="TestForm[checkboxList][]" value="two"> Two</label>
<label><input type="checkbox" name="TestForm[checkboxList][]" value="three"> Three</label>
</div>
</div>

EXPECTED,
        ];
        yield 'radioList' => [
            'tag' => 'radioList',
            'expected' => <<<EXPECTED
<div>
<label>RadioList Field</label>
<div>
<label><input type="radio" name="TestForm[radioList]" value="one"> One</label>
<label><input type="radio" name="TestForm[radioList]" value="two"> Two</label>
<label><input type="radio" name="TestForm[radioList]" value="three"> Three</label>
</div>
</div>

EXPECTED,
        ];
        yield 'select' => [
            'tag' => 'select',
            'expected' => <<<EXPECTED
<div>
<label for="testform-select">Select Field</label>
<select id="testform-select" name="TestForm[select]">
<option value="one">One</option>
<option value="two">Two</option>
<option value="three">Three</option>
</select>
</div>

EXPECTED,
        ];
    }

    public static function fieldTagProvider(): Generator
    {
        yield 'checkbox' => [
            'tag' => 'checkbox',
            'expected' => <<<EXPECTED
<div>
<input type="hidden" name="TestForm[checkbox]" value="0"><label><input type="checkbox" id="testform-checkbox" name="TestForm[checkbox]" value="1" checked> Checkbox Field</label>
</div>

EXPECTED,
        ];
        yield 'date' => [
            'tag' => 'date',
            'expected' => <<<EXPECTED
<div>
<label for="testform-date">Date Field</label>
<input type="date" id="testform-date" name="TestForm[date]" value>
</div>

EXPECTED,
        ];
        yield 'dateTimeLocal' => [
            'tag' => 'dateTimeLocal',
            'expected' => <<<EXPECTED
<div>
<label for="testform-datetimelocal">DateTimeLocal Field</label>
<input type="datetime-local" id="testform-datetimelocal" name="TestForm[dateTimeLocal]" value>
</div>

EXPECTED,
        ];
        yield 'email' => [
            'tag' => 'email',
            'expected' => <<<EXPECTED
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>

EXPECTED,
        ];
        yield 'file' => [
            'tag' => 'file',
            'expected' => <<<EXPECTED
<div>
<label for="testform-file">File Field</label>
<input type="file" id="testform-file" name="TestForm[file]">
</div>

EXPECTED,
        ];
        yield 'hidden' => [
            'tag' => 'hidden',
            'expected' => <<<EXPECTED
<input type="hidden" id="testform-hidden" name="TestForm[hidden]" value>

EXPECTED,
        ];
        yield [
            'tag' => 'number',
            'expected' => <<<EXPECTED
<div>
<label for="testform-number">Number Field</label>
<input type="number" id="testform-number" name="TestForm[number]" value>
</div>

EXPECTED,
        ];
        yield 'password' => [
            'tag' => 'password',
            'expected' => <<<EXPECTED
<div>
<label for="testform-password">Password Field</label>
<input type="password" id="testform-password" name="TestForm[password]" value>
</div>

EXPECTED,
        ];
        yield 'range' => [
            'tag' => 'range',
            'expected' => <<<EXPECTED
<div>
<label for="testform-range">Range Field</label>
<input type="range" id="testform-range" name="TestForm[range]" value>
</div>

EXPECTED,
        ];
        yield 'telephone' => [
            'tag' => 'telephone',
            'expected' => <<<EXPECTED
<div>
<label for="testform-telephone">Telephone Field</label>
<input type="tel" id="testform-telephone" name="TestForm[telephone]" value>
</div>

EXPECTED,
        ];
        yield 'text' => [
            'tag' => 'text',
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" name="TestForm[text]" value>
</div>

EXPECTED,
        ];
        yield 'textarea' => [
            'tag' => 'textarea',
            'expected' => <<<EXPECTED
<div>
<label for="testform-textarea">Textarea Field</label>
<textarea id="testform-textarea" name="TestForm[textarea]"></textarea>
</div>

EXPECTED,
        ];
        yield 'time' => [
            'tag' => 'time',
            'expected' => <<<EXPECTED
<div>
<label for="testform-time">Time Field</label>
<input type="time" id="testform-time" name="TestForm[time]" value>
</div>

EXPECTED,
        ];
        yield 'url' => [
            'tag' => 'url',
            'expected' => <<<EXPECTED
<div>
<label for="testform-url">Url Field</label>
<input type="url" id="testform-url" name="TestForm[url]" value>
</div>

EXPECTED,
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
            $template = '{' . $tag . " '$tag@example.com'}";
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