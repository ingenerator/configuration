<?php
/**
 * @author     Andrew Coulton <andrew@ingenerator.com>
 * @copyright  inGenerator Ltd
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

	public static function initialise(Config $config)
	{
		$config->attach(new Config_File);
		$config->attach(new JsonConfigReader(APPPATH.'/config/deployment_config_overrides.json'));
		if (file_exists(self::user_config_path()))
		{
			$config->attach(new JsonConfigReader(self::user_config_path()));
		}
		return $config;
	}

} 
