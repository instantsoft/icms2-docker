<?php

class actionAdminContentCatsOrder extends cmsAction {

    private $total_nodes = 0;

    public function run($ctype_id){

        $content_model = cmsCore::getModel('content');

        $ctype = $content_model->getContentType($ctype_id);
        if (!$ctype) { return cmsCore::error404(); }

        $categories = $content_model->getCategoriesTree($ctype['name'], false);

        if ($this->request->has('submit')){

            $hash = $this->request->get('hash', '');

            cmsUser::setCookiePublic('content_tree_path', "{$ctype_id}.1");

            $this->reorderCategoriesTree($content_model, $ctype, $categories, $hash);

            cmsUser::addSessionMessage(LANG_CP_ORDER_SUCCESS, 'success');

            $this->redirectBack();

        }

        return $this->cms_template->render('content_cats_order', array(
            'ctype'      => $ctype,
            'categories' => $categories
        ));

    }

    private function reorderCategoriesTree($model, $ctype, $categories, $hash){

        $hash = json_decode($hash, true);

        $this->total_nodes = 0;

        $tree = $this->prepareTree($hash);

        $tree = $this->buildNestedSet($tree);

        $model->updateCategoryTree($ctype['name'], $tree, $this->total_nodes);

    }

    private function countChilds($tree, $count){

        foreach($tree as $idx => $node){

            if (!empty($node['children'])){
                $my_count = sizeof($node['children']);
                $count = $my_count + $this->countChilds($node['children'], $count);
            }

        }

        return $count;

    }

    private function prepareTree($tree, $parent_key=1){

        foreach($tree as $idx => $node){

            unset($node['expand']);
            unset($node['activate']);
            unset($node['isFolder']);

            $node['parent_key'] = $parent_key;

            if (!empty($node['children'])){
                $count = sizeof($node['children']);
                $node['children'] = $this->prepareTree($node['children'], $node['key']);
                $node['children_count'] = $this->countChilds($node['children'], $count);
            } else {
                $node['children_count'] = 0;
            }

            $tree[$idx] = $node;
            $this->total_nodes++;

        }

        return $tree;

    }

    private function buildNestedSet($tree, $left=1, $level=1){

        foreach($tree as $idx => $node){

            $left++;

            $node['left'] = $left;
            $node['level'] = $level;

            if (!empty($node['children'])){

                $node['right'] = $left + ($node['children_count']*2) + 1;

                $child_level = $level+1;

                $node['children'] = $this->buildNestedSet($node['children'], $left, $child_level);

            } else {

                $node['right'] = $node['left'] + 1;

            }

            $left = $node['right'];

            $tree[$idx] = $node;

        }

        return $tree;

    }

}
