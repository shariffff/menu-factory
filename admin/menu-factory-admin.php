<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 * @package    Menu_Factory
 */

class Menu_Factory_Admin
{
	public $callbacks;
	/**
	 * Register the core services/actions for the admin area.
	 * @since    1.0.0
	 */
	public function register()
	{
		$this->callbacks = new Menu_Factory_Callbacks();
		add_action('admin_menu', [$this, 'register_sub_menu']);
		add_action('admin_init', [$this, 'settings_init']);
	}


	public function settings_init()
	{

		register_setting('menu_factory_options_group', 'menu_factory_options');

		add_settings_section(
			'menu_factory_section',
			__('Menu Factory', 'menu-factory'),
			[$this->callbacks, 'section_callback'],
			'menu-factory'
		);

		$fields = [
			[
				'id' => 'title',
				'title' => 'Menu Title',
				'callback' => 'text_field',
				'placeholder' => 'eg. Primary Menu',
			],
			[
				'id' => 'source',
				'title' => 'Select Source',
				'callback' => 'select_field',
				'placeholder' => '',
			],
			[
				'id' => 'hierarchy',
				'title' => 'Maintain Hierarchy',
				'callback' => 'checkbox_field',
				'placeholder' => '',
			]
		];
		foreach ($fields as $key => $value) {
			add_settings_field(
				$value['id'],
				__($value['title'], 'menu-factory'),
				[$this->callbacks, $value['callback']],
				'menu-factory',
				'menu_factory_section',
				[
					'label_for' => $value['id'],
					'option_name' => 'menu_factory_options',
					'placeholder' => $value['placeholder'],
				]
			);
		}
	}

	/**
	 * Register Sub Menu
	 * @since    1.0.0
	 * @return void
	 */
	public function register_sub_menu()
	{
		add_submenu_page(
			'tools.php',
			'Menu Factory',
			'Menu Factory',
			'manage_options',
			'menu-factory',
			[$this->callbacks, 'submenu_callback']
		);
	}
}
