<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use Generator;
use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;

class GroupNode extends StatementNode
{
    private ExpressionNode $config;
    public string $name;
    private ExpressionNode $theme;

    public static function create(Tag $tag): self
    {
        $tag->expectArguments();
        $node = $tag->node = new self;
        $node->name = $tag->name;
        $node->config = $tag->parser->parseExpression();
        $node->theme = $tag->parser->parseExpression();

        return $node;
    }

    public function print(PrintContext $context): string
    {
        return $context->format(
            'echo Yiisoft\FormModel\Field::' . $this->name . '(%node, %node) %line;',
            $this->config,
            $this->theme,
        );
    }

    /**
     * @inheritDoc
     */
    public function &getIterator(): Generator
    {
        yield $this->config;
        yield $this->theme;
    }
}