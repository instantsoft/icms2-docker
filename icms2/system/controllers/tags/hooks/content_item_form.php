<?php

class onTagsContentItemForm extends cmsAction {

    public function run($data) {

        list($form, $item, $ctype) = $data;

        if ($ctype['is_tags']) {

            $fieldset_id = $form->addFieldset(LANG_TAGS, 'tags_wrap', array('is_collapsed' => !empty($ctype['options']['is_collapsed']) && in_array('tags_wrap', $ctype['options']['is_collapsed'])));

            $form->addField($fieldset_id, new fieldString('tags', array(
                'hint'         => LANG_TAGS_HINT,
                'options'      => array(
                    'max_length'        => 1000,
                    'show_symbol_count' => true
                ),
                'autocomplete' => array(
                    'multiple' => true,
                    'url'      => href_to('tags', 'autocomplete')
                ),
                'rules' => array(
                    array(function($controller, $data, $value){

                        if(!$value){ return true; }

                        if(strpos($value, '?') !== false){
                            return ERR_VALIDATE_INVALID;
                        }

                        return true;

                    })
                )
            )));

        }

        return array($form, $item, $ctype);

    }

}
