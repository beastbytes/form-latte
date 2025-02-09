<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Config;

use Latte\Compiler\Nodes\Php\FilterNode;
use Latte\Compiler\Nodes\Php\ModifierNode;
use Yiisoft\FormModel\ValidationRulesEnricher;

trait ConfigTrait
{
    protected ?ModifierNode $config = null;
    private string $enrich = 'enrich';
    private static array $counters = [
        'tabIndex',
    ];

    private function getConfig($context): string
    {
        static $counters = [
            'tabIndex' => 1,
        ];

        $configuration = [];

        /** @var FilterNode $config */
        foreach ($this->config as $config) {
            $args = [];
            $name = $config->name->name;

            foreach ($config->args as $arg) {
                $args[] = $arg->print($context);
            }

            if ($name === $this->enrich) {
                $configuration[] = "'enrichFromValidationRules()'=>[true]";

                if (count($args) === 0) {
                    $cls = 'new Yiisoft\FormModel\ValidationRulesEnricher()';
                } else {
                    $cls = 'new ' . str_replace(["'", '\\\\'], ['', '\\'], $args[0]) . '()';
                }
                $configuration[] = "'validationRulesEnricher()'=>[$cls]";
            } else {
                if (in_array($name, self::$counters) && count($args) === 0) {
                    $args[] = $counters[$name]++;
                }

                $configuration[] = "'" . $name . "()'=>[" . join(',', $args) . ']';
            }
        }

        return '[' . join(',', $configuration) . ']';
    }
}