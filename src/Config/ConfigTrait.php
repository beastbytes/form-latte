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
            $configuration[] = $config->printSimple($context, "'" . $config->name->name . "'");
        }

        return 'BeastBytes\View\Latte\Form\FormExtension::getConfig([' . join(',', $configuration) . '])';
    }
}