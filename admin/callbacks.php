<?php

class Menu_Factory_Callbacks
{
    public function section_callback()
    { }
    public function submenu_callback()
    {
        require_once plugin_dir_path(__FILE__) . 'views/menu-factory-admin-display.php';
    }
    public function text_field($args)
    {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $options = get_option($option_name);
        $value = $options[$name];

        echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required>';
    }

    public function checkbox_field($args)
    {
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $options = get_option($option_name);
        $checked = isset($options[$name]) ? 1 : 0;

        echo '<input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ($checked ? ' checked' : '') . '>';
    }

    public function select_field($args)
    {
        $output = '';
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $options = get_option($option_name);
        $value = $options[$name];


        $taxonomies = get_taxonomies([
            'show_ui'   => true,
            'hierarchical' => true
        ]);

        echo '<select id="' . $name . '"
        name="' . $option_name . '[' . $name . ']" required>';

        foreach ($taxonomies as $taxonomy) {
            $selected =   $value == $taxonomy ? 'selected' : '';
            var_dump($selected);
            $output .= '
            <option id="' . $taxonomy . '" name="' . $option_name . '[' . $name . ']" value="' . $taxonomy . '" ' . $selected . '>Taxonomy : ' . ucfirst($taxonomy) . '</option>';
        }

        echo $output;
        echo '</select>';
    }
}
