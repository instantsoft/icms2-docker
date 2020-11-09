<?php $this->addTplJSName('fileuploader'); ?>
<?php $this->addTplJSName('photos'); ?>
<?php $id = !empty($album['id']) ? $album['id'] : ''; ?>

<fieldset>

    <legend><?php echo LANG_PHOTOS; ?></legend>

    <div id="album-photos-widget" data-delete-url="<?php echo $this->href_to('delete'); ?>" data-wysiwyg_name="<?php echo $editor_params['editor']; ?>">

        <div class="previews_list">
            <?php if ($photos){ ?>
                <?php foreach($photos as $photo){ ?>
                    <?php $presets = array_keys($photo['image']); $small_preset = end($presets); ?>
                    <div class="preview block" rel="<?php echo $photo['id']; ?>">
                        <div class="thumb">
                            <a rel="edit_list" class="ajax-modal hover_image" href="<?php echo html_image_src($photo['image'], $preset_big, true); ?>">
                                <?php echo html_image($photo['image'], $small_preset, $photo['title']); ?>
                            </a>
                            <?php if(empty($is_edit)){ ?>
                            <div class="actions">
                                <a class="delete" href="#" onclick="return icms.photos.remove(<?php echo $photo['id']; ?>)">
                                    <?php echo LANG_DELETE; ?>
                                </a>
                            </div>
                            <?php } else { ?>
                                <?php foreach ($photo['image'] as $preset => $path) { ?>
                                    <?php if($preset == $small_preset){ continue; } ?>
                                        <a title="<?php echo $photo['sizes'][$preset]['width']; ?> x <?php echo $photo['sizes'][$preset]['height']; ?>" rel="edit_list" href="<?php echo html_image_src($photo['image'], $preset, true); ?>"></a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="info">
                            <div class="title">
                                <?php echo html_input('text', 'photos['.$photo['id'].']', $photo['title']); ?>
                            </div>
                            <div class="photo_content">
                                <?php echo html_wysiwyg('content['.$photo['id'].']', $photo['content_source'], $editor_params['editor'], $editor_params['options']); ?>
                            </div>
                            <div class="photo_additional">
                                <div class="photo_privacy">
                                    <?php echo html_select('is_private['.$photo['id'].']', array(LANG_PRIVACY_PUBLIC, LANG_PRIVACY_PRIVATE, LANG_PHOTOS_ACCESS_BY_LINK), $photo['is_private']); ?>
                                </div>
                                <?php if($types){ ?>
                                    <div class="photo_type">
                                        <?php echo html_select('type['.$photo['id'].']', $types, $photo['type']); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <?php if(empty($is_edit)){ ?>

            <div class="preview_template block" style="display:none">
                <div class="thumb">
                    <a class="ajax-modal hover_image" href="">
                        <img src="" />
                    </a>
                    <div class="actions">
                        <a class="delete" href="#">
                            <?php echo LANG_DELETE; ?>
                        </a>
                    </div>
                </div>
                <div class="info">
                    <div class="title">
                        <?php echo html_input('text', '', '', array('placeholder'=>LANG_PHOTOS_PHOTO_TITLE)); ?>
                    </div>
                    <div class="photo_content">
                        <textarea id="" class="textarea" name=""></textarea>
                    </div>
                    <div class="photo_additional">
                        <div class="photo_privacy">
                            <?php echo html_select('', array(LANG_PRIVACY_PUBLIC, LANG_PRIVACY_PRIVATE, LANG_PHOTOS_ACCESS_BY_LINK), (isset($album['is_private']) ? $album['is_private'] : 0)); ?>
                        </div>
                        <?php if($types){ ?>
                            <div class="photo_type">
                                <?php echo html_select('', $types); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php
            if($editor_params['editor']){
                // подключаем редактор, но не инициализируем
                echo html_wysiwyg('', '', $editor_params['editor'], $editor_params['options']);
            }
            ?>

            <div id="album-photos-uploader"></div>

            <script type="text/javascript">
                <?php echo $this->getLangJS('LANG_SELECT_UPLOAD', 'LANG_DROP_TO_UPLOAD', 'LANG_CANCEL', 'LANG_ERROR'); ?>
                icms.photos.createUploader('<?php echo $this->href_to('upload'); ?><?php echo $id ? '/' . $id : ''; ?>', function(){
                    var _album_id = $('#album_id').val();
                    if(!_album_id){
                        icms.modal.alert('<?php printf(LANG_PHOTOS_SELECT_ALBUM, $ctype['labels']['one']); ?>');
                        return false;
                    }
                    this.params = {
                        album_id: _album_id
                    };
                });
            </script>

        <?php } ?>

    </div>

</fieldset>