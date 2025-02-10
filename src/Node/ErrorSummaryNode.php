<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use BeastBytes\View\Latte\Form\Config\ConfigTrait;
use Generator;
use Latte\CompileException;
use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\Php\IdentifierNode;
use Latte\Compiler\Nodes\Php\Scalar\NullNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;

final class ErrorSummaryNode extends StatementNode
{
    use ConfigTrait;

    public ExpressionNode $formModel;
    private IdentifierNode $name;
    private ExpressionNode $theme;

    /**
     * @throws CompileException
     */
    public static function create(Tag $tag): self
    {
        $tag->expectArguments();
        $node = $tag->node = new self;
        $node->name = new IdentifierNode($tag->name);
        $node->theme = new NullNode();

        foreach ($tag->parser->parseArguments() as $i => $argument) {
            switch ($i) {
                case 0:
                    $node->formModel = $argument->value;
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
            $this->formModel,
            $this->getConfig($context),
            $this->theme,
        );
    }

    /**
     * @inheritDoc
     */
    public function &getIterator(): Generator
    {
        yield $this->name;
        yield $this->formModel;
        yield $this->theme;
    }
}