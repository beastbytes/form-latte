<?php

declare(strict_types=1);

namespace BeastBytes\View\Latte\Form\Tests\Support\Form;

use Yiisoft\FormModel\FormModel;

class TextForm extends FormModel
{
    private string $framework = 'Yii3';
    private string $engine = 'Latte';

    public function getPropertyLabels(): array
    {
        return [
            'framework' => 'FRAMEWORK',
            'engine' => 'ENGINE',
        ];
    }
}