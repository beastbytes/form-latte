<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use BeastBytes\View\Latte\Form\Config\ConfigTrait;
use Generator;
use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\Php\IdentifierNode;
use Latte\Compiler\Nodes\Php\Scalar\NullNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;

final class ButtonNode extends StatementNode
{
    use ConfigTrait;

    private ExpressionNode $content;
    private IdentifierNode $name;
    private ExpressionNode $theme;

    public static function create(Tag $tag): self
    {
        $tag->expectArguments();
        $node = $tag->node = new self;
        $node->name = new IdentifierNode(
            match ($tag->name) {
                'reset' => 'resetButton',
                'submit' => 'submitButton',
                default => $tag->name
            }
        );
        $node->theme = new NullNode();

        foreach ($tag->parser->parseArguments() as $i => $argument) {
            switch ($i) {
                case 0:
                    $node->content = $argument->value;
                    break;
                case 1:
                    $node->theme = $argument->value;
                    break;
            }
        }

        $node->config = $tag->parser->parseModifier();

        return $node;
    }

    public function print(PrintContext $context): string
    {
        return $context->format(
            <<<'MASK'
            echo Yiisoft\FormModel\Field::%node(%node, %raw, %node) %line;
            echo "\n";
            MASK,
            $this->name,
            $this->content,
            $this->getConfig($context),
            $this->theme,
            $this->position,
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