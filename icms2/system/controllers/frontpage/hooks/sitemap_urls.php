<?php

class onFrontpageSitemapUrls extends cmsAction {

    public function run($name){

        return array(
            array(
                'last_modified' => date('Y-m-d'),
                'title'         => LANG_HOME,
                'url'           => href_to_home(true)
            )
        );

    }

}
