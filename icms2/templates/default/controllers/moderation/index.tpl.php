<h1><?php echo $page_title; ?></h1>

<div id="moderation_content_pills">
    <?php $this->menu('moderation_content_types', true, 'pills-menu-small'); ?>
</div>

<div id="moderation_content_list"><?php echo $list_html; ?></div>