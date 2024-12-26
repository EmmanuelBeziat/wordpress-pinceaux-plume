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
function plume_theme_support() {

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
	// add_image_size('plume-painting-single-background', 1200, 480, ['center', 'center']);
	add_image_size('plume-admin-post-featured-image', 48, 48, ['center', 'center']);

	// This will remove the default image sizes and the medium_large size.
	function prefix_remove_default_images($sizes) {
		unset($sizes['medium']); // 300px
		unset($sizes['large']); // 1024px
		unset($sizes['medium_large']); // 768px
		return $sizes;
	}
	add_filter('intermediate_image_sizes_advanced', 'prefix_remove_default_images');

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

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new Plume_Script_Loader();
	add_filter('script_loader_tag', array($loader, 'filter_script_loader_tag'), 10, 2);

}
add_action('after_setup_theme', 'plume_theme_support');

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/classes/class-plume-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';
// require get_template_directory() . '/classes/class-plume-walker-comment.php';
// require get_template_directory() . '/classes/class-plume-walker-page.php';
require get_template_directory() . '/classes/class-plume-script-loader.php';
require get_template_directory() . '/inc/customize.php';

// Custom CSS.
// require get_template_directory() . '/inc/custom-css.php';

/**
 * Register and Enqueue Styles.
 */
function plume_register_styles() {

	$theme_version = wp_get_theme()->get('Version');

  wp_enqueue_style('plume-style', get_template_directory_uri() . '/assets/css/main.min.css', array(), $theme_version);
	wp_enqueue_style('plume-print-style', get_template_directory_uri() . '/assets/css/print.min.css', null, $theme_version, 'print');
}

add_action('wp_enqueue_scripts', 'plume_register_styles');

/**
 * Register and Enqueue Scripts.
 */
function plume_register_scripts() {

	$theme_version = wp_get_theme()->get('Version');

	if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	wp_enqueue_script('plume-js', get_template_directory_uri() . '/assets/js/main.min.js', array(), $theme_version, false);
	wp_script_add_data('plume-js', 'defer', true);
}

add_action('wp_enqueue_scripts', 'plume_register_scripts');

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function plume_menus() {

	$locations = [
		'primary'  => __('Menu principal', 'plume'),
		'footer'   => __('Menu pied de page', 'plume'),
	];

	register_nav_menus($locations);
}

add_action('init', 'plume_menus');


/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 */
function plume_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . __('Skip to the content', 'plume') . '</a>';
}
add_action('wp_body_open', 'plume_skip_link', 5);

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function plume_sidebar_registration() {

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
		'after_title'   => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget'  => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __('Footer #1', 'plume'),
				'id'          => 'sidebar-1',
				'description' => __('Widgets in this area will be displayed in the first column in the footer.', 'plume'),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name'        => __('Footer #2', 'plume'),
				'id'          => 'sidebar-2',
				'description' => __('Widgets in this area will be displayed in the second column in the footer.', 'plume'),
			)
		)
	);

}
// add_action('widgets_init', 'plume_sidebar_registration');

/**
 * Enqueue supplemental block editor styles.
 */
function plume_block_editor_styles() {
	// Enqueue the editor styles.
	wp_enqueue_style('plume-block-editor-styles', get_theme_file_uri('/assets/css/editor-style-block.css'), array(), wp_get_theme()->get('Version'), 'all');

	// Add inline style from the Customizer.
	// wp_add_inline_style('plume-block-editor-styles', plume_get_customizer_css('block-editor'));

	// Enqueue the editor script.
	wp_enqueue_script('plume-block-editor-script', get_theme_file_uri('/assets/js/editor-script-block.js'), array('wp-blocks', 'wp-dom'), wp_get_theme()->get('Version'), true);
}
add_action('enqueue_block_editor_assets', 'plume_block_editor_styles', 1, 1);

/**
 * Enqueue classic editor styles.
 */
function plume_classic_editor_styles() {
	$classic_editor_styles = ['/assets/css/editor-style-classic.css'];

	add_editor_style($classic_editor_styles);
}
add_action('init', 'plume_classic_editor_styles');

/**
 * Output Customizer settings in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
/* function plume_add_classic_editor_customizer_styles($mce_init) {

	$styles = plume_get_customizer_css('classic-editor');

	if (! isset($mce_init['content_style'])) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;

}
add_filter('tiny_mce_before_init', 'plume_add_classic_editor_customizer_styles'); */

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 * @return string
 */
function plume_read_more_tag($html) {
	return preg_replace('/<a(.*)>(.*)<\/a>/iU', sprintf('<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title(get_the_ID())), $html);
}

add_filter('the_content_more_link', 'plume_read_more_tag');

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
		'supports' => ['title', 'editor', 'thumbnail', 'revisions' => false, 'comments'],
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

function plume_admin_column_styles() {
	echo '<style>
		.column-plume_thumb { width: 60px; }
		.column-paint_type { width: 140px; }
	</style>';
}
add_action('admin_head', 'plume_admin_column_styles');

// Add the posts and pages columns filter. They both use the same function.
add_filter('manage_posts_columns', 'plume_add_post_admin_thumbnail_column', 2);
add_filter('manage_pages_columns', 'plume_add_post_admin_thumbnail_column', 2);

// Get featured-thumbnail size post thumbnail and display it
function plume_show_post_thumbnail_column ($columns, $post_id) {
	switch ($columns) {
		case 'plume_thumb':
			if (get_field('picture', $post_id)) {
				echo '<img src="' . get_field('picture', $post_id)['sizes']['plume-admin-post-featured-image'] . '" alt>';
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

function remove_comment_support() {
	remove_post_type_support('post', 'comments');
	remove_post_type_support('page', 'comments');
}
add_action('init', 'remove_comment_support', 100);
// Removes from admin bar

function plume_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'plume_admin_bar_render');

// Manage Post and Page Admin Panel Columns
add_action('manage_posts_custom_column', 'plume_show_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'plume_show_post_thumbnail_column', 5, 2);

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');

function debug ($value) { ?>
<pre style="margin: 1rem 0; padding: 1rem;background: #e4e4e4;border:1px solid: #ccc;"><code><?php var_dump($value); ?></code></pre>
<?php }

function plume_customize_register ($wp_customize) {
  //All our sections, settings, and controls will be added here
  $wp_customize->remove_panel('nav_menus');
  $wp_customize->remove_section('custom_css');
}
add_action('customize_register', 'plume_customize_register', 50);

function convert_to_webp ($string) {
	return preg_replace('/\.(jpg|png)$/', '.webp', $string);
}

function render_post_link ($post, $state) {
	if (!$post) return;

	$class = $state === 'prev' ? 'previous-post' : 'next-post';
	$arrow = $state === 'prev' ? '&larr;' : '&rarr';
	$title = wp_kses_post(get_the_title($prev_post->ID));
	$url = esc_url(get_permalink($post->ID));
	?>
	<a class="<?= $class; ?>" href="<?= $url; ?>">
		<span class="arrow" aria-hidden="true"><?= $arrow; ?></span>
		<span class="title"><span class="title-inner"><?= $title; ?></span></span>
	</a>
	<?php
}
