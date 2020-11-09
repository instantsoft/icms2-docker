<?php

    $this->addHead('<link rel="canonical" href="'.href_to_abs($ctype['name'], $item['slug'] . '.html').'"/>');

    $this->renderContentItem($ctype['name'], array(
        'item'             => $item,
        'ctype'            => $ctype,
        'fields'           => $fields,
        'fields_fieldsets' => $fields_fieldsets,
        'props'            => $props,
        'props_values'     => $props_values,
        'props_fields'     => $props_fields,
        'props_fieldsets'  => $props_fieldsets,
    ));

    if (!empty($childs['lists'])){
        foreach($childs['lists'] as $list){
            if ($list['title']){ ?><h2><?php echo $list['title']; ?></h2><?php }
            echo $list['html'];
        }
    }

?>

<?php if ($item['is_approved'] && $item['approved_by'] && ($user->is_admin || $user->id == $item['user_id'])){ ?>
    <div class="content_moderator_info">
        <?php echo LANG_MODERATION_APPROVED_BY; ?>
        <a href="<?php echo href_to('users', $item['approved_by']['id']); ?>"><?php echo $item['approved_by']['nickname']; ?></a>
        <span class="date"><?php echo html_date_time($item['date_approved']); ?></span>
    </div>
<?php } ?>

<?php if (!empty($item['comments_widget'])){ ?>
    <?php echo $item['comments_widget']; ?>
<?php } ?>