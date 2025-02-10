<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form;

use Latte\Engine;
use Latte\Extension;

final class FormExtension extends Extension
{
    public function getTags(): array
    {
        return [
            'button' => Node\ButtonNode::create(...),
            'buttonGroup' => Node\GroupNode::create(...),
            'checkbox' => Node\FieldNode::create(...),
            'checkboxList' => Node\FieldNode::create(...),
            'color' => Node\FieldNode::create(...),
            'date' => Node\FieldNode::create(...),
            'dateTimeLocal' => Node\FieldNode::create(...),
            'email' => Node\FieldNode::create(...),
            'errorSummary' => Node\ErrorSummaryNode::create(...),
            'fieldset' => Node\FieldsetNode::create(...),
            'file' => Node\FieldNode::create(...),
            'form' => Node\FormNode::create(...),
            'hidden' => Node\FieldNode::create(...),
            'image' => Node\ButtonNode::create(...),
            'month' => Node\FieldNode::create(...),
            'number' => Node\FieldNode::create(...),
            'password' => Node\FieldNode::create(...),
            'radio' => Node\FieldNode::create(...),
            'radioList' => Node\FieldNode::create(...),
            'range' => Node\FieldNode::create(...),
            'reset' => Node\ButtonNode::create(...),
            'resetButton' => Node\ButtonNode::create(...),
            'search' => Node\FieldNode::create(...),
            'select' => Node\FieldNode::create(...),
            'submit' => Node\ButtonNode::create(...),
            'submitButton' => Node\ButtonNode::create(...),
            'tel' => Node\FieldNode::create(...),
            'telephone' => Node\FieldNode::create(...),
            'text' => Node\FieldNode::create(...),
            'textarea' => Node\FieldNode::create(...),
            'time' => Node\FieldNode::create(...),
            'week' => Node\FieldNode::create(...),
            'url' => Node\FieldNode::create(...),
        ];
    }

    public function getCacheKey(Engine $engine): string
    {
        return md5(self::class);
    }
}