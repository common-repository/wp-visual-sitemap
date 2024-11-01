<?php
/*
Plugin Name: WP Visual Sitemap
Description: Plugin to add a visual sitemap to the frontend of your site
Version:     1.0.2
Author:      corgux
Author URI:	https://corgux.github.io/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) {
    exit;
}

#************************************
#		CSS and javascript
#************************************

function wpvs_enqueue_admin_scripts()
{

    # admin javascript
    wp_enqueue_script('wpvs-admin-js', plugins_url('admin/wpvs-admin-scripts.js', __FILE__), array('jquery', 'wp-color-picker'), false, true);

    # admin css
    wp_enqueue_style('wpvs_admin_css', plugins_url('admin/wpvs-admin-styles.css', __FILE__));

    # front end css - requried for preview panel
    wp_enqueue_style('wpvs_front_end_css', plugins_url('css/wpvs-front-end.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'wpvs_enqueue_admin_scripts');


function wpvs_enqueue_front_end_scripts()
{

    # front end css
    wp_enqueue_style('wpvs_front_end_css', plugins_url('css/wpvs-front-end.css', __FILE__));
}

function wpvs_enqueue_front_end_override_scripts()
{

    # front end css in template
    wp_enqueue_style('wpvs_front_end_css', get_template_directory_uri() . '/wp-visual-sitemap/wpvs-front-end.css');
}

# Check whether to load template or plugin CSS
$overide = file_exists(get_template_directory() . '/wp-visual-sitemap/wpvs-front-end.css');
if ($overide) {

    add_action('wp_enqueue_scripts', 'wpvs_enqueue_front_end_override_scripts');
} else {

    add_action('wp_enqueue_scripts', 'wpvs_enqueue_front_end_scripts');
}

function wpvs_enqueue_front_end_fontawesome()
{

    # font awesome
    wp_enqueue_style('wpvs_front_end_fontawesome_css', plugins_url('fontawesome/css/font-awesome.min.css', __FILE__));
}

if (get_option('wpvs_use_icons') === 'yes') {
    add_action('wp_enqueue_scripts', 'wpvs_enqueue_front_end_fontawesome');
}


#************************************
#			Admin menu
#************************************

# Add an admin menu
function wpvs_admin_menu()
{
    add_options_page('WP Visual Sitemap Settings', 'WP Visual Sitemap', 'manage_options', 'wpvs_settings', 'wpvs_plugin_options');
}

# Output the options
function wpvs_plugin_options()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    ?>
    <div class="wrap wpvs_wrap">
        <h1>WP Visual Sitemap Settings</h1>
        <form method="post" action="options.php">
            <?php

            settings_fields('wpvs_option_group');
            do_settings_sections('wpvs_option_group');

            # Get previously set options
            $wpvs_icon_background_colour         = get_option('wpvs_icon_background_colour');
            $wpvs_text_colour                    = get_option('wpvs_text_colour');
            $wpvs_hover_icon_background_colour   = get_option('wpvs_hover_icon_background_colour');
            $wpvs_hover_text_colour              = get_option('wpvs_hover_text_colour');
            $wpvs_line_colour                    = get_option('wpvs_line_colour');
            $wpvs_font_size                      = get_option('wpvs_font_size');
            $wpvs_sort_by                        = get_option('wpvs_sort_by');
            $wpvs_sort_order                     = get_option('wpvs_sort_order');

            ?>

            <table class="form-table" id="wpvs_options_table">
                <tr valign="top">
                    <th scope="row">Background colour</th>
                    <td>
                        <input type="text" name="wpvs_icon_background_colour" class="wpvs_icon_background_colour" data-default-color="#009691" value="<?php echo empty($wpvs_icon_background_colour) ? '#009691' : esc_attr($wpvs_icon_background_colour); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Text colour</th>
                    <td>
                        <input type="text" name="wpvs_text_colour" class="wpvs_text_colour" data-default-color="#FFFFFF" value="<?php echo empty($wpvs_text_colour) ? '#FFFFFF' : esc_attr($wpvs_text_colour); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Hover background colour</th>
                    <td>
                        <input type="text" name="wpvs_hover_icon_background_colour" class="wpvs_hover_icon_background_colour" data-default-color="#CCCCCC" value="<?php echo empty($wpvs_hover_icon_background_colour) ? '#CCCCCC' : esc_attr($wpvs_hover_icon_background_colour); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Hover text colour</th>
                    <td>
                        <input type="text" name="wpvs_hover_text_colour" class="wpvs_hover_text_colour" data-default-color="#333333" value="<?php echo empty($wpvs_hover_text_colour) ? '#333333' : esc_attr($wpvs_hover_text_colour); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Line colour</th>
                    <td>
                        <input type="text" name="wpvs_line_colour" class="wpvs_line_colour" data-default-color="#CCCCCC" value="<?php echo empty($wpvs_line_colour) ? '#CCCCCC' : esc_attr($wpvs_line_colour); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Font size</th>
                    <td>
                        <input type="text" name="wpvs_font_size" class="wpvs_font_size" value="<?php echo empty($wpvs_font_size) ? '12px' : esc_attr($wpvs_font_size); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Use icons?</th>
                    <td>
                        <input type="checkbox" name="wpvs_use_icons" class="wpvs_use_icons" value="yes" <?php checked('yes', get_option('wpvs_use_icons')); ?> />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Number of columns</th>
                    <td>

                        <label for="column_1">1</label>
                        <input type="radio" name="wpvs_number_of_columns" value="1" id="column_1" <?php checked('1', get_option('wpvs_number_of_columns')); ?>>

                        <label for="column_2">2</label>
                        <input type="radio" name="wpvs_number_of_columns" value="2" id="column_2" <?php checked('2', get_option('wpvs_number_of_columns')); ?>>

                        <label for="column_3">3</label>
                        <input type="radio" name="wpvs_number_of_columns" value="3" id="column_3" <?php checked('3', get_option('wpvs_number_of_columns')); ?>>

                        <label for="column_4">4</label>
                        <input type="radio" name="wpvs_number_of_columns" value="4" id="column_4" <?php checked('4', get_option('wpvs_number_of_columns')); ?>>

                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Sort by</th>
                    <td>

                        <select name="wpvs_sort_by">

                            <?php

                                $options = [
                                    [ value => 'menu_order', text => 'Menu order' ],
                                    [ value => 'post_title', text => 'Page title' ],
                                    [ value => 'post_name', text => 'Page slug' ],
                                    [ value => 'post_date', text => 'Date' ]
                                ];

                                foreach ($options as $option) {

                                    $selected = $option['value'] == $wpvs_sort_by ? ' selected' : '';
                                    echo '<option' . $selected . ' value="' . $option['value'] . '">' . $option['text'] . '</option>';
                                }
                            ?>
                        </select>

                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Sort order</th>
                    <td>

                        <select name="wpvs_sort_order">

                        <?php

                        $options_sort_order = [
                            [ value => 'ASC', text => 'Ascending' ],
                            [ value => 'DESC', text => 'Descending' ]
                        ];

                        foreach ($options_sort_order as $option) {

                            $selected = $option['value'] == $wpvs_sort_order ? ' selected' : '';
                            echo '<option' . $selected . ' value="' . $option['value'] . '">' . $option['text'] . '</option>';
                        }
                        ?>
                        </select>

                    </td>
                </tr>

                <tr>
                    <th scope="row" colspan="2">
                    <small style="max-width: 400px; display: block"><em>Sort by</em> and <em>Sort order</em> don't apply if you choose to display a menu in the sitemap, e.g. [wp_visual_sitemap menu="my menu"]</small>
                    </th>
                </tr>

            </table>

            <?php
            # For the banter, create some family trees for the preview
            $random_number = rand(1, 4);

            switch ($random_number) {
                case '1':
                    $parent = 'Vito';
                    $child_1 = 'Michael';
                    $child_2 = 'Frederico';
                    $grandchild = 'Mary';
                    break;

                    # SPOILER ALERT!!
                case '2':
                    $parent = 'Anakin';
                    $child_1 = 'Leia';
                    $child_2 = 'Luke';
                    $grandchild = 'Kylo';
                    break;

                case '3':
                    $parent = 'Joe';
                    $child_1 = 'Michael';
                    $child_2 = 'Janet';
                    $grandchild = 'Prince';
                    break;

                case '4':
                    $parent = 'Henry';
                    $child_1 = 'Peter';
                    $child_2 = 'Jane';
                    $grandchild = 'Bridget';
                    break;
            }
            ?>

            <div id="wpvs_preview">
                <strong>Preview</strong>
                <div class="wpvs_preview_wrapper">
                    <ul class="wpvs_wrapper">
                        <li class="wpvs_column_1 page_item page-item-178 page_item_has_children"><a href="#">
                                <div class="wpvs_menu_icon"><i class="fa fa-space-shuttle"></i></div><span><?php echo $parent; ?></span>
                            </a>
                            <ul class='children'>
                                <li class="page_item page-item-180 page_item_has_children"><a href="#">
                                        <div class="wpvs_menu_icon"><i class="fa fa-diamond"></i></div><span><?php echo $child_1; ?></span>
                                    </a>
                                    <ul class='children'>
                                        <li class="page_item page-item-182 page_item_has_children"><a href="#">
                                                <div class="wpvs_menu_icon"><i class="fa fa-ship"></i></div><span><?php echo $grandchild; ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="page_item page-item-188"><a href="http://127.0.0.1:8080/wordpress/page-1/child-2/">
                                        <div class="wpvs_menu_icon"><i class="fa fa-bolt"></i></div><span><?php echo $child_2; ?></span>
                                    </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <?php

            submit_button();

            ?>

            <style>
                ul.wpvs_wrapper li>a {
                    <?php if (!empty($wpvs_icon_background_colour)) {
                        echo 'background-color: ' . $wpvs_icon_background_colour . '; ';
                    }

                    ?><?php if (!empty($wpvs_text_colour)) {
                            echo 'color: ' . $wpvs_text_colour . '; ';
                        }

                        ?><?php if (!empty($wpvs_font_size)) {
                            echo 'font-size: ' . $wpvs_font_size . ';';
                        }

                        ?>
                }

                ul.wpvs_wrapper li>a:hover {
                    <?php if (!empty($wpvs_hover_icon_background_colour)) {
                        echo 'background-color: ' . $wpvs_hover_icon_background_colour . '; ';
                    }

                    ?><?php if (!empty($wpvs_hover_text_colour)) {
                            echo 'color: ' . $wpvs_hover_text_colour . ';';
                        }

                        ?>
                }

                ul.wpvs_wrapper li>a,
                ul.wpvs_wrapper>li ul li {
                    <?php if (!empty($wpvs_line_colour)) {
                        echo 'border-color: ' . $wpvs_line_colour . '; ';
                    }

                    ?>
                }
            </style>
        </form>
    </div>
<?php
}

# Register options
function wpvs_register_settings()
{
    register_setting('wpvs_option_group', 'wpvs_icon_background_colour');
    register_setting('wpvs_option_group', 'wpvs_text_colour');
    register_setting('wpvs_option_group', 'wpvs_hover_icon_background_colour');
    register_setting('wpvs_option_group', 'wpvs_hover_text_colour');
    register_setting('wpvs_option_group', 'wpvs_line_colour');
    register_setting('wpvs_option_group', 'wpvs_font_size');
    register_setting('wpvs_option_group', 'wpvs_use_icons');
    register_setting('wpvs_option_group', 'wpvs_number_of_columns');
    register_setting('wpvs_option_group', 'wpvs_sort_by');
    register_setting('wpvs_option_group', 'wpvs_sort_order');
}

if (is_admin()) {
    add_action('admin_menu', 'wpvs_admin_menu');
    add_action('admin_init', 'wpvs_register_settings');
}


#************************************
#		Settings meta box
#************************************

# Enqueue color picker
function wpvs_color_picker($hook_suffix)
{
    wp_enqueue_style('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'wpvs_color_picker');


# Enqueue Font Awesome picker
function wpvs_fa_picker()
{
    wp_enqueue_script('fa_picker_js', plugins_url('fontawesome/iconpicker/js/fontawesome-iconpicker.min.js',  __FILE__), array('jquery'), false, true);
    wp_enqueue_style('fa_picker_css', plugins_url('fontawesome/iconpicker/css/fontawesome-iconpicker.min.css',  __FILE__));
    wp_enqueue_style('fa_css', plugins_url('fontawesome/css/font-awesome.min.css',  __FILE__));
}

add_action('admin_enqueue_scripts', 'wpvs_fa_picker');


# Register the meta box
function wpvs_metabox()
{
    add_meta_box('wpvs_page_settings', 'WP Visual Sitemap', 'wpvs_page_settings', 'page', 'side', 'default');
}
add_action('add_meta_boxes', 'wpvs_metabox');


# Add the fields
function wpvs_page_settings($post)
{

    wp_nonce_field(basename(__FILE__), 'wpvs_nonce');
    $wpvs_stored_meta = get_post_meta($post->ID); ?>

    <p>
        <label for="exclude_from_sitemap">
            <span class="wpvs_label"><?php _e('Exclude from sitemap?', 'wpvs-textdomain') ?></span>
        </label>
    </p>
    <input type="checkbox" name="exclude_from_sitemap" id="exclude_from_sitemap" value="yes" <?php if (isset($wpvs_stored_meta['exclude_from_sitemap'])) checked($wpvs_stored_meta['exclude_from_sitemap'][0], 'yes'); ?>>

    <?php

    if (get_option('wpvs_use_icons') === 'yes') { ?>

        <p>
            <span class="wpvs_label"><label for="wpvs_fa_icon"><?php _e('Page icon', 'wpvs-textdomain') ?></label></span>
        </p>

        <?php

        echo isset($wpvs_stored_meta['wpvs_fa_icon']) ? '<i id="wpvs_fa_chosen_icon" class="fa ' . $wpvs_stored_meta['wpvs_fa_icon'][0] . '"></i>' : '<i id="wpvs_fa_chosen_icon"></i>';

        ?>
        <input type="text" name="wpvs_fa_icon" id="wpvs_fa_icon" data-input-search="true" placeholder="Search for icon..." value="<?php if (isset($wpvs_stored_meta['wpvs_fa_icon'])) echo $wpvs_stored_meta['wpvs_fa_icon'][0]; ?>">

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#wpvs_fa_icon').iconpicker();
            });
        </script>

    <?php
}
}

# Save the data
function wpvs_save_meta($post_id)
{

    # Checks save status
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['wpvs_nonce']) && wp_verify_nonce($_POST['wpvs_nonce'], basename(__FILE__))) ? 'true' : 'false';

    # Exits script depending on save status
    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    # Checks for input and saves
    if (isset($_POST['exclude_from_sitemap'])) {
        update_post_meta($post_id, 'exclude_from_sitemap', 'yes');
    } else {
        update_post_meta($post_id, 'exclude_from_sitemap', '');
    }

    // Checks for input and sanitizes/saves if needed
    if (isset($_POST['wpvs_fa_icon'])) {
        update_post_meta($post_id, 'wpvs_fa_icon', $_POST['wpvs_fa_icon']);
    }
}

add_action('save_post', 'wpvs_save_meta'); // save the custom fields



#************************************
#			Page Walker
#************************************

class wpvs_walker extends Walker_Page
{

    public function start_el(&$output, $page, $depth = 0, $args = array(), $current_page = 0)
    {
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }
        if ($depth) {
            $indent = str_repeat($t, $depth);
        } else {
            $indent = '';
        }

        $css_class = array('page_item', 'page-item-' . $page->ID);

        if (isset($args['pages_with_children'][$page->ID])) {
            $css_class[] = 'page_item_has_children';
        }

        if (!empty($current_page)) {
            $_current_page = get_post($current_page);
            if ($_current_page && in_array($page->ID, $_current_page->ancestors)) {
                $css_class[] = 'current_page_ancestor';
            }
            if ($page->ID == $current_page) {
                $css_class[] = 'current_page_item';
            } elseif ($_current_page && $page->ID == $_current_page->post_parent) {
                $css_class[] = 'current_page_parent';
            }
        } elseif ($page->ID == get_option('page_for_posts')) {
            $css_class[] = 'current_page_parent';
        }

        $css_classes = implode(' ', apply_filters('page_css_class', $css_class, $page, $depth, $args, $current_page));

        if ('' === $page->post_title) {
            /* translators: %d: ID of a post */
            $page->post_title = sprintf(__('#%d (no title)'), $page->ID);
        }

        $args['link_before'] = empty($args['link_before']) ? '' : $args['link_before'];
        $args['link_after'] = empty($args['link_after']) ? '' : $args['link_after'];


        # wpvs customisation
        $exclude_from_sitemap = get_post_meta($page->ID, 'exclude_from_sitemap', true);

        if ($exclude_from_sitemap != 'yes' && !is_null($exclude_from_sitemap)) {

            # Are we using icons?
            $wpvs_use_icons = get_option('wpvs_use_icons');
            $wpvs_fa_icon = $wpvs_use_icons == 'yes' ? get_post_meta($page->ID, 'wpvs_fa_icon', true) : '';
            $menu_icon_html = $wpvs_use_icons == 'yes' && !empty($wpvs_fa_icon) ? '<div class="wpvs_menu_icon"><i class="fa ' . $wpvs_fa_icon . '"></i></div>' : '';

            # How many columns?
            $number_of_columns_option = get_option('wpvs_number_of_columns');
            $wpvs_number_of_columns = !empty($number_of_columns_option) ? get_option('wpvs_number_of_columns') : '1';
            $li_class = $depth < 1 ? 'wpvs_column_' . $wpvs_number_of_columns . ' ' : '';

            # Output list item
            $output .= $indent . sprintf(
                '<li class="' . $li_class . '%s"><a href="%s">' . $menu_icon_html . '<span>%s%s%s</span></a>',
                $css_classes,
                get_permalink($page->ID),
                $args['link_before'],
                /** This filter is documented in wp-includes/post-template.php */
                apply_filters('the_title', $page->post_title, $page->ID),
                $args['link_after']
            );
        }
    }

    public function end_el(&$output, $page, $depth = 0, $args = array())
    {
        if (isset($args['item_spacing']) && 'preserve' === $args['item_spacing']) {
            $t = "\t";
            $n = "\n";
        } else {
            $t = '';
            $n = '';
        }

        $exclude_from_sitemap = get_post_meta($page->ID, 'exclude_from_sitemap', true);

        if ($exclude_from_sitemap != 'yes' && !is_null($exclude_from_sitemap)) {
            $output .= "</li>{$n}";
        }
    }
}



