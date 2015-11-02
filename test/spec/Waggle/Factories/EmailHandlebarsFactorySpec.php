<?php

namespace spec\Waggle\Factories;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use scssc as Scss;
use Handlebars\Handlebars;
use Pelago\Emogrifier;

/**
 * Spec tests for generating email markup with
 * the Email Handlebars Factory
 */
class EmailHandlebarsFactorySpec extends ObjectBehavior {
  function it_is_initializable() {
    $this->shouldHaveType( 'Waggle\Factories\EmailHandlebarsFactory' );
    $this->shouldHaveType( 'Nectary\Factory' );
  }

  function it_will_make_its_own_dependencies_if_they_are_not_provided() {
    $this->beConstructedWith( null, null, null );

    $template = '<p>{{name}}</p>';
    $data = array( 'name' => 'Steve' );

    $this->set_handlebars( $template );
    $this->set_data( $data );

    $this->build()->shouldMatch( '/.*<p>Steve<\\/p>.*/i' );
  }

  function it_will_use_injected_dependencies( Scss $scssc, Handlebars $handlebars, Emogrifier $emogrifier ) {
    $template = 'template';
    $data = array( 'key' => 'value' );
    $scss = 'scss';

    $scssc->compile( $scss )->shouldBeCalled()->willReturn( 'css' );
    $handlebars->render( $template, $data )->shouldBeCalled()->willReturn( 'html' );
    $emogrifier->setHtml( 'html' )->shouldBeCalled();
    $emogrifier->setCss( 'css' )->shouldBeCalled();
    $emogrifier->emogrify()->shouldBeCalled()->willReturn( 'emorgified' );

    $this->beConstructedWith( $scssc, $handlebars, $emogrifier );

    $this->set_handlebars( $template );
    $this->set_data( $data );
    $this->set_scss( $scss );

    $this->build()->shouldEqual( 'emorgified' );
  }
  
  function it_will_build() {
    $this->build()->shouldEqual( '' );
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

  function it_can_inline_scss() {
    $scss = 'p { font-size: 5px + 5px }';
    $template = '<p>Steve</p>';

    $this->set_handlebars( $template );
    $this->set_scss( $scss );

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
