<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use BeastBytes\View\Latte\Form\Config\ConfigTrait;
use Generator;
use Latte\CompileException;
use Latte\Compiler\NodeHelpers;
use Latte\Compiler\Nodes\AreaNode;
use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\Php\IdentifierNode;
use Latte\Compiler\Nodes\Php\ModifierNode;
use Latte\Compiler\Nodes\Php\Scalar\NullNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;

final class GroupNode extends StatementNode
{
    use ConfigTrait;

    public AreaNode $buttons;
    private IdentifierNode $name;
    private ExpressionNode $theme;

    /**
     * @throws CompileException
     */
    public static function create(Tag $tag): Generator
    {
        $node = $tag->node = new self;
        $node->name = new IdentifierNode($tag->name);
        $node->theme = new NullNode();

        foreach ($tag->parser->parseArguments() as $argument) {
            $node->theme = $argument->value;
        }

        $node->config = $tag->parser->parseModifier();

        [$node->buttons, $endTag] = yield;

        return $node;
    }

    public function print(PrintContext $context): string
    {
        return $context->format(
            <<<'MASK'
            echo Yiisoft\FormModel\Field::%node(%raw, %node) %line;
            echo "\n";
            MASK,
            $this->name,
            $this->getButtonsAndConfig($context),
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
        yield $this->theme;
    }

    private function getButtonsAndConfig($context): string
    {
        $encode = '/\'encode\(\)\'=>\[(true|false)]/';
        $buttons = $this->getButtons();
        $config = $this->getConfig($context);

        if (preg_match($encode, $config, $matches) === 1) {
            $buttons = substr($buttons, 0, -1) . ', ' . $matches[1] . ']';
            $config = preg_replace($encode, '', $config);
        }

        return '[' . $buttons . substr($config, 1);
    }

    private function getButtons(): string
    {
        $buttons = [];

        $buttonNodes = NodeHelpers::find(
            $this->buttons,
            fn($node) => $node instanceof ButtonNode,
        );

        /** @var ButtonNode $buttonNode */
        foreach ($buttonNodes as $buttonNode) {
            $button = [];

            foreach ($buttonNode->toArray() as $k => $v) {
                if (is_int($k)) {
                    array_unshift($button, "'$v'");
                } else {
                    array_push($button, "'$k' => '$v'");
                }
            }

            $buttons[] = '[' . implode(', ', $button) . ']';
        }

        return "'buttonsData()'=>[[\n" . implode(",\n", $buttons) . "\n]]";
    }
}