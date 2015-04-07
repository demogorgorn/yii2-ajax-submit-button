<?php
namespace demogorgorn\ajax;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * AjaxSubmitButton renders an ajax button which is very similar to ajaxSubmitButton from Yii1.
 *
 * Example:
 *
 * ```php
 * <?= Html::beginForm(); ?>
 * <?= Select2::widget([
 *       'name' => 'country_code',
 *       'data' => Country::getAllCountries(),
 *       'options' => [
 *           'id' => 'country_select',
 *           'multiple' => false, 
 *           'placeholder' => 'Select country...',
 *           'class' => 'uk-width-medium-7-10'
 *       ]
 *   ]);?>
 *
 * <?php AjaxSubmitButton::begin([
 *       'label'=>'Проверить',
 *       'ajaxOptions'=>
 *           [
 *               'type'=>'POST',
 *               'url'=>'country/getinfo',
 *               'cache' => false,
 *               'success' => new \yii\web\JsExpression('function(html){
 *                   $("#output").html(html);
 *               }'),
 *           ],
 *           'options' => ['type' => 'submit'],
 *       ]);
 *  AjaxSubmitButton::end();?>
 *
 * <?= Html::endForm(); ?>
 * ```
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 */

class AjaxSubmitButton extends Widget
{
    public $ajaxOptions = [];

    /**
	 * @var array the HTML attributes for the widget container tag.
	 */
	public $options = [];

    /**
	 * @var string the tag to use to render the button
	 */
	public $tagName = 'button';
	/**
	 * @var string the button label
	 */
	public $label = 'Button';
	/**
	 * @var boolean whether the label should be HTML-encoded.
	 */
	public $encodeLabel = true;

    public $clickedButtonVarName = '_clickedButton';

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		if (!isset($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}
	}

    public function run()
    {
    	parent::run();

    	echo Html::tag($this->tagName, $this->encodeLabel ? Html::encode($this->label) : $this->label, $this->options);
        
        if (!empty($this->ajaxOptions)) {
            $this->registerAjaxScript();
        }
    }

    protected function registerAjaxScript()
    {
        $view = $this->getView();

        if(!isset($this->ajaxOptions['type'])) {
            $this->ajaxOptions['type'] = new JsExpression('$(this).parents("form").attr("method")');
        }

        if(!isset($this->ajaxOptions['url'])) {
            $this->ajaxOptions['url'] = new JsExpression('$(this).parents("form").attr("action")');
        }

        if(!isset($this->ajaxOptions['data']) && isset($this->ajaxOptions['type']))
            $this->ajaxOptions['data'] = new JsExpression('$(this).parents("form").serialize()');

        $this->ajaxOptions= Json::encode($this->ajaxOptions);
        $view->registerJs("$('#".$this->options['id']."').click(function() {
                " . (null !== $this->clickedButtonVarName ? "var {$this->clickedButtonVarName} = this;" : "") . "
                $.ajax(" . $this->ajaxOptions . ");
                return false;
            });");
    }

} 

