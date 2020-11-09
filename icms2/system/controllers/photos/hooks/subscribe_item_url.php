<?php

class onPhotosSubscribeItemUrl extends cmsAction {

    public function run($subscription){

        $url = href_to_rel($this->name); $params = array();

        if(!empty($subscription['params']['filters'])){

            $filter_panel = array(
                'type'        => (!empty($this->options['types']) ? (array('' => LANG_PHOTOS_ALL) + $this->options['types']) : array()),
                'orientation' => modelPhotos::getOrientationList(),
                'width'       => '',
                'height'      => ''
            );

            // альбом
            if($subscription['params']['filters'][0]['field'] == 'album_id'){

                $album = $this->model->getAlbum($subscription['params']['filters'][0]['value']);

                if(!$album){ return false; }

                $url = href_to_rel($album['ctype']['name'], $album['slug'].'.html');

                unset($subscription['params']['filters'][0]);

            }

            foreach ($subscription['params']['filters'] as $filters) {
                if(is_array($filter_panel[$filters['field']]) && isset($filter_panel[$filters['field']][$filters['value']])){
                    $params[$filters['field']] = $filters['value'];
                }
                if(is_string($filter_panel[$filters['field']]) && is_numeric($filters['value'])){
                    $params[$filters['field']] = $filters['value'];
                }
            }

            if(!empty($params)){
                $url .= '?'.http_build_query($params);
            }

        }

        return $url;

    }

}
