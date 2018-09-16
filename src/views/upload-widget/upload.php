<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td width="20%">
            <span class="preview"></span>
        </td>
        <td width="30%">
            <p class="name mar-no">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td width="30%">
            <p class="size mar-no" style="text-align: center;"><?= \Yii::t('core', 'Processing') ?>...</p>
            <div class="progress active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-primary progress-bar-striped" style="width:0%;"></div></div>
        </td>
        <td width="20%">
            <div class="row">
                {% if (!i && !o.options.autoUpload) { %}
                    <div class="col-sm-6" style="padding: 2px;">
                        <div class="form-group mar-no">
                            <button class="btn btn-primary start" style="width: 100%;" disabled>
                                <i class="glyphicon glyphicon-upload"></i>
                                <span><?= \Yii::t('core', 'Start') ?></span>
                            </button>
                        </div>
                    </div>
                {% } %}
                {% if (!i) { %}
                    <div class="col-sm-6" style="padding: 2px;">
                        <div class="form-group mar-no">
                            <button class="btn btn-default cancel" style="width: 100%;">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span><?= \Yii::t('core', 'Cancel') ?></span>
                            </button>
                        </div>
                    </div>
                {% } %}
            </div>
        </td>
    </tr>
{% } %}
</script>