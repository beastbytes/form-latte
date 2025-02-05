<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Config;

use Stringable;
use Yiisoft\Form\ValidationRulesEnricherInterface;
use Yiisoft\FormModel\ValidationRulesEnricher;

class Field
{
    private static $tabindex = 1;

    public static function enrich(?ValidationRulesEnricherInterface $enricher = null): array
    {
        if ($enricher === null) {
            $enricher === new ValidationRulesEnricher();
        }

        return [
            'enrichFromValidationRules() => [true]',
            'validationRulesEnricher() => [$enricher]', // @todo not correct
        ];
    }

    public static function required(bool $value = true): string
    {
        return "'required()' => [" . ($value ? 'true' : 'false') . ']';
    }

    public static function ariaDescribedBy(string ...$value): string
    {
        return "'ariaDescribedBy()' => [" . join(',', $value) . ']';
    }

    public static function ariaLabel(string $value): string
    {
        return "'ariaLabel()' => [" . $value . ']';
    }

    public static function autofocus(bool $value = true): string
    {
        return "'autofocus()' => [" . ($value ? 'true' : 'false') . ']';
    }

    public static function dirname(string $value): string
    {
        return "'dirname()' => [" . $value . ']';
    }

    public static function disabled(bool $value = true): string
    {
        return "'disabled()' => [" . ($value ? 'true' : 'false') . ']';
    }

    public static function maxlength(int $value): string
    {
        return "'maxlength()' => [" . $value . ']';
    }

    public static function minlength(int $value): string
    {
        return "'minlength()' => [" . $value . ']';
    }

    public static function pattern(string $value): string
    {
        return "'pattern()' => [" . $value . ']';
    }

    public static function readonly(bool $value = true): string
    {
        return "'readonly()' => [" . ($value ? 'true' : 'false') . ']';
    }

    public static function size(int $value): string
    {
        return "'size()' => [" . $value . ']';
    }

    public static function tabIndex(?int $value): string
    {
        if (is_null($value)) {
            $value = self::$tabindex++;
        }

        return "'tabIndex()' => [" . $value . ']';
    }

    public static function placeholder(string $value): string
    {
        return "'placeholder()' => [" . $value . ']';
    }

    public static function usePlaceholder(bool $value): string
    {
        return "'usePlaceholder()' => [" . ($value ? 'true' : 'false') . ']';
    }

    public static function invalidClass(string $value): string
    {
        return "'invalidClass()' => [" . $value . ']';
    }

    public static function validClass(string $value): string
    {
        return "'validClass()' => [" . $value . ']';
    }

    public static function inputInvalidClass(string $value): string
    {
        return "'inputInvalidClass()' => [" . $value . ']';
    }

    public static function inputValidClass(string $value): string
    {
        return "'inputValidClass()' => [" . $value . ']';
    }

    public static function cols(int $value): string
    {
        return "'cols()' => [" . $value . ']';
    }

    public static function rows(int $value): string
    {
        return "'rows()' => [" . $value . ']';
    }

    public static function wrap(string $value): string
    {
        return "'wrap()' => [" . $value . ']';
    }

    public static function max(float|int|string|Stringable $value): string
    {
        return "'max()' => [" . $value . ']';
    }

    public static function min(float|int|string|Stringable $value): string
    {
        return "'min()' => [" . $value . ']';
    }

    public static function step(float|int|string|Stringable $value): string
    {
        return "'step()' => [" . $value . ']';
    }

    public static function list(string $value): string
    {
        return "'list()' => [" . $value . ']';
    }

    public static function alt(string $value): string
    {
        return "'alt()' => [" . $value . ']';
    }

    public static function width(int|string|Stringable $value): string
    {
        return "'width()' => [" . $value . ']';
    }

    public static function height(int|string|Stringable $value): string
    {
        return "'height()' => [" . $value . ']';
    }

    public static function src(string $value): string
    {
        return "'src()' => [" . $value . ']';
    }

    public static function accept(string $value): string
    {
        return "'accept()' => [" . $value . ']';
    }

    public static function multiple(bool $value = true): string
    {
        return "'multiple()' => [" . ($value ? 'true' : 'false') . ']';
    }

    public static function form(string $value): string
    {
        return "'form()' => [" . $value . ']';
    }

    /*
    public static function legend(string|Stringable|null $content, array $attributes = []): string
    {
        $new = clone $this;
        $new->tag = $this->tag->legend($content, $attributes);
        return $new;
    }

    public static function legendTag(?Legend $legend): string
    {
        $new = clone $this;
        $new->tag = $this->tag->legendTag($legend);
        return $new;
    }
    */
}