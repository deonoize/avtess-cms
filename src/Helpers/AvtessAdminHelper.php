<?php

namespace Deonoize\AvtessCMS\Helpers;

use Illuminate\Support\Collection;

class AvtessAdminHelper {
    /**
     * Load Admin structure
     *
     * @param  array  $admin_structure
     *
     * @return Collection
     */
    static public function loadStructure(array $admin_structure) {
        $sections = collect($admin_structure['sections']);

        // Перебираем секции
        foreach ($sections as $key_section => $section) {
            // Добавляем заголовок к секции
            $section['title'] = trans('admin.section.'.$key_section);

            // Перебираем страницы
            $pages = collect([]);
            foreach ($section['pages'] as $page_name) {
                $pages->put($page_name, $admin_structure['pages'][$page_name]);
            }
            $section['pages'] = self::loadPagesStructure($pages, $section);

            // Удаляем пустые секции
            if ($section['pages']->isEmpty()) {
                $sections->forget($key_section);
            } else {
                $sections[$key_section] = $section;
            }
        }

        return $sections;
    }

    /**
     * Load Pages Admin structure
     *
     * @param  Collection  $pages
     * @param $section
     *
     * @return Collection
     */
    static private function loadPagesStructure(Collection $pages, $section) {
        foreach ($pages as $key_page => $page) {
            $page['key'] = $key_page;

            // Удаляем страницу если она отключена
            if (isset($page['is_enabled']) && !$page['is_enabled']) {
                $pages->forget($key_page);
                continue;
            }

            // Добавляем заголовок к странице
            $page['title'] = trans('admin.pages.'.$key_page);

            // Если хоть одна страница не скрыта, то секция также не скрыта
            if (!isset($page['is_hidden']) || !$page['is_hidden']) {
                $section['is_hidden'] = false;
            }

            if ($page['type'] == 'element') {
                // Перебираем группы полей
                $groups_fields = config('avtess_cms.admin.pages_groups_fields.'.$key_page);
                $page['groups_fields'] = self::loadFieldsStructure(collect($groups_fields), $key_page);
            }

            if ($page['type'] == 'list' && !isset($page['name_element'])) {
                // Добавляем название элемента в списке
                $page['name_element'] = trans('admin.lists_el_name.'.$key_page);
            }

            $pages[$key_page] = $page;
        }
        return $pages;
    }

    /**
     * Load Fields Pages Admin structure
     *
     * @param  Collection  $groups
     * @param $key_page
     *
     * @return Collection
     */
    static private function loadFieldsStructure(Collection $groups, $key_page) {
        return $groups->map(
            function ($group, $key_group) use ($key_page) {
                $fields = collect($group);
                $group = [];
                $group['fields'] = $fields;

                // Перебираем поля
                $group['fields'] = $group['fields']->map(
                    function ($field) use ($key_page) {
                        // Добавляем заголовок к полю
                        if (isset($field['key_lang'])) {
                            $field['label'] = trans('admin.fields.'.$key_page.'.'.$field['key_lang'].'.'.'label');
                        } else {
                            $field['label'] = '';
                        }

                        return $field;
                    }
                );

                // Добавляем заголовок к группе полей
                if (!is_numeric($key_group)) {
                    $group['title'] = trans('admin.groups_fields.'.$key_page.'.'.$key_group);
                } else {
                    $group['title'] = '';
                }

                return $group;
            }
        );
    }
}
