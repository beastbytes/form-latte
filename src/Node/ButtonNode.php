<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use BeastBytes\View\Latte\Form\Config\ConfigTrait;
use Generator;
use Latte\Compiler\NodeHelpers;
use Latte\Compiler\Nodes\AreaNode;
use Latte\Compiler\Nodes\Php\ArrayItemNode;
use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\Php\FilterNode;
use Latte\Compiler\Nodes\Php\IdentifierNode;
use Latte\Compiler\Nodes\Php\ModifierNode;
use Latte\Compiler\Nodes\Php\Scalar\NullNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;

final class ButtonNode extends StatementNode
{
    use ConfigTrait;

    public AreaNode $content;
    private IdentifierNode $name;
    private ExpressionNode $theme;

    public static function create(Tag $tag): Generator
    {
        $node = $tag->node = new self;
        $node->name = new IdentifierNode(
            match ($tag->name) {
                'reset' => 'resetButton',
                'submit' => 'submitButton',
                default => $tag->name
            },
        );
        $node->theme = new NullNode();

        foreach ($tag->parser->parseArguments() as $argument) {
            $node->theme = $argument->value;
        }

        $node->config = $tag->parser->parseModifier();

        [$node->content, $endTag] = yield;
        return $node;
    }

    /**
     * Returns the button as an array fur use in ButtonGroup
     */
    public function toArray(): array
    {
        $button = [NodeHelpers::toText($this->content)];
        $button['type'] = str_replace('Button', '', $this->name->name);

        $attributesFilter = NodeHelpers::findFirst(
            $this->config,
            fn($node) => $node instanceof FilterNode && $node->name->name === 'attributes',
        );

        $attributes = NodeHelpers::find(
            $attributesFilter,
            fn($node) => $node instanceof ArrayItemNode,
        );

        /** @var ArrayItemNode $attribute */
        foreach ($attributes as $attribute) {
            $button[$attribute->key->value] = $attribute->value->value;
        }

        return $button;
    }

    public function print(PrintContext $context): string
    {
        return $context->format(
            <<<'MASK'
            echo Yiisoft\FormModel\Field::%node(%raw, %raw, %node) %line;
            echo "\n";
            MASK,
            $this->name,
            $this->getContent($context),
            $this->getConfig($context),
            $this->theme,
            $this->position,
        );
    }

    private function getContent($context): string
    {
        return preg_replace(
            [
                "|('\s+')?|",
                '|( /\* line \d+ \*/)?|',
            ],
            '',
            str_replace(
                [
                    'echo ',
                    ';',
                    "\n",
                    "''",
                ],
                '',
                $this->content->print($context)
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function &getIterator(): Generator
    {
        yield $this->name;
        yield $this->content;
        yield $this->theme;
    }
}