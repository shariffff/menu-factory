<?php
class Menu_Factory_Nav
{

    public function register()
    {

        add_action('load-nav-menus.php', [$this, 'menu_factory_create_nav']);
    }

    protected function create_item($term_id, $collection, $source,  $newArg = [])
    {

        $arguments =  array_merge([
            'menu-item-title' => $collection->name,
            'menu-item-object-id' => $collection->term_id,
            'menu-item-db-id' => $collection->term_id,
            'menu-item-object' => $source,
            'menu-item-type' => 'taxonomy',
            'menu-item-url' => get_category_link($collection->term_id),
            'menu-item-status' => 'publish'
        ], $newArg);

        return wp_update_nav_menu_item($term_id, 0, $arguments, $source);
    }



    public function menu_factory_create_nav()
    {
        $options = get_option('menu_factory_options');
        $name = $options['title'];
        $source = $options['source'];

        //FIXME: Apply this setting
        $hierarchy = $options['hierarchy'] ?? false;

        $menu_exists = wp_get_nav_menu_object($name);

        if ($menu_exists || !isset($name) || !isset($source)) {
            return;
        }

        $menu_id = wp_create_nav_menu($name);
        $menu = get_term_by('name', $name, 'nav_menu');
        $term_id = $menu->term_id;

        $parent = get_categories([
            'hide_empty' => 0,
            'parent' => 0,
            'taxonomy' => $source
        ]);


        if (count($parent) > 0) {
            foreach ($parent as $collection) {
                $label_one = $this->create_item($term_id, $collection, $source);

                $child = get_categories([
                    'hide_empty' => 0,
                    'parent' => $collection->term_id,
                    'taxonomy' => $source
                ]);

                if (count($child) > 0) {
                    foreach ($child as $childCat) {
                        $label_two = $this->create_item($term_id, $childCat, $source, ['menu-item-parent-id' => $label_one]);

                        $grandChilds = get_categories([
                            'hide_empty' => 0,
                            'parent' => $childCat->term_id,
                            'taxonomy' => $source
                        ]);
                        if (count($grandChilds) > 0) {
                            foreach ($grandChilds as $grandchild) {
                                $label_three = $this->create_item(
                                    $term_id,
                                    $grandchild,
                                    $source,
                                    ['menu-item-parent-id' => $label_two]
                                );
                                $greatGrandChilds = get_categories([
                                    'hide_empty' => 0,
                                    'parent' => $grandchild->term_id,
                                    'taxonomy' => $source
                                ]);

                                foreach ($greatGrandChilds as $greatGrandChild) {
                                    $label_four = $this->create_item(
                                        $term_id,
                                        $greatGrandChild,
                                        $source,
                                        ['menu-item-parent-id' => $label_three]
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
