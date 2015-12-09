<?php

/**
 * PlainMeta by Plain Language
 *
 * @package   PlainMeta
 * @author    Plain Language
 * @copyright Copyright (c) 2014, Plain Language
 * @link      http://synergema.com
 * @license   GNU Public License (http://opensource.org/licenses/gpl-license.php)
 */

namespace Craft;

class PlainMeta_PlainMetaFieldType extends BaseFieldType
{

	public function getName()
	{
		return Craft::t('PlainMeta');
	}

	public function defineContentAttribute()
	{
		return false;
	}

	public function modifyElementsQuery(DbCommand $query, $params)
	{
		if ($params !== null) {
			craft()->plainMeta->modifyQuery($query, $params);
		}
	}

	public function getInputHtml($name, $value)
	{

		// Include JavaScript & CSS
		craft()->templates->includeJsResource('plainmeta/plain.meta.js');
		craft()->templates->includeCssResource('plainmeta/plain.meta.css');


		// Whether any assets sources exist
		$sources = craft()->assets->findFolders();
		$variables['assetsSourceExists'] = count($sources);

		// URL to create a new assets source
		$variables['newAssetsSourceUrl'] = UrlHelper::getUrl('settings/assets/sources/new');

		if (!empty($value)) {
			$plainMetaModel = PlainMeta_PlainMetaModel::populateModel($value);
		} else {
			$plainMetaModel = new PlainMeta_PlainMetaModel;
			$plainMetaModel->handle = $name;
		}

		// Set assets
		$plainmetaAssets = array(
			'socialOGImage'                  => $plainMetaModel->socialOGImageId,
			// 'socialOGAudioContent'           => $plainMetaModel->socialOGAudioContentId,
			// 'socialOGVideoContent'           => $plainMetaModel->socialOGVideoContentId,
			'socialTwitterGalleryImages'     => $plainMetaModel->socialTwitterGalleryImagesId,
			'socialTwitterPhoto'             => $plainMetaModel->socialTwitterPhotoId,
			'socialTwitterProductImage'      => $plainMetaModel->socialTwitterProductImageId,
			'socialTwitterSummaryImage'      => $plainMetaModel->socialTwitterSummaryImageId,
			'socialTwitterSummaryLargeImage' => $plainMetaModel->socialTwitterSummaryLargeImageId,
		);

		foreach ($plainmetaAssets as $key => $value) {
			if ($value) {
				$asset = craft()->elements->getElementById($value);
				$variables[$key . 'Elements'] = array($asset);
				$variables[$key . 'Id'] = $asset->id;
			} else {
				$variables[$key . 'Elements'] = array();
				$variables[$key . 'Id'] = "";
			}
		}

		// Set element type
		$variables['elementType'] = craft()->elements->getElementType(ElementType::Asset);

		$data = array_merge($plainMetaModel->getAttributes(), $variables);

		return craft()->templates->render('plainmeta/input', $data);
	}

	public function prepValue($value)
	{
		return craft()->plainMeta->getPlainMeta($this);
	}

	public function onAfterElementSave()
	{
		return craft()->plainMeta->savePlainMeta($this);
	}
}
