<?php
/**
 * Plugin Name: Link Reposter
 * Author: Bo Li
 * Version: 0.1
 * License: GPLv2 or later
 * Description: Extract content from the article of the given link and publish.
 * 
 * This widget interface learned from the Example Widget authored by
 * Justin Tadlock. The original license is listed below. 
 */

define('LR_DIR_URL', plugin_dir_url(__FILE__));
/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'lr_load_widgets' );
load_plugin_textdomain('link-reposter', false, dirname(plugin_basename(__FILE__)) . '/languages/');

/**
 * Register our widget.
 * 'Example_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function lr_load_widgets() {
    wp_register_style('link-reposter.css',  LR_DIR_URL. '/link-reposter.css');
    wp_enqueue_style('link-reposter.css');

	register_widget( 'LinkReposter_Widget' );
}

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class LinkReposter_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function LinkReposter_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'description' => __('Extract content from a user input link and repost it', 'link-reposter') );

		/* Widget control settings. */
//		$control_ops = array( 'id_base' => 'link-reposter' );

		/* Create the widget. */
		$this->WP_Widget( 'link-reposter', __('Link Reposter', 'link-reposter'), $widget_ops);
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
        
        /* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
?> 
        <script>
        function open_editor() {
            var editor_url = '<?php echo LR_DIR_URL . '/lr-redirect.php?url='; ?>';
            editor_url = editor_url + encodeURIComponent(document.getElementsByName('url')[0].value);
            window.open(editor_url, '[link-reposter] Repost a article', 'height=600,width=800');
        }
        </script>
        <div>
        <input type="text" class="field" value="<?php _e('Put the link to repost an article', 'link-reposter');?>" 
                   name="url" id="lr-url-field" 
                   onfocus="this.value='http://'"/>
        <input type="image" src="<?php echo LR_DIR_URL . '/icon-press-release.jpg'; ?>" 
                   name="submit" id="lr-url-submit" onclick="open_editor()"/>
        </div>
        <div style="color: DarkGray; font-size: 11px;">
        <p> <?php _e('Repost external article by pasting the link here.', 'link-reposter')?> </p>
        </div>
<?

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
        
        return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Link Reposter', 'link-reposter'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>


	<?php
	}
}

?>
