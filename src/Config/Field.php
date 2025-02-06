<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Config;

use Stringable;
use Yiisoft\Form\ValidationRulesEnricherInterface;
use Yiisoft\FormModel\ValidationRulesEnricher;

class Field
{
    private static $tabindex = 1;

    public static function enrich(ValidationRulesEnricherInterface $enricher): array
    {
        return [
            'enrichFromValidationRules()' => [true],
            'validationRulesEnricher()' => [$enricher]
        ];
    }

    public static function ariaDescribedBy(string ...$value): array
    {
        return ['ariaDescribedBy()' => [join(',', $value)]];
    }

    public static function ariaLabel(string $value): array
    {
        return ['ariaLabel()' => [$value]];
    }

    public static function autofocus(bool $value = true): array
    {
        return ['autofocus()' => [$value]];
    }

    public static function dirname(string $value): array
    {
        return ['dirname()' => [$value]];
    }

    public static function disabled(bool $value = true): array
    {
        return ['disabled()' => [$value]];
    }

    public static function items(array $value): array
    {
        return ['items()' => [$value]];
    }

    public static function maxlength(int $value): array
    {
        return ['maxlength()' => [$value]];
    }

    public static function minlength(int $value): array
    {
        return ['minlength()' => [$value]];
    }

    public static function optionsData(array $value): array
    {
        return ['optionsData()' => [$value]];
    }

    public static function pattern(string $value): array
    {
        return ['pattern()' => [$value]];
    }

    public static function readonly(bool $value = true): array
    {
        return ['readonly()' => [$value]];
    }

    public static function required(bool $value = true): array
    {
        return ['required()' => [$value]];
    }

    public static function size(int $value): array
    {
        return ['size()' => [$value]];
    }

    public static function tabIndex(?int $value): array
    {
        if (is_null($value)) {
            $value = self::$tabindex++;
        }

        return ['tabIndex()' => [$value]];
    }

    public static function placeholder(string $value): array
    {
        return ['placeholder()' => [$value]];
    }

    public static function usePlaceholder(bool $value): array
    {
        return ['usePlaceholder()' => [$value]];
    }

    public static function invalidClass(string $value): array
    {
        return ['invalidClass()' => [$value]];
    }

    public static function validClass(string $value): array
    {
        return ['validClass()' => [$value]];
    }

    public static function inputInvalidClass(string $value): array
    {
        return ['inputInvalidClass()' => [$value]];
    }

    public static function inputValidClass(string $value): array
    {
        return ['inputValidClass()' => [$value]];
    }

    public static function cols(int $value): array
    {
        return ['cols()' => [$value]];
    }

    public static function rows(int $value): array
    {
        return ['rows()' => [$value]];
    }

    public static function wrap(string $value): array
    {
        return ['wrap()' => [$value]];
    }

    public static function max(float|int|string|Stringable $value): array
    {
        return ['max()' => [$value]];
    }

    public static function min(float|int|string|Stringable $value): array
    {
        return ['min()' => [$value]];
    }

    public static function step(float|int|string|Stringable $value): array
    {
        return ['step()' => [$value]];
    }

    public static function list(string $value): array
    {
        return ['list()' => [$value]];
    }

    public static function alt(string $value): array
    {
        return ['alt()' => [$value]];
    }

    public static function width(int|string|Stringable $value): array
    {
        return ['width()' => [$value]];
    }

    public static function height(int|string|Stringable $value): array
    {
        return ['height()' => [$value]];
    }

    public static function src(string $value): array
    {
        return ['src()' => [$value]];
    }

    public static function accept(string $value): array
    {
        return ['accept()' => [$value]];
    }

    public static function multiple(bool $value = true): array
    {
        return ['multiple()' => [$value]];
    }

    public static function form(string $value): array
    {
        return ['form()' => [$value]];
    }

    /*
    public static function legend(string|Stringable|null $content, array $attributes = []): array
    {
        $new = clone $this;
        $new->tag = $this->tag->legend($content, $attributes);
        return $new;
    }

    public static function legendTag(?Legend $legend): array
    {
        $new = clone $this;
        $new->tag = $this->tag->legendTag($legend);
        return $new;
    }
    */
}