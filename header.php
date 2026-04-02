<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

	<?php get_template_part( 'template-parts/parts/part', 'preloader' ); ?>

	<?php wp_body_open(); ?>

	<!-- start wrapper-->
	<div class="wrapper" id="wrapper">
	
		<?php get_template_part( 'template-parts/content', 'header' );  ?>

	
		<!-- start main -->
		<main class="main_content">
			<?php get_template_part( 'template-parts/parts/part', 'breadcrumb' ); ?>

			<?php echo '<h2>'.get_post_type().'</h2>'; ?>


