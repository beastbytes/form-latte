<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use BeastBytes\View\Latte\Form\Config\ConfigTrait;
use Generator;
use Latte\CompileException;
use Latte\Compiler\Nodes\AreaNode;
use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\Php\IdentifierNode;
use Latte\Compiler\Nodes\Php\Scalar\NullNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;

final class FieldsetNode extends StatementNode
{
    use ConfigTrait;

    public AreaNode $content;
    private IdentifierNode $name;
    private ExpressionNode $theme;

    /**
     * @throws CompileException
     */
    public static function create(Tag $tag): Generator
    {
        $tag->expectArguments();
        $node = $tag->node = new self;
        $node->name = new IdentifierNode($tag->name);
        $node->theme = new NullNode();

        foreach ($tag->parser->parseArguments() as $argument) {
            $node->theme = $argument->value;
        }

        $node->config = $tag->parser->parseModifier();

        [$node->content, $endTag] = yield;
        return $node;
    }

    public function print(PrintContext $context): string
    {
        return $context->format(
            <<<'MASK'
            $L_fieldset = Yiisoft\FormModel\Field::%node(%raw, %node) %line;
            echo $L_fieldset->begin();
            echo "\n";
            %node
            echo $L_fieldset->render();
            echo "\n";
            MASK,
            $this->name,
            $this->getConfig($context),
            $this->theme,
            $this->position,
            $this->content,
        );
    }

    public function &getIterator(): Generator
    {
        yield $this->name;
        yield $this->theme;
        yield $this->content;
    }
}