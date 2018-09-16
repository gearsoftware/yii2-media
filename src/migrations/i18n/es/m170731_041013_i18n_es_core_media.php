<?php

/**
 * @package   Yii2-Media
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\db\TranslatedMessagesMigration;

class m170731_041013_i18n_es_core_media extends TranslatedMessagesMigration
{
	public function getLanguage()
	{
		return 'es-ES';
	}

	public function getCategory()
	{
		return 'core/media';
	}

	public function getTranslations()
	{
		return [
			'Add files' => 'Agregar archivos',
			'Album' => 'Álbum',
			'Albums' => 'Álbumes',
			'All Media Items' => 'Todos los archivos',
			'Alt Text' => 'Texto alternativo',
			'Back to file manager' => 'Volver al administrador de archivos',
			'Cancel upload' => 'Cancelar la subida',
			'Categories' => 'Categorías',
			'Category' => 'Categoría',
			'Changes have been saved.' => 'Los cambios han sido guardados.',
			'Changes haven\'t been saved.' => 'Los cambios no se han guardado.',
			'Create Category' => 'Crear categoría',
			'Current thumbnail sizes' => 'Tamaños actual de miniaturas',
			'Dimensions' => 'Dimensiones',
			'Do resize thumbnails' => 'Redimensionar tamaño de las miniaturas',
			'File Size' => 'Tamaño del archivo',
			'Filename' => 'Nombre del archivo',
			'If you change the thumbnails sizes, it is strongly recommended resize image thumbnails.' => 'Si cambia los tamaños de las miniaturas, es muy recomendable ejecutar "Redimensionar tamaño de las miniaturas".',
			'Image Settings' => 'Ajustes de imagen',
			'Large size' => 'Tamaño grande',
			'Manage Albums' => 'Administrar álbumes',
			'Manage Categories' => 'Administrar categorías',
			'Media Activity' => 'Actividad de los archivos',
			'Media Details' => 'Detalles del archivo',
			'Media' => 'Archivos',
			'Medium size' => 'Tamaño mediano',
			'No files found.' => 'No se encontraron archivos.',
			'Original' => 'Original',
			'Please, select file to view details.' => 'Por favor, seleccione el archivo para ver los detalles.',
			'Select image size' => 'Seleccionar el tamaño de la imagen',
			'Small size' => 'Tamaño pequeño',
			'Sorry, [{filetype}] file type is not permitted!' => '¡Lo sentimos, el tipo de archivo [{filetype}] no está permitido!',
			'Start upload' => 'Iniciar la subida',
			'Thumbnails settings' => 'Configuración de miniaturas',
			'Thumbnails sizes has been resized successfully!' => '¡Los tamaños de las miniaturas se han redimensionado con éxito!',
			'Thumbnails' => 'Thumbnails',
			'Update Category' => 'Actualizar categoría',
			'Updated By' => 'Actualizado por',
			'Upload New File' => 'Subir nuevo archivo',
			'Uploaded By' => 'Subido por',
		];
	}
}
