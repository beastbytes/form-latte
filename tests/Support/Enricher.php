<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Tests\Support;

use Yiisoft\Form\Field\Base\BaseField;
use Yiisoft\Form\ValidationRulesEnricherInterface;
use Yiisoft\Html\Html;
use Yiisoft\Validator\Rule\Regex;

// Only supports pattern to ensure different result from default enricher
final class Enricher implements ValidationRulesEnricherInterface
{
    public function process(BaseField $field, mixed $rules): ?array
    {
        $enrichment = [];

        foreach ($rules as $rule) {
            if ($rule instanceof Regex) {
                $enrichment['inputAttributes']['pattern'] = Html::normalizeRegexpPattern($rule->getPattern());
            }
        }

        return $enrichment;
    }
}
