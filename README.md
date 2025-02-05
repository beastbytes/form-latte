This package is a [Latte](https://latte.nette.org/) [extension](https://latte.nette.org/en/creating-extension) 
that integrates Yii's [Form](https://github.com/yiisoft/form/) with the 
[Latte Renderer for Yii](https://github.com/beastbytes/view-latte).

## Requirements
- PHP 8.1 or higher.

## Installation
Install the package using [Composer](https://getcomposer.org):

Either:
```shell
composer require beastbytes/view-latte-form
```
or add the following to the `require` section of your `composer.json`
```json
"beastbytes/view-latte-form": "*"
```

## Configuration
To configure Latte to use the extension add it to the `extensions` key of `beastbytes/view-latte` in the params
of your configuration.

```php
'beastbytes/view-latte' => [
    // filters and functions
    'extensions' => [
        new BeastBytes\View\Latte\Form\FormExtension(),
    ]
],
```

## Usage
The extension adds tags to Latte for form fields, and the form and fieldset HTML tags. The tags have the minimum needed
required paramters; optional parameters are specified using Latte's filter syntax. 

### Form Fields
Form field tags have the same names as the Yii fields, e.g. 'text', 'email', etc.

Form input fields all follow the same pattern:
```latte
{tagname $formModel, 'parameter'|attribute1|attribute2...|attributeN}
```

### Example 1
Login form
```latte
{form $action|csrf:$csrf}
    {email $formModel, 'email'|required|tabIndex}
    {password $formModel, 'password'|required|tabIndex}
    {submitButton 'Login'}
{/form}
```

### Example 2
A form to collect a person's name, email, address, and phone number (field names are vCard fields):
```latte
{form $action|csrf:$csrf}
    {text $formModel, 'givenName'|tabIndex}
    {text $formModel, 'familyName'|required|tabIndex}
    {email $formModel, 'email'|required|tabIndex}
    {text $formModel, 'streetAddress'|required|tabIndex}
    {text $formModel, 'locality'|required|tabIndex}
    {text $formModel, 'region'|required|tabIndex}
    {text $formModel, 'postalCode'|required|tabIndex}
    {telephone $formModel, 'telephone'|required|tabIndex}
    {submitButton 'Submit'}
{/form}
```

## License
The BeastBytes View Latte Form package is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.