<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form;

use Latte\Engine;
use Latte\Extension;

final class FormExtension extends Extension
{
    public function getFilters(): array
    {
        return [
            'accept' => Config\Field::value(...),
            'alt' => Config\Field::value(...),
            'ariaDescribedBy' => Config\Field::variableLength(...),
            'ariaLabel' => Config\Field::value(...),
            'autofocus' => Config\Field::boolean(...),
            'cols' => Config\Field::value(...),
            'dirname' => Config\Field::value(...),
            'disabled' => Config\Field::boolean(...),
            'enrich' => Config\Field::enrich(...),
            'form' => Config\Field::value(...),
            'height' => Config\Field::value(...),
            'inputInvalidClass' => Config\Field::value(...),
            'inputValidClass' => Config\Field::value(...),
            'invalidClass' => Config\Field::value(...),
            'items' => Config\Field::value(...),
            'list' => Config\Field::value(...),
            'max' => Config\Field::value(...),
            'maxlength' => Config\Field::value(...),
            'min' => Config\Field::value(...),
            'minlength' => Config\Field::value(...),
            'multiple' => Config\Field::boolean(...),
            'optionsData' => Config\Field::value(...),
            'pattern' => Config\Field::value(...),
            'placeholder' => Config\Field::value(...),
            'readonly' => Config\Field::boolean(...),
            'required' => Config\Field::boolean(...),
            'rows' => Config\Field::value(...),
            'size' => Config\Field::value(...),
            'src' => Config\Field::value(...),
            'step' => Config\Field::value(...),
            'tabIndex' => Config\Field::counter(...),
            'usePlaceholder' => Config\Field::boolean(...),
            'validClass' => Config\Field::value(...),
            'width' => Config\Field::value(...),
            'wrap' => Config\Field::value(...),
        ];
    }

    public function getTags(): array
    {
        return [
            'button' => Node\ButtonNode::create(...),
            'buttonGroup' => Node\GroupNode::create(...),
            'checkbox' => Node\FieldNode::create(...),
            'checkboxList' => Node\FieldNode::create(...),
            'date' => Node\FieldNode::create(...),
            'dateTimeLocal' => Node\FieldNode::create(...),
            'email' => Node\FieldNode::create(...),
            'errorSummary' => Node\ErrorSummaryNode::create(...),
            'fieldset' => Node\GroupNode::create(...),
            'file' => Node\FieldNode::create(...),
            'hidden' => Node\FieldNode::create(...),
            'image' => Node\ButtonNode::create(...),
            'number' => Node\FieldNode::create(...),
            'password' => Node\FieldNode::create(...),
            'radioList' => Node\FieldNode::create(...),
            'range' => Node\FieldNode::create(...),
            'resetButton' => Node\ButtonNode::create(...),
            'select' => Node\FieldNode::create(...),
            'submitButton' => Node\ButtonNode::create(...),
            'telephone' => Node\FieldNode::create(...),
            'text' => Node\FieldNode::create(...),
            'textarea' => Node\FieldNode::create(...),
            'time' => Node\FieldNode::create(...),
            'url' => Node\FieldNode::create(...),
        ];
    }

    public function getCacheKey(Engine $engine): string
    {
        return md5(self::class);
    }

    public static function getConfig(array $configuration): array
    {
        $config = [];

        foreach ($configuration as $c) {
            foreach ($c as $k => $v) {
                $config[$k] = $v;
            }
        }

        return $config;
    }
}