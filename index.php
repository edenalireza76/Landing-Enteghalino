<?php
/**
 * برگه‌ها، نوشته‌ها و بقیه‌ی صفحه‌ها با همان سربرگ و پانویس لندینگ.
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="page-wrap" id="content">
	<?php if ( have_posts() ) : ?>
		<?php if ( ! is_singular() ) : ?>
			<h1 class="page-title"><?php echo is_home() ? esc_html__( 'نوشته‌ها', 'enteghalino' ) : wp_kses_post( get_the_archive_title() ); ?></h1>
		<?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
				<?php if ( is_singular() ) : ?>
					<h1 class="page-title"><?php the_title(); ?></h1>
					<div class="entry-content"><?php the_content(); ?></div>
					<?php wp_link_pages(); ?>
				<?php else : ?>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="entry-content"><?php the_excerpt(); ?></div>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<h1 class="page-title"><?php esc_html_e( 'چیزی پیدا نشد', 'enteghalino' ); ?></h1>
		<p><?php esc_html_e( 'صفحه‌ای که دنبالش بودید وجود ندارد.', 'enteghalino' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'بازگشت به صفحه‌ی اول', 'enteghalino' ); ?></a></p>
	<?php endif; ?>
</main>
<?php
get_footer();
