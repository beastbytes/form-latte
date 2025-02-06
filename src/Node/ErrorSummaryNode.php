<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Node;

use BeastBytes\View\Latte\Form\Config\ConfigTrait;
use Generator;
use Latte\Compiler\Nodes\Php\ExpressionNode;
use Latte\Compiler\Nodes\StatementNode;
use Latte\Compiler\PrintContext;
use Latte\Compiler\Tag;

final class ErrorSummaryNode extends StatementNode
{
    use ConfigTrait;

    public ExpressionNode $formModel;
    private ?ExpressionNode $theme;

    public static function create(Tag $tag): self
    {
        $tag->expectArguments();
        $node = $tag->node = new self;

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
            'echo Yiisoft\FormModel\Field::errorSummary(%node, %raw'
            . ($this->theme !== null ? '%node' : ', %raw')
            . ') %line;',
            $this->formModel,
            $this->getConfig(),
            $this->theme,
        );
    }

    /**
     * @inheritDoc
     */
    public function &getIterator(): Generator
    {
        yield $this->formModel;

        if ($this->theme !== null) {
            yield $this->theme;
        }
    }
}