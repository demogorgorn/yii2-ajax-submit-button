AjaxSubmitButton for Yii 2
=====================================

This is the AjaxSubmitButton widget that renders an ajax button which is very similar to ajaxSubmitButton from Yii1 for Yii 2. 

Example of usage of the widget with form and other custom widget (in this case Select2 widget).

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
        /*'cache' => false,*/
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

Please note: that #output is a div element which will be updated.

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

Installation
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

