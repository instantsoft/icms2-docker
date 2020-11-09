<?php

$title = ($do == 'edit') ? $country['name'] : LANG_GEO_ADD_COUNTRY;

$this->addBreadcrumb($title);

$this->addToolButton(array(
    'class' => 'save',
    'title' => LANG_SAVE,
    'href'  => 'javascript:icms.forms.submit()'
));
$this->addToolButton(array(
    'class' => 'cancel',
    'title' => LANG_CANCEL,
    'href'  => $this->href_to('')
));

$this->renderForm($form, $country, array(
    'action' => '',
    'method' => 'post',
), $errors);
