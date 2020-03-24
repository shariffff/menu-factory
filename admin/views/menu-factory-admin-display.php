<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Menu_Factory
 * @subpackage Menu_Factory/admin/views
 */
if (!current_user_can('manage_options')) {
    return;
}
if (isset($_GET['settings-updated'])) {
    add_settings_error('menu_factory_message', 'menu_factory_message', __('Menu created. Check it here', 'menu-factory'), 'updated');
}
settings_errors('menu_factory_message');
?>
<div class="wrap">
    <form action="options.php" method="post">
        <?php

        settings_fields('menu_factory_options_group');

        do_settings_sections('menu-factory');

        submit_button('Create Menu');
        ?>
    </form>
</div>