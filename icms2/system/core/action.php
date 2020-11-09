<?php
class cmsAction {

    protected $controller;
    protected $params;

    protected $extended_langs = [];

    public function __construct($controller, $params=array()){
        $this->controller = $controller;
        $this->params = $params;

        if($this->extended_langs){
            foreach ($this->extended_langs as $controller_name) {
                cmsCore::loadControllerLanguage($controller_name);
            }
        }
    }

    public function __get($name) {
        return $this->controller->$name;
    }

    public function __set($name, $value) {
        $this->controller->$name = $value;
    }

    public function __isset($name) {
        return isset($this->controller->$name);
    }

    public function __unset($name) {
        unset($this->controller->$name);
    }

    public function __call($name, $arguments) {
        return call_user_func_array(array($this->controller, $name), $arguments);
    }

}
