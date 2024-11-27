<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Hover_Image_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'hover_image';
    }

    public function get_title() {
        return __( 'Hover Image', 'elementor-hover-addon' );
    }

    public function get_icon() {
        return 'eicon-image';
    }

    public function get_categories() {
        return [ 'basic' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'elementor-hover-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Image Control
        $this->add_control(
            'image',
            [
                'label' => __( 'Image', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Title Control
        $this->add_control(
            'title_text',
            [
                'label' => __( 'Title', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Title Text', 'elementor-hover-addon' ),
            ]
        );

        // Hover Text Control
        $this->add_control(
            'hover_text',
            [
                'label' => __( 'Hover Text', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Your hover text goes here.', 'elementor-hover-addon' ),
            ]
        );

        // Link Text Control
        $this->add_control(
            'link_text',
            [
                'label' => __( 'Link Text', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Click Here', 'elementor-hover-addon' ),
            ]
        );

        // Link URL Control
        $this->add_control(
            'link_url',
            [
                'label' => __( 'Link URL', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://example.com', 'elementor-hover-addon' ),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                ],
            ]
        );

        $this->end_controls_section();

        // Text Style Settings
        $this->start_controls_section(
            'text_settings',
            [
                'label' => __( 'Text Settings', 'elementor-hover-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label' => __( 'Title Color', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'text_size',
            [
                'label' => __( 'Text Size', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
            ]
        );

        $this->add_control(
            'text_weight',
            [
                'label' => __( 'Text Weight', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'normal' => __( 'Normal', 'elementor-hover-addon' ),
                    'bold' => __( 'Bold', 'elementor-hover-addon' ),
                    'bolder' => __( 'Bolder', 'elementor-hover-addon' ),
                    'lighter' => __( 'Lighter', 'elementor-hover-addon' ),
                ],
                'default' => 'normal',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button Color', 'elementor-hover-addon' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0073e6',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $image_url = $settings['image']['url'];
        $title_text = $settings['title_text'];
        $hover_text = $settings['hover_text'];
        $link_text = $settings['link_text'];
        $link_url = $settings['link_url']['url'];
        $text_color = $settings['text_color'];
        $title_text_color = $settings['title_text_color'];
        $text_size = $settings['text_size']['size'] . $settings['text_size']['unit'];
        $text_weight = $settings['text_weight'];
        $button_color = $settings['button_color'];
        $is_external = $settings['link_url']['is_external'] ? 'target="_blank"' : '';

        echo '<div class="hover-image-widget">';
        echo '<div class="hover-image-container">';
        echo '<img src="' . esc_url( $image_url ) . '" alt="" class="hover-image">';
        
        // Title with underline
        if ( $title_text ) {
			echo '<div class="hover-title" style="color:' . esc_attr( $title_text_color ) . ';">' . esc_html( $title_text ) . '</div>';
			echo '<div class="hover-title-underline" style="background-color:' . esc_attr( $title_text_color ) . '; margin-top: 5px;"></div>';
		}


        // Hover overlay
        echo '<div class="hover-overlay">';
        echo '<div class="hover-text" style="color:' . esc_attr( $text_color ) . '; font-size:' . esc_attr( $text_size ) . '; font-weight:' . esc_attr( $text_weight ) . ';">' . $hover_text . '</div>';
        if ( $link_url ) {
            echo '<a href="' . esc_url( $link_url ) . '" ' . $is_external . ' class="hover-link" style="background-color:' . esc_attr( $button_color ) . ';">' . esc_html( $link_text ) . '</a>';
        }
        echo '</div>'; // Close hover overlay
        echo '</div>'; // Close image container
        echo '</div>'; // Close widget container
    }
}