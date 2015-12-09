<?php

/**
 * PlainMeta by Plain Language
 *
 * @package   PlainMeta
 * @author    Plain Language
 * @copyright Copyright (c) 2015, Plain Language
 * @link      http://plainlanguage.co
 * @license   GNU Public License (http://opensource.org/licenses/gpl-license.php)
 */

namespace Craft;

class PlainMetaPlugin extends BasePlugin
{

	public function getName()
	{
		return Craft::t('PlainMeta');
	}

	public function getVersion()
	{
		return '1.0';
	}

	public function getDeveloper()
	{
		return 'Plain Language';
	}

	public function getDeveloperUrl()
	{
		return 'http://plainlanguage.co';
	}

}
