<?php
/**
 * تنظیمات قالب در «نمایش › سفارشی‌سازی › لندینگ انتقالینو».
 *
 * بخش‌ها و فیلدها از enteghalino_schema() در inc/options.php ساخته می‌شوند.
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;

/**
 * پاک‌سازی چک‌باکس.
 *
 * @param mixed $value مقدار.
 * @return bool
 */
function enteghalino_sanitize_checkbox( $value ) {
	return (bool) $value && 'false' !== $value;
}

/**
 * پاک‌سازی لینک؛ لنگرهای #بخش هم پذیرفته می‌شوند.
 *
 * @param string $value مقدار.
 * @return string
 */
function enteghalino_sanitize_url( $value ) {
	$value = trim( (string) $value );
	if ( '' !== $value && '#' === $value[0] ) {
		return '#' . preg_replace( '/[^A-Za-z0-9_-]/', '', substr( $value, 1 ) );
	}
	return esc_url_raw( $value );
}

/**
 * پاک‌سازی انتخاب آیکون.
 *
 * @param string               $value   مقدار.
 * @param WP_Customize_Setting $setting تنظیم.
 * @return string
 */
function enteghalino_sanitize_select( $value, $setting ) {
	$choices = enteghalino_icon_choices();
	return isset( $choices[ $value ] ) ? $value : $setting->default;
}

/**
 * ثبت پنل، بخش‌ها و فیلدها.
 *
 * @param WP_Customize_Manager $wp_customize مدیر سفارشی‌سازی.
 */
function enteghalino_customize_register( $wp_customize ) {
	require_once get_template_directory() . '/inc/class-heading-control.php';

	$wp_customize->add_panel(
		'enteghalino',
		array(
			'title'       => __( 'لندینگ انتقالینو', 'enteghalino' ),
			'description' => __( 'همه‌ی متن‌ها، لینک‌ها و رنگ‌های صفحه‌ی اول. با باز کردن هر بخش، پیش‌نمایش به همان قسمت صفحه می‌رود.', 'enteghalino' ),
			'priority'    => 25,
		)
	);

	$sanitizers = array(
		'text'     => 'sanitize_text_field',
		'textarea' => 'sanitize_textarea_field',
		'lines'    => 'sanitize_textarea_field',
		'url'      => 'enteghalino_sanitize_url',
		'color'    => 'sanitize_hex_color',
		'checkbox' => 'enteghalino_sanitize_checkbox',
		'select'   => 'enteghalino_sanitize_select',
	);

	$priority = 10;
	foreach ( enteghalino_schema() as $sid => $section ) {
		$section_id = 'enteghalino_' . $sid;
		$wp_customize->add_section(
			$section_id,
			array(
				'title'       => $section['title'],
				'description' => isset( $section['description'] ) ? $section['description'] : '',
				'panel'       => 'enteghalino',
				'priority'    => $priority++,
			)
		);

		foreach ( $section['fields'] as $key => $field ) {
			$id = 'enteghalino_' . $key;

			if ( 'heading' === $field['type'] ) {
				$wp_customize->add_control(
					new Enteghalino_Heading_Control(
						$wp_customize,
						$id,
						array(
							'label'    => $field['label'],
							'section'  => $section_id,
							'settings' => array(),
						)
					)
				);
				continue;
			}

			$wp_customize->add_setting(
				$id,
				array(
					'default'           => $field['default'],
					'sanitize_callback' => $sanitizers[ $field['type'] ],
					'transport'         => $field['transport'],
				)
			);

			$args = array(
				'label'       => $field['label'],
				'description' => $field['description'],
				'section'     => $section_id,
			);

			if ( 'color' === $field['type'] ) {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, $args ) );
				continue;
			}

			$args['type'] = array(
				'text'     => 'text',
				'textarea' => 'textarea',
				'lines'    => 'textarea',
				'url'      => 'text',
				'checkbox' => 'checkbox',
				'select'   => 'select',
			)[ $field['type'] ];

			if ( 'select' === $field['type'] ) {
				$args['choices'] = $field['choices'];
			}
			if ( 'url' === $field['type'] ) {
				$args['input_attrs'] = array(
					'dir'         => 'ltr',
					'placeholder' => 'https://',
				);
			}
			if ( 'lines' === $field['type'] ) {
				$args['input_attrs'] = array( 'rows' => 6 );
			}
			$wp_customize->add_control( $id, $args );
		}
	}
}
add_action( 'customize_register', 'enteghalino_customize_register' );

/**
 * اسکریپت پیش‌نمایش زنده: متن‌ها و رنگ‌ها بدون بارگذاری دوباره عوض می‌شوند.
 */
function enteghalino_customize_preview() {
	$fields = array();
	foreach ( enteghalino_fields() as $key => $field ) {
		if ( 'postMessage' === $field['transport'] ) {
			$fields[ $key ] = $field['type'] . ( $field['fmt'] ? ':' . $field['fmt'] : '' );
		}
	}
	wp_enqueue_script( 'enteghalino-preview', get_theme_file_uri( 'assets/js/customizer-preview.js' ), array( 'customize-preview' ), enteghalino_asset_version(), true );
	wp_add_inline_script( 'enteghalino-preview', 'window.enteghalinoFields = ' . wp_json_encode( $fields ) . ';', 'before' );
}
add_action( 'customize_preview_init', 'enteghalino_customize_preview' );

/**
 * اسکریپت پنل: با باز شدن هر بخش، پیش‌نمایش به همان قسمت صفحه می‌رود.
 */
function enteghalino_customize_controls() {
	$targets = array();
	foreach ( enteghalino_schema() as $sid => $section ) {
		$targets[ 'enteghalino_' . $sid ] = $section['target'];
	}
	wp_enqueue_script( 'enteghalino-controls', get_theme_file_uri( 'assets/js/customizer-controls.js' ), array( 'customize-controls' ), enteghalino_asset_version(), true );
	wp_add_inline_script( 'enteghalino-controls', 'window.enteghalinoTargets = ' . wp_json_encode( $targets ) . ';', 'before' );
	wp_add_inline_style( 'customize-controls', '.enteghalino-heading{margin:22px -12px 6px;padding:8px 12px;background:#f0f0f1;border-block:1px solid #dcdcde;font-size:13px;font-weight:600}' );
}
add_action( 'customize_controls_enqueue_scripts', 'enteghalino_customize_controls' );
