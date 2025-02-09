<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Config;

use Latte\Compiler\Nodes\Php\FilterNode;
use Latte\Compiler\Nodes\Php\ModifierNode;

trait ConfigTrait
{
    protected ?ModifierNode $config = null;

    private function getConfig($context): string
    {
        $configuration = [];

        /** @var FilterNode $config */
        foreach ($this->config as $config) {
            $args = [];

            foreach ($config->args as $arg) {
                $args[] = $arg->print($context);
            }

            $configuration[] = "'" . $config->name->name . "()'=>[" . join(',', $args) . ']';
        }

        return '[' . join(',', $configuration) . ']';
    }
}