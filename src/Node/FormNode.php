<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use Generator;
use Latte\Compiler\Node;
use Latte\Compiler\Nodes\AreaNode;
use Latte\Compiler\Nodes\Php\Expression\ArrayNode;
use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\Php\FilterNode;
use Latte\Compiler\Nodes\Php\IdentifierNode;
use Latte\Compiler\Nodes\Php\ModifierNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;
use Latte\Compiler\TemplateParser;

class FormNode extends StatementNode
{
    public ExpressionNode $action;
    public ?ExpressionNode $attributes = null;
    public ?ModifierNode $config = null;
    public string $configuration = '';
    public AreaNode $content;
    public string $csrf = '';
    public ?ExpressionNode $method = null;

    public static function create(Tag $tag, TemplateParser $parser): Generator
    {
        $tag->expectArguments();
        $node = $tag->node = new self;

        foreach ($tag->parser->parseArguments() as $i => $argument) {
            switch ($i) {
                case 0:
                    $node->action = $argument->value;
                    break;
                case 1:
                    $node->method = $argument->value;
                    break;
                case 2:
                    $node->attributes = $argument->value;
                    break;
            }
        }

        $node->config = $tag->parser->parseModifier();

        [$node->content, $endTag] = yield;
        return $node;
    }

    public function print(PrintContext $context): string
    {
        $this->parseConfiguration($context);

        return $context->format(
            <<<'MASK'
            $L_form = Yiisoft\Html\Html::form(%node, %node, %node) %line;
            echo $L_form%raw%raw->open();
            echo "\n";
            %node
            echo "\n";
            echo $L_form->close();
            echo "\n";
MASK,
            $this->action,
            $this->method,
            $this->attributes ?? new ArrayNode(),
            $this->position,
            $this->csrf,
            $this->configuration,
            $this->content,
        );
    }

    private function parseConfiguration($context): void
    {
        $configuration = [];

        /** @var FilterNode $config */
        foreach ($this->config as $config) {
            $name = '';
            $atr = [];

            foreach ($config as $c) {
                if ($c instanceof IdentifierNode) {
                    $name = (string) $c;
                } else {
                    $atr[] = $c;
                }
            }

            if ($name === 'csrf') {
                foreach ($atr as &$a) {
                    $a = $a->print($context);
                }

                $this->csrf = '->csrf(' . $atr[0] . (count($atr) === 2 ? ',' . $atr[1] : ''). ')';
            } else {
                if (empty($atr)) {
                    $configuration[$name] = '';
                } else {
                    foreach ($atr as $a) {
                        $configuration[$name] = $a instanceof Node ? $a->print($context) : '';
                    }
                }
            }
        }

        foreach ($configuration as $modifier => $value) {
            $this->configuration .= "->$modifier($value)";
        }
    }

    public function &getIterator(): Generator
    {
        yield $this->action;
        yield $this->method;

        if ($this->attributes !== null) {
            yield $this->attributes;
        }

        yield $this->content;
    }
}