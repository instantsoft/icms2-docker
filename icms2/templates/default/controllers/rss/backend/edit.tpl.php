<?php

    $this->addBreadcrumb($feed['title']);

    $this->addToolButton(array(
        'class' => 'save',
        'title' => LANG_SAVE,
        'href'  => "javascript:icms.forms.submit()"
    ));

    $this->addToolButton(array(
        'class' => 'cancel',
        'title' => LANG_CANCEL,
        'href'  => $this->href_to('')
    ));

?>

<h2><?php echo $feed['title']; ?></h2>

<?php
    $this->renderForm($form, $feed, array(
        'action' => '',
        'method' => 'post'
    ), $errors);
