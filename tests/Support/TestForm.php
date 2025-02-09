<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Tests\Support;

use Yiisoft\FormModel\FormModel;
use Yiisoft\Validator\Rule\Regex;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

class TestForm extends FormModel implements RulesProviderInterface
{
    private string $checkbox = '1';
    private array $checkboxList = [];
    private string $date = '';
    private string $dateTimeLocal = '';
    private string $email = '';
    private string $file = '';
    private string $hidden = '';
    private string $image = '';
    private string $number = '';
    private string $password = '';
    private string $radioList = '';
    private string $range = '';
    private string $select = '';
    private string $telephone = '';
    private string $text = '';
    private string $textarea = '';
    private string $time = '';
    private string $url = '';

    public function getRules(): array
    {
        return [
            'text' => [
                new Required(),
                new Regex(pattern: '/[A-Z]-\d{4}/'),
            ]
        ];
    }

    public function getPropertyLabels(): array
    {
        return [
            'checkbox' => 'Checkbox Field',
            'checkboxList' => 'CheckboxList Field',
            'date' => 'Date Field',
            'dateTimeLocal' => 'DateTimeLocal Field',
            'email' => 'Email Field',
            'file' => 'File Field',
            'hidden' => 'Hidden Field',
            'image' => 'Image Field',
            'number' => 'Number Field',
            'password' => 'Password Field',
            'radioList' => 'RadioList Field',
            'range' => 'Range Field',
            'select' => 'Select Field',
            'telephone' => 'Telephone Field',
            'text' => 'Text Field',
            'textarea' => 'Textarea Field',
            'time' => 'Time Field',
            'url' => 'Url Field',
        ];
    }
}