<?php

class TwigFractalLoader implements \Twig_LoaderInterface
{
  protected $components_map = [];

  public function __construct($components_map_file)
  {
    $mapfile = locate_template($components_map_file);
    if ( !file_exists( $mapfile ) ) return false;
    $this->components_map = json_decode(
      file_get_contents($mapfile),
      true
    ); 
  }

  /**
   * Gets the source code of a template, given its name.
   *
   * @param  string $name string The name of the template to load
   *
   * @return string The template source code
   */
  public function getSourceContext($name)
  {
    $path = $this->lookupComponentMap($name);
    return new \Twig\Source(file_get_contents($path), $name, $path);
  }

  /**
   * Gets the cache key to use for the cache for a given template name.
   *
   * @param  string $name string The name of the template to load
   *
   * @return string The cache key
   */
  public function getCacheKey($name)
  {
    return md5($name);
  }

  /**
   * Returns true if the template is still fresh.
   *
   * @param string    $name The template name
   * @param timestamp $time The last modification time of the cached template
   */
  public function isFresh($name, $time)
  {
    return true;
  }

  /**
   * Checks if the template exists within the loader
   *
   * @param string    $name The template name
   */
  public function exists($name)
  {
    return ($this->lookupComponentMap($name) !== false);
  }

  /**
   * Looks up the template file path by identifier
   *
   * @param string    $name The template name
   */
  public function lookupComponentMap($name) {
    if (!array_key_exists($name, $this->components_map)) return false;
    $file = locate_template( $this->components_map[$name] );
    if ( !file_exists( $file ) ) return false;
    return $file;
  }
}