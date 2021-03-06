<?php
/**
 *
 *
 * @author Matías E. Brown <mbrown at cespi.unlp.edu.ar>
 */
class dcWidgetFormChosenChoice extends sfWidgetFormChoice {


  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes );
    dcWidgetFormChosenChoice::addConfigurationOptions($this);
  }

  public function getJavaScripts()
  {
    return dcWidgetFormChosenChoice::getJavaScriptsIncludes();
  }

  public function getStylesheets()
  {
    return dcWidgetFormChosenChoice::getStylesheetsIncludes();
  }

  public static function getJavaScriptsIncludes()
  {
    return array("/dcReloadedFormExtraPlugin/js/chosen.jquery.js");
  }

  public static function getStylesheetsIncludes()
  {
    return array("/dcReloadedFormExtraPlugin/css/chosen.css" => "all");
  }

  public static function addConfigurationOptions($widget)
  {
    $widget->addOption('align_right', false);
    $widget->addOption('default_text', null);
    $widget->addOption('config', '{}');
  }

  public static function getWidgetInitializationJS($id, $value, $default_text, $config = null)
  {
    $tpl = <<<EOF
<script>
  jQuery(function($) {
    $('#%widget_id%').chosen($.extend({}, {
      no_results_text: '%no_results_text%',
      default_text:'%default_text%'
    }, %config%));
  });
</script>
EOF;
    return strtr($tpl, array(
      "%widget_id%" => $id,
      "%no_results_text%" => sfContext::getInstance()->getI18N()->__("No results match"),
      "%default_text%" => $default_text,
      '%config%' => $config ?: '{}',
    ));
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
    $default_text = $this->getOption('default_text', null);
    if($default_text){
      $default_text = __($default_text);
    }
    else{
      $default_text = $this->getOption('multiple')?__("Select Some Options").'...':__("Select an Option").'...';
    }
    $align_right = $this->getOption('align_right', null);
    if($align_right){
      if(!isset($attributes['class'])){
        $attributes['class'] = '';
      }
      $attributes['class'] .= ' chzn-select chzn-rtl';
    }
    if(!isset($attributes['style'])){
      $attributes['style'] = 'min-width: 300px; max-width: 700px;';
    }
    else{
      $attributes['style'] = '; min-width: 300px; max-width: 700px;';
    }
    $html = parent::render($name, $value, $attributes, $errors);
    $html .= dcWidgetFormChosenChoice::getWidgetInitializationJS($this->generateId($name), $value, $default_text);
    return $html;
  }
}
?>
