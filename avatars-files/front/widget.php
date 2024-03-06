<?php

/**
 * WidgetAvatar Class
 */
class WA_Widget_Avatars extends WP_Widget {

    public function __construct() {
        parent::__construct( false, __( 'Avatare Widget', 'avatars' ) );
    }

    public function widget( $args, $instance ) {
        $defaults = $this->get_default_instance();
        $instance = wp_parse_args( $instance, $defaults );

        $title = apply_filters('widget_title', isset( $instance['title'] ) ? $instance['title'] : '');

        echo $args['before_widget'];
        if ( $title )
            echo $args['before_title'] . $title . $args['after_title'];
        echo get_blog_avatar( get_current_blog_id(), $instance['size'], '' );
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = isset($new_instance['title']) && is_string($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['size'] = in_array( absint( $new_instance['size'] ), Avatars::get_avatar_sizes(), true ) ? absint( $new_instance['size'] ) : 128;
        return $instance;
    }

    public function form( $instance ) {
        $defaults = $this->get_default_instance();

        $instance = wp_parse_args( $instance, $defaults );

        $title = esc_attr( $instance['title'] );
        $size = $instance['size'];
        $sizes = Avatars::get_avatar_sizes();

        ?>
        <p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e( 'Titel:', 'avatars' ); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('size') ); ?>"><?php _e( 'Avatar Größe:', 'avatars' ); ?> 
            <select id="<?php echo esc_attr( $this->get_field_id('size') ); ?>" name="<?php echo esc_attr( $this->get_field_name('size') ); ?>">
                <?php foreach ( $sizes as $avatar_size ): ?>
                    <option value="<?php echo $avatar_size; ?>" <?php selected( $avatar_size, $size ); ?>><?php echo $avatar_size; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    protected function get_default_instance() {
        return [
            'title' => '',
            'size' => 128
        ];
    }
}
