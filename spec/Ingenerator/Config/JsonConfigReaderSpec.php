<?php
/**
 * Defines JsonConfigReaderSpec - specifications for Ingenerator\Config\JsonConfigReader
 *
 * @author     Andrew Coulton <andrew@ingenerator.com>
 * @copyright  inGenerator Ltd
 * @licence    BSD
 */

namespace spec\Ingenerator\Config;

use Prophecy\Argument;
use spec\ObjectBehavior;

/**
 *
 * @see Ingenerator\Config\JsonReader
 */
class JsonConfigReaderSpec extends ObjectBehavior
{
    /**
     * Use $this->subject to get proper type hinting for the subject class
     * @var \Ingenerator\Config\JsonConfigReader
     */
	protected $subject;

	/**
	 * @var string
	 */
	protected $tmp_file;

	function let()
	{
		$this->beConstructedWith('/tmp/json_reader_test.json');
	}

	function letgo()
	{
		if ($this->tmp_file)
		{
			\unlink($this->tmp_file);
		}
	}

	function it_is_initializable()
    {
		$this->subject->shouldHaveType('Ingenerator\Config\JsonConfigReader');
	}

	function it_is_a_config_reader()
	{
		$this->subject->shouldHaveType('Kohana_Config_Reader');
	}

	function it_throws_on_construct_if_json_does_not_exist()
	{
		$this->shouldThrow('InvalidArgumentException')->during('__construct', array('/some_missing_json.json'));
	}

	function it_throws_on_construct_if_json_is_invalid()
	{
		$path = \tempnam(\sys_get_temp_dir(), 'badjson');
		\file_put_contents($path, '<some xml got here!>');
		$this->shouldThrow('InvalidArgumentException')->during('__construct', array($path));
		\unlink($path);
	}

	function it_returns_false_for_load_with_group_not_found_in_file()
	{
		$this->given_constructed_with_json_data(array('foo' => 'one'));
		$this->subject->load('bar')->shouldBe(FALSE);
	}

	function it_returns_deep_array_for_load_with_group_present_in_file()
	{
		$this->given_constructed_with_json_data(array(
				'foo' => 'one',
				'bar' => array(
					'baz' => 9,
				    'deep' => array('one'),
				)));
		$this->subject->load('bar')->shouldBe(array('baz' => 9, 'deep' => array('one')));
	}

	/**
	 * @param array $arr
	 */
	protected function given_constructed_with_json_data($arr)
	{
		$path = \tempnam(\sys_get_temp_dir(), 'jsonconfig');
		\file_put_contents($path, \json_encode($arr));
		$this->beConstructedWith($path);

		$this->tmp_file = $path;
	}

}
