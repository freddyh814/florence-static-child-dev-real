<?php
/**
 * Florence Static Child theme bootstrap.
 */

if (!defined('ABSPATH')) {
  exit;
}

$florence_child_includes = [
  'setup.php',
  'product-attributes.php',
  'product-meta.php',
  'catalog-lockdown.php',
  'rfq.php',
  'seo-schema.php',
  'exporter.php',
  'sample-products.php',
  'class-florence-catalog.php',
];

foreach ($florence_child_includes as $file) {
  $path = __DIR__ . '/inc/' . $file;
  if (file_exists($path)) {
    require_once $path;
  }
}

/**
 * Enqueue styles
 */
function florence_child_enqueue_styles()
{
  $parent_handle = 'florence-static-style'; // Adjust if parent handle is different
  $theme = wp_get_theme();

  // Auto-detect parent handle or just enqueue child styles
  wp_enqueue_style(
    'florence-child-style',
    get_stylesheet_uri(),
    array(),
    time() // Force cache clear
  );
}
add_action('wp_enqueue_scripts', 'florence_child_enqueue_styles');

function florence_child_enqueue_spotlight()
{
  if (!is_front_page()) {
    return;
  }

  $scripts = [
    'florence-hero-spotlight' => '/assets/js/hero-spotlight.js',
  ];

  foreach ($scripts as $handle => $relative_path) {
    $script_path = __DIR__ . $relative_path;
    if (!file_exists($script_path)) {
      continue;
    }

    wp_enqueue_script(
      $handle,
      get_stylesheet_directory_uri() . $relative_path,
      [],
      filemtime($script_path),
      true
    );
  }
}
add_action('wp_enqueue_scripts', 'florence_child_enqueue_spotlight');

function florence_child_enqueue_slim_nav()
{
  $script_path = __DIR__ . '/assets/js/slim-nav.js';
  if (file_exists($script_path)) {
    wp_enqueue_script(
      'florence-slim-nav',
      get_stylesheet_directory_uri() . '/assets/js/slim-nav.js',
      [],
      filemtime($script_path),
      true
    );
  }
}
add_action('wp_enqueue_scripts', 'florence_child_enqueue_slim_nav');

function florence_child_enqueue_pack_builder()
{
  if (!is_front_page()) {
    return;
  }
  $script_path = __DIR__ . '/assets/js/pack-builder.js';
  if (file_exists($script_path)) {
    wp_enqueue_script(
      'florence-pack-builder',
      get_stylesheet_directory_uri() . '/assets/js/pack-builder.js',
      [],
      time(), // Forced cache busting
      true
    );
  }
}

function florence_child_enqueue_header_scroll()
{
  $script_path = __DIR__ . '/assets/js/header-scroll.js';
  if (file_exists($script_path)) {
    wp_enqueue_script(
      'florence-header-scroll',
      get_stylesheet_directory_uri() . '/assets/js/header-scroll.js',
      [],
      filemtime($script_path),
      true
    );
  }
}
add_action('wp_enqueue_scripts', 'florence_child_enqueue_header_scroll');

add_action('wp_enqueue_scripts', 'florence_child_enqueue_pack_builder');

add_action('wp_footer', 'florence_child_language_toggle', 60);
function florence_child_language_toggle()
{
  if (is_admin()) {
    return;
  }
  ?>
  <div id="google_translate_element" style="display:none;"></div>
  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,es', autoDisplay: false }, 'google_translate_element');
    }
  </script>
  <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var buttons = document.querySelectorAll('[data-lang-button]');
      if (!buttons.length) {
        return;
      }
      function setActive(lang) {
        buttons.forEach(function (btn) {
          btn.classList.toggle('is-active', btn.getAttribute('data-lang-button') === lang);
        });
      }
      function translateTo(lang) {
        var tries = 0;
        var interval = setInterval(function () {
          var combo = document.querySelector('select.goog-te-combo');
          if (combo) {
            combo.value = lang;
            combo.dispatchEvent(new Event('change'));
            clearInterval(interval);
            setActive(lang);
          } else if (tries > 50) {
            clearInterval(interval);
          }
          tries++;
        }, 200);
      }
      buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var lang = btn.getAttribute('data-lang-button');
          translateTo(lang);
        });
      });
    });
  </script>
  <?php
}


