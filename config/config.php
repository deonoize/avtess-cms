<?php

use App\Models\User;

return [
    'admin_structure' => [
        'main'    => [
            'icon_class' => 'icon_home',
            //скрыть секцию
            'is_hidden'  => false,
            //страницы секции
            'pages'      => [
                'main'  => [
                    'type' => 'custom',
                ],
                'users' => [
                    'type'             => 'list',
                    //скрыть страницу
                    'is_hidden'        => false,
                    //название группы страниц, для ограничения доступа
                    'group'            => 'users',
                    //модель
                    'db_model'         => User::class,
                    //название страницы редактирования элемента
                    'page_element'     => 'user',
                    //название элемента в списке, пример: '{user_fio}{company_name} можно впендюрить сюда любой текст ({login})'
                    'name_element'     => '{first_name} {second_name} {third_name} ({position})',
                    //название страницы создание новго элемента
                    'page_new_element' => 'user_new',
                    //можно ли удалять элементы
                    'delete'           => true,
                    //можно ли менять видимость элементов
                    'visible'          => true,
                    //можно ли менять элементы местами
                    'priority'         => true,
                    //максимальный уровень создания вложенности
                    'tree'             => 3,
                ],

                'user_new' => [
                    'type'             => 'element',
                    'is_hidden'        => true,
                    'group'            => 'users',
                    'db_model'         => User::class,
                    'special_post_add' => 'user',
                    'special_view_add' => 'user',
                    'special_js_add'   => 'user',
                    'groups_fields'    => []
                ],
                'user'     => [
                    'type'             => 'element',
                    'is_hidden'        => true,
                    'group'            => 'users',
                    'db_model'         => User::class,
                    'special_post_add' => 'user',
                    'special_view_add' => 'user',
                    'special_js_add'   => 'user',
                    'groups_fields'    => [
                        [
                            'fields' => [
                                [
                                    'type'         => 'input',
                                    'key_lang'     => 'email',
                                    'db_column'    => 'login',
                                    'unique'       => 1,
                                    'options_html' => [
                                        'type'     => 'email',
                                        'required' => 1,
                                    ],
                                ],
                                [
                                    'type'           => 'select',
                                    'key_lang'       => 'visible',
                                    'db_column'      => 'visible',
                                    'options_html'   => [
                                        'required' => 1,
                                    ],
                                    'select_options' => [
                                        '0' => 'Да',
                                        '1' => 'Нет',
                                    ],
                                ],
                                [
                                    'type'           => 'select',
                                    'key_lang'       => 'type',
                                    'db_column'      => 'type',
                                    'options_html'   => [
                                        'required' => 1,
                                    ],
                                    'select_options' => [
                                        '1' => 'Администратор',
                                        '3' => 'Пользователь',
                                    ],
                                ],
                                [
                                    'type'         => 'input',
                                    'key_lang'     => 'first_name',
                                    'db_column'    => 'first_name',
                                    'options_html' => [
                                        'required' => 1,
                                    ],
                                ],
                                [
                                    'type'      => 'input',
                                    'key_lang'  => 'second_name',
                                    'db_column' => 'second_name',
                                ],
                                [
                                    'type'      => 'input',
                                    'key_lang'  => 'third_name',
                                    'db_column' => 'third_name',
                                ],
                                [
                                    'type'           => 'select',
                                    'key_lang'       => 'gender',
                                    'db_column'      => 'gender',
                                    'select_options' => [
                                        '1' => 'Мужской',
                                        '2' => 'Женский',
                                    ],
                                ],
                                [
                                    'type'      => 'input',
                                    'key_lang'  => 'position',
                                    'db_column' => 'position',
                                ],
                                [
                                    'type'      => 'images',
                                    'key_lang'  => 'photo',
                                    'db_column' => 'photo',
                                    'count_max' => 1,
                                ]
                            ]
                        ],
                        [
                            'key_lang' => 'set_password',
                            'fields'   => [
                                [
                                    'type'        => 'input',
                                    'key_lang'    => 'password',
                                    'db_column'   => 'password',
                                    'field_skip'  => 1,
                                    'empty_value' => 1,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'pages'   => [
            'icon_class' => 'icon_archive2',
            'pages'      => []
        ],
        'reviews' => [
            'icon_class' => 'icon_megaphone',
            'pages'      => []
        ],
    ],
    'admin_page_main' => 'main',
];
