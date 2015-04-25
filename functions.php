<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles() {
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

add_action('widgets_init', function() {
  register_widget('Mini_Meta_Widget');
});
class Mini_Meta_Widget extends WP_Widget {
  function __construct() {
    parent::__construct(
      'meta', // Base ID (we want this to use the widget_meta class)
      __('Mini Meta'), // Name
      array('description' => __('Log in/out, and Host Admin'),) // Args
    );
  }

  public function widget($args, $instance) {
    extract($args);
    $title = apply_filters('widget_title', empty($instance['title']) ? __('Meta') : $instance['title'], $instance, $this->id_base);

    echo $before_widget;
    if ($title) {
      echo $before_title . $title . $after_title;
    }
    ?>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>
<?php wp_meta(); ?>
<li><a href="https://xaes.securecnc.net/CNC/index.cgi">Host Admin</a></li>
</ul>
<?php
    echo $after_widget;
  }

  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    return $instance;
  }

  public function form($instance) {
    if (isset($instance['title'])) {
      $title = $instance['title'];
    } else {
      $title = __('New title');
    }
    ?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<?php
  }

}
