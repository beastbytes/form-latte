<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use BeastBytes\View\Latte\Form\Config\Field;
use Latte\Compiler\Nodes\Php\ModifierNode;
use Latte\Compiler\Nodes\StatementNode;

trait ConfigTrait
{
    protected ?ModifierNode $config = null;

    private function getConfig(): string
    {
        $config = [];

        foreach ($this->config as $cnfg) {
            $filter = $cnfg->name->name;
            $arg = empty($cnfg->args) ? null : $cnfg->args[0]->value->value;
            $config[] = call_user_func([Field::class, $filter], $arg);
        }

        return '['. join(',', $config) . ']';
    }
}