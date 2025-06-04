<?php

namespace BeastBytes\View\Latte\Form\Tests;

use BeastBytes\View\Latte\Form\Tests\Support\Enricher;
use BeastBytes\View\Latte\Form\Tests\Support\TestForm;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ConfigTraitTest extends TestCase
{
    #[Test]
    #[DataProvider('configProvider')]
    public function config(string $name, string $tag, array $config, string $expected): void
    {
        $formModel = new TestForm();
        $this->createTemplate($name, $tag, $config);
        $html = $this->renderToString($name, ['formModel' => $formModel]);
        $this->assertSame($expected, $html);
    }

    #[Test]
    #[DataProvider('counterProvider')]
    public function counter(string $name, ?int $value, string $expected): void
    {
        $formModel = new TestForm();
        $this->createCounterTemplate($name, $value);
        $html = $this->renderToString($name, ['formModel' => $formModel]);
        $this->assertSame($expected, $html);
    }

    #[Test]
    #[DataProvider('enrichProvider')]
    public function enrich(string $name, string $tag, array $config, string $expected): void
    {
        $formModel = new TestForm();
        $this->createTemplate($name, $tag, $config);
        $html = $this->renderToString($name, ['formModel' => $formModel]);
        $this->assertSame($expected, $html);
    }

    public static function configProvider(): Generator
    {
        yield 'single bool default' => [
            'name' => 'single_bool_default',
            'tag' => 'text',
            'config' => ['autofocus' => null],
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" name="TestForm[text]" value autofocus>
</div>

EXPECTED,
        ];
        yield 'single bool true' => [
            'name' => 'single_bool_true',
            'tag' => 'text',
            'config' => ['required' => true],
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" name="TestForm[text]" value required>
</div>

EXPECTED,
        ];
        yield 'single bool false' => [
            'name' => 'single_bool_false',
            'tag' => 'text',
            'config' => ['required' => false],
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" name="TestForm[text]" value>
</div>

EXPECTED,
        ];
        yield 'single integer' => [
            'name' => 'single_integer',
            'tag' => 'text',
            'config' => ['minlength' => 5],
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" name="TestForm[text]" value minlength="5">
</div>

EXPECTED,
        ];
        yield 'two integers' => [
            'name' => 'two_integers',
            'tag' => 'textarea',
            'config' => ['cols' => 48, 'rows' => 10],
            'expected' => <<<EXPECTED
<div>
<label for="testform-textarea">Textarea Field</label>
<textarea id="testform-textarea" name="TestForm[textarea]" rows="10" cols="48"></textarea>
</div>

EXPECTED,
        ];
        yield 'string' => [
            'name' => 'string',
            'tag' => 'textarea',
            'config' => ['wrap' => 'hard'],
            'expected' => <<<EXPECTED
<div>
<label for="testform-textarea">Textarea Field</label>
<textarea id="testform-textarea" name="TestForm[textarea]" wrap="hard"></textarea>
</div>

EXPECTED,
        ];
        yield 'string and integers' => [
            'name' => 'string_and_integers',
            'tag' => 'textarea',
            'config' => ['cols' => 48, 'rows' => 10, 'wrap' => 'hard'],
            'expected' => <<<EXPECTED
<div>
<label for="testform-textarea">Textarea Field</label>
<textarea id="testform-textarea" name="TestForm[textarea]" rows="10" cols="48" wrap="hard"></textarea>
</div>

EXPECTED,
        ];
        yield 'array' => [
            'name' => 'array',
            'tag' => 'checkboxList',
            'config' => ['items' => ['one' => 'One', 'two' => 'Two', 'three' => 'Three']],
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
        yield 'variadic one value' => [
            'name' => 'variadic_one_value',
            'tag' => 'text',
            'config' => ['inputClass' => 'class-a'],
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" class="class-a" name="TestForm[text]" value>
</div>

EXPECTED,
        ];
        yield 'variadic multiple values' => [
            'name' => 'variadic_multiple_values',
            'tag' => 'text',
            'config' => ['inputClass' => ['class-a', 'class-b', 'class-c']],
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" class="class-a class-b class-c" name="TestForm[text]" value>
</div>

EXPECTED,
        ];
    }

    public static function counterProvider(): Generator
    {
        yield 'tabIndex auto' => [
            'name' => 'tabIndex_auto',
            'value' => null,
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" name="TestForm[text]" value tabindex="1">
</div>
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value tabindex="2">
</div>
<div>
<label for="testform-url">Url Field</label>
<input type="url" id="testform-url" name="TestForm[url]" value tabindex="3">
</div>

EXPECTED,
        ];
        yield 'tabIndex numbered' => [
            'name' => 'tabIndex_numbered',
            'value' => 4,
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" name="TestForm[text]" value tabindex="4">
</div>
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value tabindex="5">
</div>
<div>
<label for="testform-url">Url Field</label>
<input type="url" id="testform-url" name="TestForm[url]" value tabindex="6">
</div>

EXPECTED,
        ];
    }

    public static function enrichProvider(): Generator
    {
        yield 'enrich' => [
            'name' => 'enrich',
            'tag' => 'text',
            'config' => ['enrich' => null],
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" name="TestForm[text]" value required pattern="[A-Z]-\d{4}">
</div>

EXPECTED,
        ];
        yield 'enrich with test enricher' => [ // test enricher only supports pattern to ensure different result
            'name' => 'enrich_with_test_enricher',
            'tag' => 'text',
            'config' => ['enrich' => Enricher::class],
            'expected' => <<<EXPECTED
<div>
<label for="testform-text">Text Field</label>
<input type="text" id="testform-text" name="TestForm[text]" value pattern="[A-Z]-\d{4}">
</div>

EXPECTED,
        ];
    }

    private function createTemplate(string $name, string $tag, array $config): void
    {
        $template = "{varType Yiisoft\\FormModel\\FormModel \$formModel}\n\n";
        $template .= '{' . $tag . " \$formModel, '$tag'";

        foreach ($config as $setting => $value) {
            $template .= "|$setting";
            $template .= match (gettype($value)) {
                'NULL' => '',
                'boolean' => ':' . ($value ? 'true' : 'false'),
                'string' => ":'$value'",
                'integer', 'double' => ":$value",
                'array' => $this->array2String($value),
            };
        }

        $template .= '}';

        file_put_contents(self::TEMPLATE_DIR . "/$name.latte", $template);
    }

    private function createCounterTemplate(string $name, mixed $value): void
    {
        $template = "{varType Yiisoft\\FormModel\\FormModel \$formModel}\n\n";

        if ($value === null) {
            $template .= "{text \$formModel, 'text'|tabIndex}\n";
            $template .= "{email \$formModel, 'email'|tabIndex}\n";
            $template .= "{url \$formModel, 'url'|tabIndex}";
        } else {
            $template .= "{text \$formModel, 'text'|tabIndex:$value}\n";
            $value++;
            $template .= "{email \$formModel, 'email'|tabIndex:$value}\n";
            $value++;
            $template .= "{url \$formModel, 'url'|tabIndex:$value}";
        }

        file_put_contents(self::TEMPLATE_DIR . "/$name.latte", $template);
    }

    private function array2String(array $value): string
    {
        $keys = array_keys($value);
        $key = array_pop($keys);

        $return = [];

        if (is_int($key)) {
            foreach ($value as $v) {
                $return[] = "'$v'";
            }

            return ':' . join(',', $return);
        } elseif (is_string($key)) {
            foreach ($value as $k => $v) {
                $return[] = "'$k' => '$v'";
            }

            return ':[' . join(',', $return) . ']';
        }

        throw new InvalidArgumentException('Invalid key type');
    }
}