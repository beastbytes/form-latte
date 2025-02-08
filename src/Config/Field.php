<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Config;

use Stringable;
use Yiisoft\Form\ValidationRulesEnricherInterface;
use Yiisoft\FormModel\ValidationRulesEnricher;

class Field
{
    public static function boolean(string $name, bool $value = true): array
    {
        return ["$name()" => [$value]];
    }

    public static function counter(string $name, ?int $value = null): array
    {
        static $counters = [
            'tabIndex' => 1
        ];

        if (is_null($value)) {
            $value = $counters[$name]++;
        }

        return ["$name()" => [$value]];
    }

    public static function enrich(?ValidationRulesEnricherInterface $enricher): array
    {
        $enricher = $enricher ?? new ValidationRulesEnricher();

        return [
            'enrichFromValidationRules()' => [true],
            'validationRulesEnricher()' => [$enricher]
        ];
    }

    public static function value(string $name, array|float|int|string|Stringable $value): array
    {
        return ["$name()" => [$value]];
    }

    public static function variadic(string $name, mixed ...$value): array
    {
        return ["$name()" => [...$value]];
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