#************************************
#			Menu Walker
#************************************

/**
 * Create a nav menu with very basic markup.
 *
 * @author Thomas Scholz http://toscho.de
 * @version 1.0
 */
class wpvs_walker_menu extends Walker_Nav_Menu
{
	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = NULL, $id = 0 )
	{

        # Are we using icons?
        $wpvs_use_icons = get_option('wpvs_use_icons');
        $wpvs_fa_icon = $wpvs_use_icons == 'yes' ? get_post_meta($item->object_id, 'wpvs_fa_icon', true) : '';
        $menu_icon_html = $wpvs_use_icons == 'yes' && !empty($wpvs_fa_icon) ? '<div class="wpvs_menu_icon"><i class="fa ' . $wpvs_fa_icon . '"></i></div>' : '';

        # How many columns?
        $number_of_columns_option = get_option('wpvs_number_of_columns');
        $wpvs_number_of_columns = !empty($number_of_columns_option) ? get_option('wpvs_number_of_columns') : '1';
        $li_class = $depth < 1 ? 'wpvs_column_' . $wpvs_number_of_columns . ' ' : '';


		$output     .= '<li class="' . $li_class . '">';
		$attributes  = '';

		! empty ( $item->attr_title )
			// Avoid redundant titles
			and $item->attr_title !== $item->title
			and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';

		! empty ( $item->url )
			and $attributes .= ' href="' . esc_attr( $item->url ) .'"';

		$attributes  = trim( $attributes );
		$title       = apply_filters( 'the_title', $item->title, $item->ID );
		$item_output = "$args->before<a $attributes>" . $menu_icon_html ."$args->link_before$title</a>"
						. "$args->link_after$args->after";

		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
			,   $item_output
			,   $item
			,   $depth
			,   $args
		);
	}

	/**
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = NULL )
	{
		$output .= '<ul class="sub-menu">';
	}

	/**
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 0, $args = NULL )
	{
		$output .= '</ul>';
	}

	/**
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_el( &$output, $item, $depth = 0, $args = NULL )
	{
		$output .= '</li>';
	}
}




#************************************
#			Shortcode
#************************************

function wpvs_shortcode($atts)
{

    $wpvs_icon_background_colour        = get_option('wpvs_icon_background_colour');
    $wpvs_text_colour                    = get_option('wpvs_text_colour');
    $wpvs_hover_icon_background_colour = get_option('wpvs_hover_icon_background_colour');
    $wpvs_hover_text_colour            = get_option('wpvs_hover_text_colour');
    $wpvs_wpvs_line_colour                = get_option('wpvs_line_colour');
    $wpvs_font_size                    = get_option('wpvs_font_size');
    $wpvs_sort_by                   = get_option('wpvs_sort_by');
    $wpvs_sort_order                   = get_option('wpvs_sort_order');


    ob_start();
    ?>

    <style>
        ul.wpvs_wrapper li>a {
            <?php if (!empty($wpvs_icon_background_colour)) {
                echo 'background-color: ' . $wpvs_icon_background_colour . '; ';
            }

            ?><?php if (!empty($wpvs_text_colour)) {
                    echo 'color: ' . $wpvs_text_colour . '; ';
                }

                ?><?php if (!empty($wpvs_font_size)) {
                    echo 'font-size: ' . $wpvs_font_size . ';';
                }

                ?>
        }

        ul.wpvs_wrapper li>a:hover {
            <?php if (!empty($wpvs_hover_icon_background_colour)) {
                echo 'background-color: ' . $wpvs_hover_icon_background_colour . '; ';
            }

            ?><?php if (!empty($wpvs_hover_text_colour)) {
                    echo 'color: ' . $wpvs_hover_text_colour . ';';
                }

                ?>
        }

        ul.wpvs_wrapper li>a,
        ul.wpvs_wrapper>li ul li {
            <?php if (!empty($wpvs_line_colour)) {
                echo 'border-color: ' . $wpvs_line_colour . '; ';
            }

            ?>
        }
    </style>

    <?php
    $wpvs_walker = new wpvs_walker();
    $wpvs_walker_menu = new wpvs_walker_menu();

    $a = shortcode_atts( array(
        'menu' => ''
     ), $atts );

    $use_menu = $a['menu'];

    if(!empty($use_menu)) {
    
        if(is_nav_menu($use_menu)) {

        echo '<ul class="wpvs_wrapper">';

        wp_nav_menu(
            array(
                'menu' => $use_menu,
                'walker'     => $wpvs_walker_menu,
                'container' => '',
                'menu_class' => 'wpvs_wrapper',
                'link_before' => '<span>',
                'link_after' => '</span>',

            )

        );

        echo '</ul>';

        }

        else {
            echo '<strong>WPVS WARNING:</strong> Sorry, menu "' . $use_menu . '" does not exist';
        }

    }

    else {
    
        echo '<ul class="wpvs_wrapper">';

        wp_list_pages(
            array(
                'title_li' => '',
                'depth' => 6,
                'sort_column' => $wpvs_sort_by,
                'sort_order' => $wpvs_sort_order,
                'walker' => $wpvs_walker
            )

        );

        echo '</ul>';

    }

    $html = ob_get_clean();

    return $html;
}
add_shortcode('wp_visual_sitemap', 'wpvs_shortcode');