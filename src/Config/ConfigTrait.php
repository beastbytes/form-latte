<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Config;

use Latte\Compiler\Nodes\Php\Expression\VariableNode;
use Latte\Compiler\Nodes\Php\FilterNode;
use Latte\Compiler\Nodes\Php\ModifierNode;
use Latte\Compiler\Nodes\Php\Scalar\FloatNode;
use Latte\Compiler\Nodes\Php\Scalar\IntegerNode;
use Latte\Compiler\Nodes\Php\Scalar\StringNode;

trait ConfigTrait
{
    protected ?ModifierNode $config = null;

    private function getConfig(): string
    {
        $config = [];

        /** @var FilterNode $filterNode */
        foreach ($this->config as $filterNode) {
            $config[] = call_user_func(
                [Field::class, $filterNode->name->name],
                $this->getValue($filterNode)
            );
        }

        return '['. join(',', $config) . ']';
    }

    private function getValue(FilterNode $filterNode): mixed
    {
        if (!empty($filterNode->args)) {
            $valueNode = $filterNode->args[0]->value;

            if ($valueNode instanceof VariableNode) {
                return '$' . $valueNode->name;
            } else {
                /** @var IntegerNode|FloatNode|StringNode $valueNode */
                return $valueNode->value;
            }
        }

        return null;
    }
}