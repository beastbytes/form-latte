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
            'buttonGroup' => Node\ButtonGroupNode::create(...),
            'checkbox' => Node\CheckboxNode::create(...),
            'checkboxList' => Node\CheckboxListNode::create(...),
            'date' => Node\DateNode::create(...),
            'dateTimeLocal' => Node\DateTimeLocalNode::create(...),
            'email' => Node\EmailNode::create(...),
            'errorSummary' => Node\ErrorSummaryNode::create(...),
            'fieldset' => Node\FieldsetNode::create(...),
            'file' => Node\FileNode::create(...),
            'hidden' => Node\HiddenNode::create(...),
            'image' => Node\ImageNode::create(...),
            'number' => Node\NumberNode::create(...),
            'password' => Node\PasswordNode::create(...),
            'radioList' => Node\RadioListNode::create(...),
            'range' => Node\RangeNode::create(...),
            'resetButton' => Node\ResetButtonNode::create(...),
            'select' => Node\SelectNode::create(...),
            'submitButton' => Node\SubmitButtonNode::create(...),
            'telephone' => Node\TelephoneNode::create(...),
            'text' => Node\TextNode::create(...),
            'textarea' => Node\TextareaNode::create(...),
            'time' => Node\TimeNode::create(...),
            'url' => Node\UrlNode::create(...),
        ];
    }

    public function getCacheKey(Engine $engine): string
    {
        return md5(self::class);
    }
}