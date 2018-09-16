<div role="media-modal" class="modal" tabindex="-1"
     data-frame-id="<?= $frameId ?>"
     data-frame-src="<?= $frameSrc ?>"
     data-btn-id="<?= $btnId ?>"
     data-input-id="<?= $inputId ?>"
     data-image-container="<?= isset($imageContainer) ? $imageContainer : '' ?>"
     data-paste-data="<?= isset($pasteData) ? $pasteData : '' ?>"
     data-thumb="<?= $thumb ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 15px;">
                <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                <h4 class="modal-title" style="font-size: 1.7em; font-weight: normal;" id="myLargeModalLabel"><?= Yii::t('core/media', 'Media'); ?>
                    <small></small></h4>
            </div>
            <div class="modal-body"></div>
            <!--<div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <button class="btn btn-primary">Save changes</button>
            </div>!-->
        </div>
    </div>
</div>