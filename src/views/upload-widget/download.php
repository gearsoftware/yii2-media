<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td style="text-align: center;">
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="<?= \Yii::t('core', 'Download') ?> {%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" style="width: 70px;"></a>
                {% } else { %}
                    {% if (file.FA) { %}
                        <a href="{%=file.url%}" title="<?= \Yii::t('core', 'Download') ?> {%=file.name%}" download="{%=file.name%}" data-gallery>
                            <span>
                                <i class="{%=file.FA['name']%}" style="color:{%=file.FA['color']%}; font-size: 5em; padding-left: 7px;"></i>
                            </span>
                        </a>
                    {% } %}
                {% } %}
            </span>
        </td>
        <td>
            {% if (file.name) { %}
                <p class="name">
                    {% if (file.url) { %}
                        <a class="link" href="{%=file.url%}" title="<?= \Yii::t('core', 'Open in a new tab') ?> {%=file.name%}" target="_blank">{%=file.name%}</a>
                    {% } else { %}
                        <span>{%=file.name%}</span>
                    {% } %}
                </p>
            {% } %}
            {% if (file.error) { %}
                <div><span class="label label-danger"><?= \Yii::t('core', 'Error') ?></span> {%=file.error%}</div>
            {% } %}
        </td>
        <td style="text-align: center;">
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            <div class="row">
                {% if (file.url) { %}
                    <div class="col-sm-6" style="padding: 2px;">
                        <div class="form-group mar-no">
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" class="btn btn-success" style="width: 100%;">
                                <i class="glyphicon glyphicon-download"></i>
                                <span><?= \Yii::t('core', 'Download') ?></span>
                            </a>
                        </div>
                    </div>
                {% } %}
                <div class="col-sm-6" style="padding: 2px;">
                    <div class="form-group mar-no">
                        {% if (file.deleteUrl) { %}
                            <button  style="width: 100%;" class="btn btn-default delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                <i class="glyphicon glyphicon-trash"></i>
                                <span><?= \Yii::t('core', 'Delete') ?></span>
                            </button>
                        {% } else { %}
                            <button style="width: 100%;" class="btn btn-default cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span><?= \Yii::t('core', 'Cancel') ?></span>
                            </button>
                        {% } %}
                    </div>
                </div>
            </div>
        </td>
    </tr>
{% } %}




</script>
