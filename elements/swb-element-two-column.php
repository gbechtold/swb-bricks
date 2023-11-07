<?php
// swb-element-two-column.php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Prefix_Element_Two_Column extends \Bricks\Element {
  // Element properties
  public $category     = 'layout';
  public $name         = 'prefix-two-column';
  public $icon         = 'ti-layout-column2-alt';
  public $css_selector = '.prefix-two-column-wrapper';

  // Return localized element label
  public function get_label() {
    return esc_html__( 'SWB 🦢 Two Column Element', 'bricks' );
  }

  // Set builder controls
  public function set_controls() {
    // Image position control
    $this->controls['image_position'] = [
      'tab' => 'content',
      'label' => esc_html__( 'Image Position', 'bricks' ),
      'type' => 'select',
      'options' => [
        'left' => esc_html__( 'Image Left', 'bricks' ),
        'right' => esc_html__( 'Image Right', 'bricks' ),
      ],
      'default' => 'left',
    ];

    // Image control
    $this->controls['image'] = [
      'tab' => 'content',
      'label' => esc_html__( 'Image', 'bricks' ),
      'type' => 'image',
      'default' => '',
    ];

    // Headline control
    $this->controls['headline'] = [
      'tab' => 'content',
      'label' => esc_html__( 'Headline', 'bricks' ),
      'type' => 'text',
      'default' => esc_html__( 'Your headline here', 'bricks' ),
    ];

    // Text control
    $this->controls['text'] = [
      'tab' => 'content',
      'label' => esc_html__( 'Text Content', 'bricks' ),
      'type' => 'textarea',
      'default' => esc_html__( 'Your text content here.', 'bricks' ),
    ];

    // Link URL control
    $this->controls['link_url'] = [
      'tab' => 'content',
      'label' => esc_html__( 'Link URL', 'bricks' ),
      'type' => 'url',
      'default' => '',
      'placeholder' => esc_html__( 'Enter URL here', 'bricks' ),
      // Entfernt die unnötigen Bedingungen für den Link URL control
    ];

    // Link text control
    $this->controls['link_text'] = [
      'tab' => 'content',
      'label' => esc_html__( 'Link Text', 'bricks' ),
      'type' => 'text',
      'default' => esc_html__( 'Learn More', 'bricks' ),
      'conditions' => [
        [
          'field' => 'link_url',
          'value' => true,
        ],
      ],
    ];

    // Link target control
    $this->controls['link_target'] = [
      'tab' => 'content',
      'label' => esc_html__( 'Link Target', 'bricks' ),
      'type' => 'select',
      'options' => [
        '_self' => esc_html__( 'Same Window', 'bricks' ),
        '_blank' => esc_html__( 'New Window', 'bricks' ),
      ],
      'default' => '_self',
    ];
  }

  // Render element HTML
  public function render() {
    $image_html = '';
    if ( ! empty( $this->settings['image']['url'] ) ) {
      $image_url = $this->settings['image']['url'];
      $image_html = "<img src='" . esc_url( $image_url ) . "' alt=''>";
    } else {
      // Ersetzt durch einen visuellen Platzhalter
      $image_html = "<div class='image-placeholder'>Image Placeholder</div>";
    }

    $headline_html = ! empty( $this->settings['headline'] ) ? "<h2>{$this->settings['headline']}</h2>" : '';
    $text_html = ! empty( $this->settings['text'] ) ? "<p>{$this->settings['text']}</p>" : '';
    $link_url = ! empty( $this->settings['link_url'] ) ? esc_url( $this->settings['link_url'] ) : '';
    $link_text = ! empty( $this->settings['link_text'] ) ? esc_html( $this->settings['link_text'] ) : '';
    $link_target = ! empty( $this->settings['link_target'] ) ? esc_attr( $this->settings['link_target'] ) : '_self';

    $image_position = ! empty( $this->settings['image_position'] ) ? $this->settings['image_position'] : 'left';
    $image_class = 'prefix-column-image' . ( $image_position === 'right' ? ' prefix-image-right' : ' prefix-image-left' );


    // Render element HTML with link
    if ( ! empty( $link_url ) ) {
      echo "<a href='{$link_url}' target='{$link_target}' class='prefix-two-column-wrapper'>";
    } else {
      echo "<div class='prefix-two-column-wrapper'>";
    }

    echo "<div class='{$image_class}'>";
      echo $image_html; // Spalte für das Bild
    echo "</div>";
    
    echo "<div class='prefix-column prefix-column-content'>";
      echo $headline_html; // Spalte für die Überschrift und den Text
      echo $text_html;
    echo "</div>";

    if ( ! empty( $link_url ) ) {
      echo "<div class='prefix-link-text'>{$link_text}</div>";
      echo "</a>";
    } else {
      echo "</div>"; // Close .prefix-two-column-wrapper
    }
  }
}


// Register the element
\Bricks\Elements::register_element( 'Prefix_Element_Two_Column', __DIR__ . '/swb-element-two-column.php' );

// Register the element
// \Bricks\Elements::register_element( 'Prefix_Element_Two_Column', __DIR__ . '/element-two-column.php' );
// ?>
