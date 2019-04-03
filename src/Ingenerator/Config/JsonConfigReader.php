<?php
/**
 * Reads config from a JSON file - used to override any custom configuration
 *
 * @author    Andrew Coulton <andrew@ingenerator.com>
 * @copyright 2014 inGenerator Ltd
 * @licence   BSD
 */

namespace Ingenerator\Config;

class JsonConfigReader implements \Kohana_Config_Reader{


	/**
	 * @var array data from the config file
	 */
	protected $data = array();

	/**
	 * @param string $json_path
	 */
	public function __construct($json_path)
	{
		if ( ! \is_readable($json_path)) {
			throw new \InvalidArgumentException("File $json_path does not exist or is not readable");
		}

		if (NULL === $this->data = \json_decode(\file_get_contents($json_path), TRUE)) {
			throw new \InvalidArgumentException("File $json_path contains invalid JSON");
		}
	}

	/**
	 * Tries to load the specified configuration group
	 *
	 * Returns FALSE if group does not exist or an array if it does
	 *
	 * @param  string $group Configuration group
	 *
	 * @return boolean|array
	 * @see \Kohana_Config_File
	 */
	public function load($group)
	{
		return \Arr::get($this->data, $group, FALSE);
	}

} 
