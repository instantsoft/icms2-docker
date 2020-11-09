<?php

    $this->addTplJSName([
        'photos',
        'jquery-owl.carousel'
    ]);

    $this->addTplCSSName('jquery-owl.carousel');
    $this->addTplCSS('controllers/photos/styles');

    $photo_wrap_id = 'widget-photos-'.$widget->id;

?>

<div class="album-photos-wrap owl-carousel" id="<?php echo $photo_wrap_id; ?>"<?php if ($is_owner) { ?> data-delete-url="<?php echo href_to('photos', 'delete'); ?>"<?php } ?>>
    <?php echo $this->renderControllerChild('photos', 'photos', array(
        'photos'        => $photos,
        'is_owner'      => $is_owner,
        'user'          => $user,
        'photo_wrap_id' => $photo_wrap_id,
        'preset_small'  => $preset_small,
        'disable_owner' => true,
        'disable_flex'  => true
    )); ?>
</div>

<?php ob_start(); ?>
<script type="text/javascript">
    $(function(){
        icms.photos.initCarousel('#<?php echo $photo_wrap_id; ?>');
    });
</script>
<?php $this->addBottom(ob_get_clean()); ?>