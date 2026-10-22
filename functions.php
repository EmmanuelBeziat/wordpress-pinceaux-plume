<?php
/**
 * Plume functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Plume
 * @since Plume 1.2
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function plume_theme_support () {

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// Set post thumbnail size.
	set_post_thumbnail_size(1200, 9999);

	add_image_size('plume-painting-home', 480, 480, ['center', 'center']);
	add_image_size('plume-painting-single', 800, 1200);
	add_image_size('plume-admin-post-featured-image', 48, 48, ['center', 'center']);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','script','style']);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Plume, use a find and replace
	 * to change 'plume' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('plume');

	// Add support for full and wide align images.
	add_theme_support('align-wide');

	// Add support for responsive embeds.
	add_theme_support('responsive-embeds');

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

}
add_action('after_setup_theme', 'plume_theme_support');

/**
 * Removes the default image sizes and the medium_large size.
 *
 * @param array $sizes Image sizes.
 * @return array
 */
function plume_remove_default_image_sizes ($sizes) {
	unset($sizes['medium']); // 300px
	unset($sizes['large']); // 1024px
	unset($sizes['medium_large']); // 768px
	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'plume_remove_default_image_sizes');

/**
 * Saves generated JPEG and PNG image sizes as WebP.
 *
 * @param array $formats Source mime type => output mime type mappings.
 * @return array
 */
function plume_output_webp ($formats) {
	$formats['image/jpeg'] = 'image/webp';
	$formats['image/png'] = 'image/webp';
	return $formats;
}
add_filter('image_editor_output_format', 'plume_output_webp');

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/classes/class-plume-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';
require get_template_directory() . '/classes/class-plume-walker-comment.php';
require get_template_directory() . '/inc/customize.php';

/**
 * Register and Enqueue Styles.
 */
function plume_register_styles () {

	$theme_version = wp_get_theme()->get('Version');

	wp_enqueue_style('plume-style', get_template_directory_uri() . '/assets/css/main.min.css', [], $theme_version);
	wp_enqueue_style('plume-print-style', get_template_directory_uri() . '/assets/css/print.min.css', [], $theme_version, 'print');
}

add_action('wp_enqueue_scripts', 'plume_register_styles');

/**
 * Register and Enqueue Scripts.
 */
function plume_register_scripts () {

	$theme_version = wp_get_theme()->get('Version');

	if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_enqueue_script('plume-js', get_template_directory_uri() . '/assets/js/main.min.js', [], $theme_version, ['strategy' => 'defer']);
}

add_action('wp_enqueue_scripts', 'plume_register_scripts');

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function plume_skip_link () {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . esc_html__('Aller au contenu', 'plume') . '</a>';
}
add_action('wp_body_open', 'plume_skip_link', 5);

/**
 * Enqueue supplemental block editor styles.
 */
function plume_block_editor_styles () {
	// Enqueue the editor styles.
	wp_enqueue_style('plume-block-editor-styles', get_theme_file_uri('/assets/css/editor-style-block.css'), [], wp_get_theme()->get('Version'), 'all');

	// Enqueue the editor script.
	wp_enqueue_script('plume-block-editor-script', get_theme_file_uri('/assets/js/editor-script-block.js'), ['wp-blocks', 'wp-dom'], wp_get_theme()->get('Version'), true);
}
add_action('enqueue_block_editor_assets', 'plume_block_editor_styles', 1, 1);

