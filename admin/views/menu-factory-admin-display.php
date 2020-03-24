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
    add_settings_error('wporg_messages', 'wporg_message', __('Complete example which adds a Top-Level Menu named WPOrg, registers a custom option named wporg_options and performs the CRUD (create, read, update, delete) logic using Settings API and Options API (including showing error/update messages).

    ', 'wporg'), 'updated');
}
settings_errors('wporg_messages');
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