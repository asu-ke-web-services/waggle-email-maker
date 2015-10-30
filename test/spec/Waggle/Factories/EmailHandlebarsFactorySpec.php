<?php

namespace spec\Waggle\Factories;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Spec tests for generating email markup with
 * the Email Handlebars Factory
 */
class EmailHandlebarsFactorySpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'Waggle\Factories\EmailHandlebarsFactory' );
    $this->shouldHaveType( 'Nectary\Factory' );
  }

  function it_can_render_data() {
    $template = '<p>{{name}}</p>';
    $data = array( 'name' => 'Steve' );

    $this->set_handlebars( $template );
    $this->set_data( $data );

    $this->build()->shouldMatch( '/.*<p>Steve<\\/p>.*/i' );
  }

  function it_can_inline_css() {
    $css = 'p { font-size: 10px }';
    $template = '<p>Steve</p>';

    $this->set_handlebars( $template );
    $this->set_css( $css );

    $this->build()->shouldMatch( '/.*<p style="font-size: 10px;">Steve<\\/p>.*/i' );
  }

  function it_can_inline_css_into_data() {
    $css = 'p { font-size: 10px }';
    $template = '{{{name}}}';
    $data = array( 'name' => '<p>Steve</p>' );

    $this->set_handlebars( $template );
    $this->set_data( $data );
    $this->set_css( $css );

    $this->build()->shouldMatch( '/.*<p style="font-size: 10px;">Steve<\\/p>.*/i' );
  }
}
