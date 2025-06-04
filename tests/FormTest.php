<?php

namespace BeastBytes\View\Latte\Form\Tests;

use BeastBytes\View\Latte\Form\Tests\Support\TestForm;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Yiisoft\Html\Tag\Form;

class FormTest extends TestCase
{
    private const CSRF_TOKEN = 'SWo74Kit470YinCd2kYxb3BDNYaBZ5jgV76UV1cEsrUrMniwmtyz8lbNP_jtdgUYPBlC_7Ym07kGx-ExNG-fww==';
    private const CSRF_NAME = 'testCsrf';

    #[Test]
    public function simpleForm(): void
    {
        $formModel = new TestForm();
        $expected = <<<EXPECTED
<form action="https://example.com/email/edit" method="post">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED;

        $this->generateSimpleForm();
        $html = $this->renderToString('form', ['formModel' => $formModel]);
        $this->assertSame($expected, $html);
    }

    #[Test]
    public function csrfForm(): void
    {
        $expected = sprintf(
            <<<EXPECTED
<form action="https://example.com/email/edit" method="post">
<input type="hidden" name="%s" value="%s">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
           self::CSRF_NAME,
           self::CSRF_TOKEN
        );

        $this->generateCsrfForm();
        $html = $this->renderToString(
            'csrfForm',
            [
                'csrfName' => self::CSRF_NAME,
                'csrfToken' => self::CSRF_TOKEN,
                'formModel' => new TestForm()
            ]
        );
        $this->assertSame($expected, $html);
    }

    #[Test]
    #[DataProvider('modifierProvider')]
    public function modifierForm($modifier, $value, $expected): void
    {
        $this->generateModifierForm($modifier, $value);
        $html = $this->renderToString(
            str_replace(' ', '_', $modifier) . '_modifierForm',
            [
                'csrfName' => self::CSRF_NAME,
                'csrfToken' => self::CSRF_TOKEN,
                'formModel' => new TestForm()
            ]
        );
        $this->assertSame($expected, $html);
    }

    private function generateSimpleForm(): void
    {
        $template = <<<'TEMPLATE'
            {varType Yiisoft\FormModel\FormModel $formModel}
            {var $action = 'https://example.com/email/edit'}
            
            {form $action, post}
            {email $formModel, 'email'}
            {/form}
            TEMPLATE
        ;

        file_put_contents(self::TEMPLATE_DIR . '/form.latte', $template);
    }

    private function generateCsrfForm(): void
    {
        $template = sprintf(
            <<<'TEMPLATE'
            {varType string $csrfToken}
            {varType Yiisoft\FormModel\FormModel $formModel}
            {var $action = 'https://example.com/email/edit'}
            
            {form $action, post|csrf:$csrfToken,%s}
            {email $formModel, 'email'}
            {/form}
            TEMPLATE,
            self::CSRF_NAME
        );

        file_put_contents(self::TEMPLATE_DIR . '/csrfForm.latte', $template);
    }

    private function generateModifierForm($modifier, $value): void
    {
        $modifier = explode(' ', $modifier);

        $value = match(gettype($value)) {
            'boolean' => $value ? 'true' : 'false',
            'string' => "'$value'",
            default => null
        };

        $template = sprintf(
            <<<'TEMPLATE'
            {varType string $csrfName}
            {varType string $csrfToken}
            {varType Yiisoft\FormModel\FormModel $formModel}
            {var $action = 'https://example.com/email/edit'}
            
            {form $action, post|csrf:$csrfToken,$csrfName|%s%s}
            {email $formModel, 'email'}
            {/form}
            TEMPLATE,
            $modifier[0],
            is_null($value) ? '' : ":$value"
        );

        file_put_contents(self::TEMPLATE_DIR . '/'
            . join('_', $modifier) . '_modifierForm.latte', $template)
        ;
    }

    public static function modifierProvider(): Generator
    {
        $csrfName = self::CSRF_NAME;
        $csrfToken = self::CSRF_TOKEN;

        yield 'get 1' => [
            'modifier' => 'get 1',
            'value' => null,
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="GET">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'get 2' => [
            'modifier' => 'get 2',
            'value' => 'https://example.com/get_form',
            'expected' => <<<EXPECTED
<form action="https://example.com/get_form" method="GET">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'post 1' => [
            'modifier' => 'post 1',
            'value' => null,
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="POST">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'post 2' => [
            'modifier' => 'post 2',
            'value' => 'https://example.com/post_form',
            'expected' => <<<EXPECTED
<form action="https://example.com/post_form" method="POST">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'acceptCharset' => [
            'modifier' => 'acceptCharset',
            'value' => 'UTF-8',
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="post" accept-charset="UTF-8">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'action' => [
            'modifier' => 'action',
            'value' => 'https://example.com/action_form',
            'expected' => <<<EXPECTED
<form action="https://example.com/action_form" method="post">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'autocomplete' => [
            'modifier' => 'autocomplete',
            'value' => true,
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="post" autocomplete="on">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'enctype 1' => [
            'modifier' => 'enctype 1',
            'value' => Form::ENCTYPE_MULTIPART_FORM_DATA,
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'enctypeApplicationXWwwFormUrlencoded' => [
            'modifier' => 'enctypeApplicationXWwwFormUrlencoded',
            'value' => null,
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="post" enctype="application/x-www-form-urlencoded">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'enctypeMultipartFormData' => [
            'modifier' => 'enctypeMultipartFormData',
            'value' => null,
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'enctypeTextPlain' => [
            'modifier' => 'enctypeTextPlain',
            'value' => null,
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="post" enctype="text/plain">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'method' => [
            'modifier' => 'method',
            'value' => 'get',
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="get">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'noValidate' => [
            'modifier' => 'noValidate',
            'value' => true,
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="post" novalidate>
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
        yield 'target' => [
            'modifier' => 'target',
            'value' => '_blank',
            'expected' => <<<EXPECTED
<form action="https://example.com/email/edit" method="post" target="_blank">
<input type="hidden" name="$csrfName" value="$csrfToken">
<div>
<label for="testform-email">Email Field</label>
<input type="email" id="testform-email" name="TestForm[email]" value>
</div>
</form>

EXPECTED,
        ];
    }
}