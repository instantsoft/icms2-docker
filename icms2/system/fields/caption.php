<?php

class fieldCaption extends cmsFormField {

    public $title       = LANG_PARSER_CAPTION;
    public $is_public   = false;
    public $sql         = 'varchar({max_length}) NULL DEFAULT NULL';
    public $filter_type = 'str';
    public $allow_index = true;
    public $var_type    = 'string';

    protected $is_set_rules = false;

    public function getOptions(){

        return array(
            new fieldNumber('min_length', array(
                'title' => LANG_PARSER_TEXT_MIN_LEN,
                'default' => 0
            )),
            new fieldNumber('max_length', array(
                'title' => LANG_PARSER_TEXT_MAX_LEN,
                'default' => 255
            )),
            new fieldCheckbox('in_fulltext_search', array(
                'title' => LANG_PARSER_IN_FULLTEXT_SEARCH,
                'default' => true
            ))
        );

    }

    public function getRules() {

        if(!$this->is_set_rules){
            if ($this->getOption('min_length')){
                if(array_search(array('required'), $this->rules) === false){
                    $this->rules[] = array('required');
                }
                $this->rules[] = array('min_length', $this->getOption('min_length'));
            }

            if ($this->getOption('max_length')){
                $this->rules[] = array('max_length', $this->getOption('max_length'));
            }
            $this->is_set_rules = true;
        }

        return $this->rules;

    }

    public function parse($value){
        return '<h1>'.html($value, false).'</h1>';
    }

    public function getStringValue($value){
        return $value;
    }

    public function store($value, $is_submitted, $old_value=null){
        return strip_tags($value);
    }

    public function applyFilter($model, $value) {
        return $model->filterLike($this->name, "%{$value}%");
    }

}
