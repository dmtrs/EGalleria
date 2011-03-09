<?php
class EGalleria extends CWidget
{
    public $autoplay = 1000;
    public $width = 500;
    public $height = 500;

    private $cssFiles = array('galleria.classic.css');
    private $jsFiles = array('galleria.js', 'galleria.classic.js');
    
    private $themePath = "theme";
    private $jsPath = "js";

    private $css;
    private $js;

    private $themeName = "classic";
    private $jsAssetPath = "";

    private function registerScripts()
    {
        $cs = Yii::app()->clientScript;

        if($this->css===null) {
            $cssFolder = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->themePath.DIRECTORY_SEPARATOR;
            $cssFolder .= $this->themeName.DIRECTORY_SEPARATOR;

            $cssAssetPath = Yii::app()->getAssetManager()->publish($cssFolder);
            foreach($this->cssFiles as $file)
            {
                $cs->registerCssFile($cssAssetPath.DIRECTORY_SEPARATOR.$file);
            }
        }
        if($this->js===null) {
            $jsPath = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->jsPath.DIRECTORY_SEPARATOR;

            if(!$cs->isScriptRegistered('jquery')) {
                $cs->registerCoreScript('jquery');
            }
            $this->jsAssetPath = Yii::app()->getAssetManager()->publish($jsPath);
            foreach($this->jsFiles as $file)
            {
                $cs->registerScriptFile($this->jsAssetPath.DIRECTORY_SEPARATOR.$file, CClientScript::POS_HEAD);
            }
        }
    }
    public function init()
    {    
        $this->registerScripts();
        parent::init();
    }
    public function run()
    {
        $dataProvider = new CActiveDataProvider("Stars");

        echo "<div id='".$this->id."'>";
        foreach($dataProvider->getData() as $model)
        {
            echo CHtml::image("protected/data/".$model->st_image);
        }
        echo "<script>";
        echo '$("#'.$this->id.'").galleria({
                width: '.$this->width.',
                height: '.$this->height.',
                autoplay: '.$this->autoplay.',
            });';
        echo "</script>";
        echo "<div>";
    }
}
