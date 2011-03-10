<?php
class EGalleria extends CWidget
{
    /**
     * Options for galleria plugin by user
     * For details: http://galleria.aino.se/docs/1.2/options/
     *
     * @var array
     **/
    public $galleria = null;

    /**
     * Dataprovider passed by user.
     * 
     * @array CDataProvider
     **/
    public $dataProvider = null; 
     
    /**
     * Available galleria options.
     * Loaded form EGalleria/galleria.options.php
     *
     * @var array
     **/
    private $avOptions = array();
    /**
     * Binding between model passed in dataProvider
     * This can be defined with behaviors() or in 
     * the initialization of this widget.
     * 
     * @var array
     **/
    public $binding = null;

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
        $this->avOptions = require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."galleria.options.php");
        echo "<div id='egalleria_".$this->id."' >";
        parent::init();
    }
    public function run()
    {  
        $initialize = array();
        if(is_array($this->galleria)) {
            foreach($this->galleria as $option => $value ){
                if(in_array($option, $this->avOptions))
                    $initialize[$option] = $value;
            }
        }
        foreach(array("width", "height") as $dim)
        {
            if(!isset($initialize[$dim]))
                $initialize[$dim] = 500;
            else if ((is_string($initialize[$dim])) && ($initialize[$dim] != "auto" )) {
                $position = strpos($initialize[$dim], "px");
                if( $position > 0 ) {
                    $value = (int)substr($initialize[$dim], 0 , $position);
                }
                if( $value == 0 )
                    $value = 500;
                $initialize[$dim] = $value;    
            }
        }
        if(isset($this->dataProvider) && !isset($this->binding)) {
            $behavior = $this->dataProvider->model->behaviors();
            if(!empty($behavior)) {
                foreach($behavior as $name => $bind)
                {
                    if(strtolower($name) == "egalleria")
                        $this->binding = $bind;
                }
            }
            /**
            if(!isset($this->binding)) {
                return 
            }**/
        }
        $img = $this->binding["image"];

        $x = $this->dataProvider->getData();
        foreach($x as $k=>$modela)
        {
            echo CHtml::image("protected/data/".$modela->$img);
        }
        echo "<script>";
        echo "var jsn = eval(".CJSON::encode($initialize).");";
        echo "console.log(jsn);";
        echo '$("#egalleria_'.$this->id.'").galleria(jsn);';
        echo "</script>";
        echo "<div>";
    }
}
