<?php
/**
 * عنوان میان‌بخشی در سفارشی‌سازی، برای مرتب کردن فیلدها.
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;

/**
 * کنترل فقط-نمایشی عنوان.
 */
class Enteghalino_Heading_Control extends WP_Customize_Control {

	/**
	 * نوع کنترل.
	 *
	 * @var string
	 */
	public $type = 'enteghalino-heading';

	/**
	 * چاپ عنوان.
	 */
	public function render_content() {
		echo '<h3 class="enteghalino-heading">' . esc_html( $this->label ) . '</h3>';
	}
}
