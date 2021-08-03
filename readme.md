# Timber Fractal Loader for WordPress

This plugin allows you to directly use [Fractal](https://fractal.build) component IDs in [Timber](https://upstatement.com/timber/) twig templates.

## Installation

This Timber Fractal Loader can be directly used as a WordPress plugin, or included with your theme.

## Usage

By default the `components-map.json` within the theme directory is used if present. The location of the json file can be overwritten by passing it to the Loader constructor:

```
new TimberFractalLoader('path/to/components-map.json');

```

Any mapped fractal components can then be directly included via their IDs:

```
{% include '@button' with {
  text: 'Click here',
  url: 'https://google.com'
} only %}

```
