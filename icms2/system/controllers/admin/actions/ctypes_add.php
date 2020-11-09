<?php

class actionAdminCtypesAdd extends cmsAction {

    public function run(){

        $form = $this->getForm('ctypes_basic', array('add', []));

        $form = cmsEventsManager::hook('ctype_basic_form', $form);

        $is_submitted = $this->request->has('submit');

        $ctype = $form->parse($this->request, $is_submitted);

        if ($is_submitted){

            $errors = $form->validate($this, $ctype);

            if (!$errors){
                if(cmsCore::isControllerExists($ctype['name'])){
                    $errors['name'] = LANG_CP_CTYPE_ERROR_NAME;
                }
            }

            if (!$errors){

                $ctype = cmsEventsManager::hook('ctype_before_add', $ctype);
                $ctype = cmsEventsManager::hook("ctype_{$ctype['name']}_before_add", $ctype);

                $ctype_id = $this->model_content->addContentType($ctype);

                $ctype['id'] = $ctype_id;

                cmsEventsManager::hook('ctype_after_add', $ctype);
                cmsEventsManager::hook("ctype_{$ctype['name']}_after_add", $ctype);

                if ($ctype_id){

                    $this->addCtypeWidgetsPages($ctype);

                    cmsUser::addSessionMessage(sprintf(LANG_CP_CTYPE_CREATED, $ctype['title']), 'success');

                }

                $this->redirectToAction('ctypes', array('labels', $ctype_id), array('wizard_mode'=>true));

            }

            if ($errors){
                cmsUser::addSessionMessage(LANG_FORM_ERRORS, 'error');
            }

        }

        return $this->cms_template->render('ctypes_basic', array(
            'do'     => 'add',
            'ctype'  => $ctype,
            'form'   => $form,
            'errors' => isset($errors) ? $errors : false
        ));

    }

}
