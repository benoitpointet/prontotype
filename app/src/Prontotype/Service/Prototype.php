<?php

namespace Prontotype\Service;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Yaml\Yaml;

class Prototype implements ServiceProviderInterface
{

    protected $app;

    protected $default;

    public function register ( Application $app )
    {
        $this->app = $app;

        $this->default = array(
                'domain' => 'default',
                'base_path' => '.',
                'base_url' => '/',
                'key' => 'default',
            );
        $config = array();

        $filename = DOC_ROOT . "/prototypes.yml";

        if (!file_exists($filename)) {
            // default to base prototype
            $app['prototype'] = $this->default;

            return;
        }

        $config = Yaml::parse($filename);

        if (null === $config) {
            throw new \InvalidArgumentException(sprintf("The config file '%s' appears to be invalid YAML.", $filename));
        }

        $app['prototypes'] = $config['prototypes'];

        // set default prototype
        $current = $app['prototypes']['default'];

        // identify current prototype
        $host = $_SERVER['HTTP_HOST'];
        $path = $_SERVER['REQUEST_URI'];

        foreach ($app['prototypes'] as $key => $p) {
            $p['key'] = $key;

            // check mandatory keys
            foreach (array('domain') as $param) {
                if (!isset($p[$param])) {
                    throw new \InvalidArgumentException(sprintf("The configuration of prototype '%s' in file '%s' misses '%s' key.", $p['key'], $filename, $param));
                }
            }

            // check optional keys
            foreach (array('base_path', 'base_url') as $param) {
                if (!isset($p[$param])) {
                    $p[$param] = $this->default[$param];
                }
            }

            // match prototype
            if ($p['domain'] == $host && strpos($path, $p['base_url']) === 0) {
                $current = $p;

                $app['prototype'] = $current;

                return;
            }
        }
    }

    public function boot ( Application $app ) {}

}
