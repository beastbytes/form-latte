<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Config;

class Form
{
    public static function acceptCharset(string $value): string
    {
        return "acceptCharset($value)";
    }

    public static function autocomplete(bool $value): string
    {
        return 'autocomplete(' . ($value ? 'true' : 'false') . ')';
    }

    public static function csrf(string $value): string
    {
        return "csrf($value)";
    }

    public static function enctype(string $value): string
    {
        return "enctype($value)";
    }

    public static function get(string $value): string
    {
        return "get($value)";
    }

    public static function method(string $value): string
    {
        return "method($value)";
    }

    public static function noValidate(bool $value): string
    {
        return 'noValidate(' . ($value ? 'true' : 'false') . ')';
    }

    public static function post(string $value): string
    {
        return "post($value)";
    }

    public static function target(string $value): string
    {
        return "target($value)";
    }
}