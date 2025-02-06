<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use BeastBytes\View\Latte\Form\Config\ConfigTrait;
use Generator;
use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;

class FieldNode extends StatementNode
{
    use ConfigTrait;

    private ExpressionNode $formModel;
    private ExpressionNode $parameter;
    private ?ExpressionNode $theme = null;
    private string $name;

    public static function create(Tag $tag): self
    {
        $tag->expectArguments();
        $node = $tag->node = new self;
        $node->name = $tag->name;

        foreach ($tag->parser->parseArguments() as $i => $argument) {
            switch ($i) {
                case 0:
                    $node->formModel = $argument->value;
                    break;
                case 1:
                    $node->parameter = $argument->value;
                    break;
                case 2:
                    $node->theme = $argument->value;
                    break;
            }
        }

        if (!$tag->parser->isEnd()) {
            $node->config = $tag->parser->parseModifier();
        }

        return $node;
    }

    public function print(PrintContext $context): string
    {
        return $context->format(
            'echo Yiisoft\FormModel\Field::' . $this->name
            . '(%node, %node, %raw'
            . ($this->theme !== null ? '%node' : ', %raw')
            . ') %line;',
            $this->formModel,
            $this->parameter,
            $this->getConfig(),
            $this->theme,
            $this->position,
        );
    }

    public function &getIterator(): Generator
    {
        yield $this->formModel;
        yield $this->parameter;

        if ($this->theme !== null) {
            yield $this->theme;
        }
    }
}