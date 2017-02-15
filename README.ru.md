# AjaxSubmitButton для Yii 2
=====================================

[![Latest Stable Version](https://poser.pugx.org/demogorgorn/yii2-ajax-submit-button/v/stable)](https://packagist.org/packages/demogorgorn/yii2-ajax-submit-button)
[![Total Downloads](https://poser.pugx.org/demogorgorn/yii2-ajax-submit-button/downloads)](https://packagist.org/packages/demogorgorn/yii2-ajax-submit-button)
[![License](https://poser.pugx.org/demogorgorn/yii2-ajax-submit-button/license)](https://packagist.org/packages/demogorgorn/yii2-ajax-submit-button)
[![Monthly Downloads](https://poser.pugx.org/demogorgorn/yii2-ajax-submit-button/d/monthly)](https://packagist.org/packages/demogorgorn/yii2-ajax-submit-button)
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)


AjaxSubmitButton это достаточно полезный и мощный виджет для создания ajax кнопки любой сложности, в т.ч. для работы с ActiveForm, обычной формой либо для использования в качестве самостоятельного элемента. Является аналогом ajaxSubmitButton в Yii1, но имеет ряд особенностей и полезных функций.

### Базовый пример

Использование с произвольным виджетом в обычной форме (в данном случае произвольный виджет - Select2).

Представление (view):
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

> Обратите внимание: элемент с id #output - это элемент, содержимое которого будет обновлено при удачном выполнении ajax запроса.

Контроллер (controller):
```php
public function actionGetinfo()
{
    if(!isset($_POST['country_code']) || empty($_POST['country_code']))
        return;

    $code = $_POST['country_code'];

    return $this->renderAjax('resultwidget', ['code' => $code]);
}
```

### Пример использования с ActiveForm и включенной клиентской валидацией (client validation)

Представление:
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

> Как видите использовать виджет с ActiveForm очень легко и просто - достаточно задать параметр id у ActiveForm, а также в параметре 'useWithActiveForm' указать id данной формы. (В данном примере id равен 'add-form', без символа '#'!).


### Клинтская валидация (Client validation)

Как я указал выше, виджет может быть использован с ActiveForm с включенной клиентской валидацией (см. пример выше). Если вы хотите отключить валидацию на клиенте, установите параметру 'enableClientValidation' значение равное 'false'.

```php
    $form = ActiveForm::begin([
                'id' => 'filters-form',
                'enableClientValidation' => false
            ]);
```

### Использование Preloader

Виджет можно использовать с произвольным preloader.

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

### Опции виджета

Параметр | Описание | Тип
------------ | ------------- | -------------
ajaxOptions | опции ajax запроса | Array
options | HTML атрибуты и другие опции тега контейнера для виджета | Array
tagName | имя тега для генерации кнопки (по умолчанию используется 'button'. Вы можете использовать, например, тег 'a') | String
label | Текст кнопки | String
encodeLabel | должен ли текст кнопки быть HTML-кодирован | Boolean
clickedButtonVarName | имя объекта js. Не используется (игнорируется), когда параметр useWithActiveForm задан | String
useWithActiveForm | должна ли кнопка использоваться в связке с ActiveForm. Указывается id ActiveForm, либо false, если не планируется использовать | Boolean / String

## Установка
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