function plume_create_post_types () {
	register_post_type('paintings', [
		'labels' => [
			'name' => 'Tableaux',
			'singular_name' => 'Tableau',
			'all_items' => 'Tous les tableaux',
			'add_new' => 'Ajouter',
			'add_new_item' => 'Ajouter un tableau',
			'edit_item' => 'Modifier le tableau',
			'new_item' => 'Nouveau tableau',
			'view_item' => 'Voir le tableau',
			'view_items' => 'Voir les tableaux',
			'search_items' => 'Rechercher un tableau',
			'not_found' => 'Aucun tableau trouvé',
			'not_found_in_trash' => 'Aucun tableau trouvé dans la corbeille',
			'parent_item_colon' => 'Tableau parent:',
			'menu_name' => 'Tableaux',
			'featured_image' => 'Image du tableau',
			'set_featured_image' => 'Définir l’image du tableau',
			'remove_featured_image' => 'Supprimer l’image du tableau',
			'use_featured_image' => 'Utiliser comme image du tableau',
			'archives' => 'Archives des tableaux',
			'insert_into_item' => 'Insérer dans le tableau',
			'uploaded_to_this_item' => 'Téléversé pour ce tableau',
			'filter_items_list' => 'Filtrer la liste des tableaux',
			'items_list_navigation' => 'Navigation de la liste des tableaux',
			'items_list' => 'Liste des tableaux',
			'attributes' => 'Attributs du tableau',
			'item_published' => 'Tableau publié',
			'item_published_privately' => 'Tableau publié en privé',
			'item_reverted_to_draft' => 'Tableau remis en brouillon',
			'item_scheduled' => 'Tableau planifié',
			'item_updated' => 'Tableau mis à jour',
		],
		'taxonomies' => ['paintings_category'],
		'supports' => ['title', 'editor', 'thumbnail', 'comments'],
		'description' => 'Permet d’ajouter des tableaux',
		'public' => true,
		'menu_icon' => 'dashicons-format-gallery'
	]);

	register_taxonomy('paintings_category', 'paintings', [
		'labels' => [
			'name' => 'Catégorie',
			'singular_name' => 'Catégorie',
			'all_items' => 'Toutes les catégories',
			'search_items' => 'Rechercher une catégorie',
			'add_new_item' => 'Ajouter une catégorie',
			'edit_item' => 'Modifier la catégorie',
			'update_item' => 'Mettre à jour la catégorie',
			'parent_item' => 'Catégorie parente',
			'not_found' => 'Catégorie introuvable',
			'popular_items' => 'Catégories récurrentes',
			'new_item_name' => 'Nom de la nouvelle catégorie'
		],
		'hierarchical' => true
	]);
}
add_action('init', 'plume_create_post_types');

function plume_custom_rss ($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type'])) {
		$qv['post_type'] = ['paintings'];
	}
	return $qv;
}
add_filter('request', 'plume_custom_rss');

// Add the column
function plume_add_post_admin_thumbnail_column ($columns) {
	$new_columns = [
		'cb' => $columns['cb'],
		'plume_thumb' => 'Tableau',
		'title' => $columns['title'],
		'date' => $columns['date'],
		'paint-type' => 'Type de peinture'
	];

	return $new_columns;
}

function plume_admin_column_styles () {
	echo '<style>
		.column-plume_thumb { width: 60px; }
		.column-paint-type { width: 140px; }
	</style>';
}
add_action('admin_head', 'plume_admin_column_styles');

add_filter('manage_paintings_posts_columns', 'plume_add_post_admin_thumbnail_column');

// Get featured-thumbnail size post thumbnail and display it
function plume_show_post_thumbnail_column ($columns, $post_id) {
	switch ($columns) {
		case 'plume_thumb':
			$picture = get_field('picture', $post_id);
			if (!empty($picture['sizes']['plume-admin-post-featured-image'])) {
				echo '<img src="' . esc_url($picture['sizes']['plume-admin-post-featured-image']) . '" alt>';
			}
			break;
		case 'paint-type':
			$paint_type = get_field('paint-type', $post_id);
			echo $paint_type ? esc_html($paint_type) : '-';
			break;
	}
}

// Removes from admin menu
function plume_remove_admin_menu () {
	remove_menu_page('edit-comments.php');
	remove_menu_page('edit.php');
	remove_menu_page('edit.php?post_type=page');
}
add_action('admin_menu', 'plume_remove_admin_menu');
// Removes from post and pages

function plume_remove_comment_support () {
	remove_post_type_support('post', 'comments');
	remove_post_type_support('page', 'comments');
}
add_action('init', 'plume_remove_comment_support', 100);
// Removes from admin bar

function plume_admin_bar_render () {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'plume_admin_bar_render');

add_action('manage_paintings_posts_custom_column', 'plume_show_post_thumbnail_column', 5, 2);

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');

function plume_customize_register ($wp_customize) {
	//All our sections, settings, and controls will be added here
	$wp_customize->remove_panel('nav_menus');
	$wp_customize->remove_section('custom_css');
}
add_action('customize_register', 'plume_customize_register', 50);

function plume_render_post_link ($post, $state) {
	if (!$post) return;

	$class = $state === 'prev' ? 'previous-post' : 'next-post';
	$arrow = $state === 'prev' ? '&larr;' : '&rarr;';
	$title = wp_kses_post(get_the_title($post->ID));
	$url = esc_url(get_permalink($post->ID));
	?>
	<a class="<?= $class; ?>" href="<?= $url; ?>">
		<span class="arrow" aria-hidden="true"><?= $arrow; ?></span>
		<span class="title"><span class="title-inner"><?= $title; ?></span></span>
	</a>
	<?php
}
