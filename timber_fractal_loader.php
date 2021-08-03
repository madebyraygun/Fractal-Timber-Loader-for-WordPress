<?php
/*
Plugin Name: Timber Fractal Loader for WordPress
Description: This plugin adds a custom Twig Loader to Timber to dynamically load fractal components from the components-map.json file.
Version: 1.0.0
Author: Raygun
Author URI: https://madebyraygun.com
Plugin URI: https://github.com/madebyraygun/fractal-timber-loader-for-wordpress
Contributors: Fabian Gigler: https://fabiangigler.com/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/


class TimberFractalLoader {
  private $components_map_file;

  public function __construct($components_map_file = "components-map.json") {
    $this->components_map_file = $components_map_file;
    add_action('plugins_loaded', [$this, 'plugins_loaded']);
  }

  public function plugins_loaded() {
    add_filter('timber/loader/loader', [$this, 'add_loader']);
  }

  public function add_loader($loader) {
    require_once "twig_fractal_loader.php";
    $fractalLoader = new TwigFractalLoader($this->components_map_file);
    // Chain the fractal loader before the default file path loader
    $chainLoader = new \Twig_Loader_Chain([$fractalLoader, $loader]);
    return $chainLoader;
  }
}

new TimberFractalLoader();