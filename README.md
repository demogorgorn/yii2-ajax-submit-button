# AjaxSubmitButton for Yii 2
=====================================

[![Latest Stable Version](https://poser.pugx.org/demogorgorn/yii2-ajax-submit-button/v/stable)](https://packagist.org/packages/demogorgorn/yii2-ajax-submit-button)
[![Total Downloads](https://poser.pugx.org/demogorgorn/yii2-ajax-submit-button/downloads)](https://packagist.org/packages/demogorgorn/yii2-ajax-submit-button)
[![License](https://poser.pugx.org/demogorgorn/yii2-ajax-submit-button/license)](https://packagist.org/packages/demogorgorn/yii2-ajax-submit-button)
[![Monthly Downloads](https://poser.pugx.org/demogorgorn/yii2-ajax-submit-button/d/monthly)](https://packagist.org/packages/demogorgorn/yii2-ajax-submit-button)
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)


This is the powerful AjaxSubmitButton widget that renders an ajax button which is very similar to ajaxSubmitButton from Yii1 for Yii 2, but has many useful functions.

### Basic Example

Example of usage of the widget with a custom widget (in this case Select2 widget).

The view:
```php
use demogorgorn\ajax\AjaxSubmitButton;

<?php echo Html::beginForm('', 'post', ['class'=>'uk-width-medium-1-1 uk-form uk-form-horizontal']); ?>
      
<?= Select2::widget([
    'name' => 'country_code',
    'data' => Country::getAllCountries(),
    'options' => [
        'id' => 'country_select',
        'multiple' => false, 
        'placeholder' => 'Choose...',
        'class' => 'uk-width-medium-7-10']
     ]);
?>
       
<?php AjaxSubmitButton::begin([
    'label' => 'Check',
    'ajaxOptions' => [
        'type'=>'POST',
        'url'=>'country/getinfo',
        'success' => new \yii\web\JsExpression('function(html){
            $("#output").html(html);
            }'),
    ],
    'options' => ['class' => 'customclass', 'type' => 'submit'],
    ]);
    AjaxSubmitButton::end();
?>
            
<?php echo Html::endForm(); ?>

<div id="output"></div>
```

> Please note: that #output is a div element which will be updated.

In controller:
```php
public function actionGetinfo()
{
    if(!isset($_POST['country_code']) || empty($_POST['country_code']))
        return;

    $code = $_POST['country_code'];

    return $this->renderAjax('resultwidget', ['code' => $code]);
}
```

### Example of usage with ActiveForm and client validation

The view:
```php
    $form = ActiveForm::begin([
               'id' => 'add-form',
               'options' => ['class' => 'form-inline'],
            ]);

    ...

    AjaxSubmitButton::begin([
        'label' => 'Add',
        'useWithActiveForm' => 'add-form',
        'ajaxOptions' => [
            'type' => 'POST',
            'success' => new \yii\web\JsExpression("function(data) {
                if (data.status == true) 
                {
                    closeTopbar();
                }                                            
            }"),
        ],
        'options' => ['class' => 'btn btn-primary', 'type' => 'submit', 'id' =>'add-button'],
    ]);
    AjaxSubmitButton::end();
    
    ActiveForm::end()
```

> As you can see it's quite easy to use the widget with ActiveForm - enough to set the ActiveForm's id to the 'useWithActiveForm' variable. (In this case id is 'add-form', without '#' symbol!).


### Client validation

As I said before the widget can be used with ActiveForm and client validation enabled. If you wish to disable it, just set ActiveForm's 'enableClientValidation' to false.

```php
    $form = ActiveForm::begin([
                'id' => 'filters-form',
                'enableClientValidation' => false
            ]);
```

### Preloader use

It's possible to use the widget with your own custom preloader.

```php
<?php AjaxSubmitButton::begin([
    'label' => 'Check',
    'ajaxOptions' => [
        'type'=>'POST',
        'url'=>'country/getinfo',
        'beforeSend' => new \yii\web\JsExpression('function(html){
            ... show preloader...
            }'),
        'success' => new \yii\web\JsExpression('function(html){
            ... hide preloader ...
            }'),
    ],
    'options' => ['class' => 'customclass', 'type' => 'submit'],
    ]);
    AjaxSubmitButton::end();
?>
```

### Widget's options

Variable | Description | Type
------------ | ------------- | -------------
ajaxOptions | ajax options | Array
options | HTML attributes and other options of the widget's container tag | Array
tagName | the tag to use to render the button (by default is 'button'. You can specify, for example, 'a' tag) | String
label | button's label | String
encodeLabel | whether the label should be HTML-encoded | Boolean
clickedButtonVarName | js object name. It is unused when useWithActiveForm is enabled | String
useWithActiveForm | whether the button should not be used with ActiveForm. the id of ActiveForm to use the button with | Boolean / String

## Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require demogorgorn/yii2-ajax-submit-button "*"
```

or add

```
"demogorgorn/yii2-ajax-submit-button": "*"
```

to the require section of your `composer.json` file and run `composer update`.

