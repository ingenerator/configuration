<?php
/**
 * @author     Andrew Coulton <andrew@ingenerator.com>
 * @copyright  2014 inGenerator Ltd
 * @licence    BSD
 */

namespace Ingenerator\Config;

use Ingenerator\Config\JsonConfigReader;

/**
 * Initialises configuration for the application - used to allow reloading the same config in a behat test
 * when asserting that config has changed.
 */
class ConfigInitialiser {

	public static function user_config_path()
	{
		return APPPATH.'/config/user_config_overrides.json';
	}

	public static function deployment_config_path()
	{
		return APPPATH.'/config/deployment_config_overrides.json';
	}

	public static function initialise(\Config $config)
	{
		$config->attach(new \Config_File);
		foreach (
			array(self::deployment_config_path(), self::user_config_path())
			as $file
		) {
			if (\file_exists($file)) {
				$config->attach(new JsonConfigReader($file));
			}
		}
		return $config;
	}

} 
