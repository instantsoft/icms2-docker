<?php

class actionAdminUsersGroupReorder extends cmsAction {

    public function run(){

        $items = [];

        $_items = $this->request->get('items', array());
        if (!$_items){ cmsCore::error404(); }

        foreach ($_items as $_item) {
            if(!empty($_item['key']) && is_numeric($_item['key'])){
                $items[] = $_item['key'];
            }
        }

        if (!$items){ cmsCore::error404(); }

        $this->model->reorderByList('{users}_groups', $items);

        if ($this->request->isAjax()){
			return $this->cms_template->renderJSON(array(
				'error' => false,
				'success_text' => LANG_CP_ORDER_SUCCESS
			));
        }

        cmsUser::addSessionMessage(LANG_CP_ORDER_SUCCESS, 'success');

        $this->redirectBack();

    }

}
