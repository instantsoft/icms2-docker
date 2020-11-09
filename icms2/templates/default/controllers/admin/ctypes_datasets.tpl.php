<h1><?php echo LANG_CONTENT_TYPE; ?>: <span><?php echo $ctype['title']; ?></span></h1>

<?php

    $this->setPageTitle(LANG_CP_CTYPE_DATASETS, $ctype['title']);

    $this->addBreadcrumb(LANG_CP_SECTION_CTYPES, $this->href_to('ctypes'));

    $this->addBreadcrumb($ctype['title'], $this->href_to('ctypes', array('edit', $ctype['id'])));
    $this->addBreadcrumb(LANG_CP_CTYPE_DATASETS);

    $this->addMenuItems('ctype', $this->controller->getCtypeMenu('datasets', $ctype['id']));

    $this->addToolButton(array(
        'class' => 'add',
        'title' => LANG_CP_DATASET_ADD,
        'href'  => $this->href_to('ctypes', array('datasets_add', $ctype['id']))
    ));
    $this->addToolButton(array(
        'class' => 'save',
        'title' => LANG_SAVE_ORDER,
        'href'  => null,
        'onclick' => "icms.datagrid.submit('{$this->href_to('ctypes', array('datasets_reorder', $ctype['id']))}')"
    ));
    $this->addToolButton(array(
        'class' => 'view_list',
        'title' => LANG_CP_CTYPE_TO_LIST,
        'href'  => $this->href_to('ctypes')
    ));
	$this->addToolButton(array(
		'class' => 'help',
		'title' => LANG_HELP,
		'target' => '_blank',
		'href'  => LANG_HELP_URL_CTYPES_DATASETS
	));

?>

<div class="pills-menu">
    <?php $this->menu('ctype'); ?>
</div>

<?php $this->renderGrid($this->href_to('ctypes', array('datasets', $ctype['id'])), $grid); ?>

<div class="buttons">
    <?php echo html_button(LANG_SAVE_ORDER, 'save_button', "icms.datagrid.submit('{$this->href_to('ctypes', array('datasets_reorder', $ctype['id']))}')"); ?>
</div>