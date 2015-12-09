<?php
namespace Craft;

class PlainMetaVariable
{

	// Output
	public function output($entry = false, $fallback = false)
	{
		return craft()->plainMeta->outputPlainMeta($entry, $fallback);
	}

	// Get Asset by Id
	public function asset($id)
	{
		return craft()->plainMeta->getAssetById($id);
	}

	public function getVideoUrl($string)
	{
		return craft()->plainMeta->parseVideos($string);
	}
}
