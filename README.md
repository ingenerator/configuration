# Config - Useful extensions to the kohana config system, including for loading deployment config from a JSON

Config is a small set of classes that add useful functionality to the kohana config system. It includes a JSON config
reader, and a config initialiser that wraps up the process of loading all config files to make it easier to reload
config during build etc and reduce the size of your bootstrap.

## Installation

Add config to your composer.json and run `composer update` to install it.

```json
{
  "require": { "ingenerator/config": "0.1.*@dev" }
}
```

## Basic Usage

In your bootstrap:
```php
/**
 * Enable the composer autoloader
 */
require_once(__DIR__.'/../vendor/autoload.php');

\Ingenerator\Config\ConfigInitialiser::initialise(Kohana::$config);
```

To override the source control config (for example to allow for different database or service credentials in different 
environments) just drop a JSON file with the extra config at APPPATH.'/config/deployment_config_overrides.json'.

You can also provide simple user-overridable config by dropping a second JSON at APPPATH.'/config/user_config_overrides.json'.

## Testing and developing

config has a full suite of [PhpSpec](http://phpspec.net) specifications. You'll need a skeleton Kohana application to run them,
you can use [koharness](https://github.com/ingenerator/koharness) to create one.

Contributions will only be accepted if they are accompanied by well structured specs. Installing with composer should
get you everything you need to work on the project.

## License

config is copyright 2014 inGenerator Ltd and released under the [BSD license](LICENSE).
