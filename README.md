This package is a [Latte](https://latte.nette.org/) [extension](https://latte.nette.org/en/creating-extension) 
that integrates the Yii 3 [Form Model](https://github.com/yiisoft/form-model) package with the 
[Latte Renderer for Yii](https://github.com/beastbytes/view-latte); it supports all built-in fields.

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
The extension adds tags to Latte for form fields (including errorSummary), and the form and fieldset HTML tags.
The extension follows the conventions of the Form Model package, in that form fields are specified with the form model,
field parameter, and optionally a theme;
all other options are specified in the field configuration using Latte's filter syntax;
where an option takes a value, the value is the same as for the equivalent form model field type. 

### Form Fields
Form field tags can have the same names as the Yii fields or HTML fields, e.g. 'text', 'email', etc.;
'tel' or 'telephone' can be used, as can 'submit' or 'submitButton', 'reset' or 'resetButton'.

A form input has the pattern:
```latte
{tagname $formModel, 'parameter'|config1|config2|...|configN}
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
A form to collect a person's name, email, address, phone number, and agreement to terms:
```latte
{form $action|csrf:$csrf}
    {errorSummary $formModel|onlyFirst}
    {text $formModel, 'givenName'|tabIndex}
    {text $formModel, 'familyName'|required|tabIndex}
    {email $formModel, 'email'|required|tabIndex}
    {text $formModel, 'streetAddress'|required|tabIndex}
    {text $formModel, 'locality'|required|tabIndex}
    {text $formModel, 'region'|required|tabIndex}
    {text $formModel, 'postalCode'|required|tabIndex}
    {select $formModel, 'country'|required|tabIndex|optionsData:$countries}
    {tel $formModel, 'telephone'|required|tabIndex}
    {checkbox $formModel, 'agree'|tabIndex}
    {submit 'Submit'}
{/form}
```

### Extra Features
The package adds some extra features that make developing a form even easier.

* **Field enrichment**: If you use field enrichment - setting options based on validation rules, e.g. `required`,
just add the `enrich` option. Yii's Field Enricher is used by default, but you can specify your own.
```latte
  {text $formModel, 'familyName'|enrich} {* use the default enricher *}
  {text $formModel, 'familyName'|enrich:$myEnricher} {* use $myEnricher *}
```
* **Tab Index**: If no value is given with the tabIndex option the package will auto index the fields.
You can pass a value if you want to. **NOTE** do not mix auto indexing and self indexing in a form.
```latte
    {* Auto indexing *}
    {text $formModel, 'givenName'|tabIndex}
    {text $formModel, 'familyName'|tabIndex}
```
```latte
    {* Self indexing *}
    {text $formModel, 'givenName'|tabIndex:1}
    {text $formModel, 'familyName'|tabIndex:2}
```

## IDE Support
### JetBrains PhpStorm
Install the [Latte Support](https://plugins.jetbrains.com/plugin/24218-latte-support) plugin.
Either copy the `latte.xml` file (in the root directory of this package) to the `.idea` directory of your project
or merge with an existing `latte.xml`.

## License
The BeastBytes View Latte Form package is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.
