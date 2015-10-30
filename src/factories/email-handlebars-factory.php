<?php

namespace Waggle\Factories;

use Nectary\Factory;

use scssc as scss;
use Handlebars\Handlebars;
use Pelago\Emogrifier;

/**
 * Render an email using Scss, handlebars, and emorgifier
 */
class EmailHandlebarsFactory extends Factory {
  private $data;
  private $handlebars;
  private $css;
  private $scss_service;
  private $handlebars_service;
  private $emogrify_service;

  /**
   * Feel free to set the scss import paths before passing
   * in your own instance of scss.
   *
   * Feel free to create your own Handlebars instance set with
   * a loader and partial loader path. You can then pass in
   * the name of your handlebars file with set_handlebars.
   *
   * Otherwise, you can simple pass in raw handlebars to set_handlebars.
   *
   * Feel free to create your own Emogrifier instance and set any settings
   * you would like applied to your template, such as `disableStyleBlocksParsing`
   * which is useful if you want an email template to retain the `<style>` tags.
   * If you do this, you should also have all of those styles injected using
   * `set_css`.
   */
  public function __construct( scss $scss = null, Handlebars $handlebars_service = null, Emogrifier $emogrifier_service = null ) {
    $this->data       = [];
    $this->handlebars = '';
    $this->css       = '';

    if ( $scss === null ) {
      $this->scss_service = new scss();
    } else {
      $this->scss_service = $scss;
    }

    if ( $handlebars_service === null ) {
      $this->handlebars_service = new Handlebars();
    } else {
      $this->handlebars_service = $handlebars_service;
    }

    if ( $emogrifier_service === null ) {
      $this->emogrifier_service = new Emogrifier();
    } else {
      $this->emogrifier_service = $emogrifier_service;
    }
  }

  public function set_scss( $raw_scss = '' ) {
    $this->set_css( $this->scss_service->compile( $raw_scss ) );
  }

  public function set_css( $raw_css = '' ) {
    $this->css = $raw_css;
  }

  /**
   * Pass in raw handlebars, like `"{title}"` or pass in 
   * a template name like `"my-handlebars.handlebars"` if
   * you have created this Factory with an instance of the
   * Handlebars object with loader and partials loader settings
   */
  public function set_handlebars( $handlebars = '' ) {
    $this->handlebars = $handlebars;
  }

  public function set_data( array $data ) {
    $this->data = $data;
  }

  /**
   * To build an email template, the data is injected into the
   * handlebars provided. Afterwards, the CSS (or SCSS which
   * has been converted to CSS) is inlined into the HTML.
   *
   * @return String built HTML
   */
  public function build() {
    $rendered_template = $this->handlebars_service->render(
        $this->handlebars,
        $this->data
    );

    $this->emogrifier_service->setHtml( $rendered_template);
    $this->emogrifier_service->setCss( $this->css );

    $html = $this->emogrifier_service->emogrify();

    return $html;
  }
}