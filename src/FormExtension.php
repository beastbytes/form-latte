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
            'enrich' => Config\Field::enrich(...),
            'ariaDescribedBy' => Config\Field::ariaDescribedBy(...),
            'ariaLabel' => Config\Field::ariaLabel(...),
            'autofocus' => Config\Field::autofocus(...),
            'dirname' => Config\Field::dirname(...),
            'disabled' => Config\Field::disabled(...),
            'items' => Config\Field::items(...),
            'maxlength' => Config\Field::maxlength(...),
            'minlength' => Config\Field::minlength(...),
            'optionsData' => Config\Field::optionsData(...),
            'pattern' => Config\Field::pattern(...),
            'readonly' => Config\Field::rreadonly(...),
            'required' => Config\Field::required(...),
            'size' => Config\Field::size(...),
            'tabIndex' => Config\Field::tabIndex(...),
            'placeholder' => Config\Field::placeholder(...),
            'usePlaceholder' => Config\Field::usePlaceholder(...),
            'invalidClass' => Config\Field::invalidClass(...),
            'validClass' => Config\Field::validClass(...),
            'inputInvalidClass' => Config\Field::inputInvalidClass(...),
            'inputValidClass' => Config\Field::inputValidClass(...),
            'cols' => Config\Field::cols(...),
            'rows' => Config\Field::rows(...),
            'wrap' => Config\Field::wrap(...),
            'max' => Config\Field::max(...),
            'min' => Config\Field::min(...),
            'step' => Config\Field::step(...),
            'list' => Config\Field::list(...),
            'alt' => Config\Field::alt(...),
            'width' => Config\Field::width(...),
            'height' => Config\Field::height(...),
            'src' => Config\Field::src(...),
            'accept' => Config\Field::accept(...),
            'multiple' => Config\Field::multiple(...),
            'form' => Config\Field::form(...),
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