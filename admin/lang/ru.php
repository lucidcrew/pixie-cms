<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Language File (Russian).                                 //
// It is translated - O.Smolinsky aka OSU                          //
//(http://sites.google.com/site/osmolinsky/)                       //
//*****************************************************************//
if (!isset($delete)) { $delete = NULL; }
if (!isset($username)) { $username = NULL; }
$lang = array(
    /* System */
    'skip_to' => 'перейти к содержимому',
    'view_site' => 'На Сайт',
    'logout' => 'Выход',
    'license' => 'Лицензия',
    'tag_line' => 'Легкий и простой редактор Сайта',
    'latest_referrals' => 'последние рефералы',
    'latest_activity' => 'последние действия',
    'feed_subscribe' => 'Подписка на новости',
    'rss_feed' => 'RSS Фид',
    'when' => 'Дата',
    'who' => 'Логин',
    'what' => 'Действия',
    'from' => 'Для',
    'switch_to' => 'Переход на',
    'a_few_seconds' => 'Несколько секунд',
    'a_minute' => 'минуту',
    'минуты' => 'минуты',
    'a_hour' => 'час',
    'часов' => 'часов',
    'a_day' => 'день',
    'days' => 'дней',
    'ago' => 'назад.',
    'user' => 'Пользователь',
    'to' => 'из',
    'database_backup' => 'Архивирование базы данных',
    'database_info' => 'Удостоверьтесь что база данных поддерживается. Используйте кнопку справа, чтобы вручную архивировать базу данных. Архивы сохраняются в папке /files/sqlbackups/*** и могут быть загружены из списка ниже. Ваше последнее сохранение подсвечено.',
    'database_backups' => 'Архивы',
    'download' => 'Загрузить',
    'delete' => 'Удалить',
    'delete_file' => 'Удалить файл?',
    'theme_info' => 'Имеющиеся в настоящее время темы указаны ниже. Активная тема Сайта подсвечена. Вы можете установить дополнительные темы, загружая их в папку /admin/themes. Темы могут быть загружены с <href = "http://www.getpixie.co.uk"> www.getpixie.co.uk </a>, или Вы можете легко создать собственные таблицы стилей CSS.',
    'theme_pick' => 'Выберите тему для Вашего Сайта',
    'theme_apply' => 'Выбрать эту тему',
    'sure_delete_page' => 'Удалить?',
    'sure_empty_page' => 'Освободить?',
    'settings_page' => 'страница',
    'settings_plugin' => 'плагин',
    'plugins' => 'Плагины',
    'plugins_info' => 'Плагины расширяют функциональные возможности определенных страниц Вашего вебсайта.',
    'empty' => 'Отключить',
    'oops' => 'Oй!',
    'feature_disabled' => 'Эта функция в настоящее время заблокирована. В следующей версии будет исправлено!',
    'pages_in_navigation' => 'Навигатор страниц',
    'pages_in_navigation_info' => 'Все созданные страницы появляются в Навигации по вебсайту, чтобы изменить размещение страниц их перемещают вверх и вниз перетаскиванием. Страница наверху списка будет являться первой в Навигации.', 
    'pages_outside_navigation' => 'Страницы вне Навигации',
    'pages_outside_navigation_info' => 'Эти страницы активны , но не видны в Навигации по вебсайту.', 
    'pages_disabled' => 'Отключенные страницы',
    'pages_disabled_info' => 'Эти страницы не активны.',
    'edit_user' => 'Редактировать Пользователя',
    'create_user' => 'Создать Пользователя',
    'create_user_info' => 'Электронная почта будет послана новому пользователю с деталями того, как войти и случайным образом сгенерированный пароль.',
    'user_info' => 'Ниже список пользователей с указанием прав. Чтобы помочь управлять Сайтом, Вы можете добавить больше пользователей при помощи формы справа. Учетная запись пользователя с правами администрирования подсвечена.',
    'user_delete_confirm' => 'Удалить пользователя:',
    'tags' => 'Тэги',
    'upload' => 'Загрузить',
    'file_manager_info' => 'Максимальный размер файла установлен в 100 МБ. Будьте внимательны при загрузке больших файлов.',
    'file_manager_latest' => 'Последние загрузки',
    'file_manager_tagged' => 'Все файлы отмечены:',
    'filename' => 'Имя файла',
    'filedate' => 'Дата изменения',
    'results_from' => 'Результаты',
    'sure_delete_entry' => 'Удалить запись',
    'from_the' => 'от',
    'page_settings' => 'Параметры страницы',
    'advanced' => 'Расширенные',
    'your_site_has' => 'На Сайте',
    'visitors_online' => 'посетитель(ей) онлайн.',    
    'in_the_last' => 'Последние',
    'site_visitors' => 'Посетителей сайта.',
    'page_views' => 'Просмотров страниц.',
    'spam_attacks' => 'Атак спамеров.',
    'last_login_on' => 'Следующий отчет запланирован на:',
    'quick' => 'Быстрые',
    'links' => 'ссылки',
    'new_entry' => ' Добавить в  ',
    'entry' => 'запись.',
    'edit' => ' Редактировать  ',
    'page' => 'страница.',
    'blog' => 'блог.',
    'search' => 'Поиск',
    'forums' => 'форум.',
    'downloads' => 'загрузка.',
    'create_backup' => 'Создать архив',
    'button_backup' => 'Архивировать базу данных',
    'page_type' => 'Тип Страницы',
    'settings_page_new' => 'Создать новую',
    'total_records' => 'Полный отчет',
    'showing_from_record' => 'просмотреть отчет',
    'page(s)' => 'страница(ы)',
    'help' => 'Помощь',
    'statistics' => 'Статистика',
    'help_settings_page_type' => 'Добавляя новую страницу Вы можете выбрать из трех типов:',
    'help_settings_page_dynamic' => 'Примеры динамических страниц - страницы новостей и блоги. Эти страницы поддерживают RSS и комментарии.',
    'help_settings_page_static' => 'Статическая страница - просто блок HTML (или PHP, по желанию). Эти страницы подходят для редко обновляемого содержимого.',
    'help_settings_page_module' => 'Страница модуля добавляет определенный функционал Вашему Сайту. Модули могут быть загружены от <href = "http://www.getpixie.co.uk"> www.getpixie.co.uk </a>, примером является модуль событий. Модули иногда связаны с плагинами.',
    'help_settings_user_type' => 'Добавляя нового пользователя Вы можете выбрать из трех типов:',
    'help_settings_user_admin' => '<b>Администратор</b> - У администраторов есть доступ ко всему Сайту, они могут редактировать настройки, создавать и пополнять содержимое страниц и делать что им нравится.',
    'help_settings_user_client' => '<b>Клиент</b> - Может добавлять содержимое Сайта, но не может редактировать параметры настройки сайта.',
    'help_settings_user_user' => '<b>Пользователь</b> - У пользователя есть доступ к вкладке Панель личных настроек, они имеют "профиль" и могут видеть статистику вебсайта.',
    'install_module' => 'Установить новый модуль или плагин',
    'select_module' => 'Выберите модуль или плагин, которые нужно активировать',
    'all_installed' => 'Все доступные модули и плагины в настоящее время установлены и активны.',
    /* System messages */
    'error_save_settings' => 'Ошибка сохранения настроек.',
    'ok_save_settings' => 'Ваши новые настройки были сохранены и применены.',
    'comment_spam' => 'Спам комментарии заблокированы.',
    'failed_login' => 'Неудачная попытка входа в систему.',
    'login_exceeded' => 'Вы превысили максимальное количество попыток (3), чтобы войти вновь, пожалуйста попробуйте еще раз через 24 часа.',
    'logins_exceeded' => 'Обнаружены 3 неудавшихся попытки входа в систему. Система блокировала этот IP адрес  на 24 часа.',
    'ok_login' => 'Пользователь ' . $username . ' Вход',
    'failed_protected_page' => 'Невозможно удалить 404 страницу, возможно попытка взлома.',
    'ok_delete_page' => 'Успешно удалено',
    'ok_delete_entry' => 'Успешно удален (#' . $delete . ')',
    'failed_delete' => 'Невозможно удалить элемент (#' . $delete . ').',
    'login_missing' => 'Пожалуйста предоставьте запрошенную информацию Логина.',
    'login_incorrect' => 'Ваш Логин не действителен.',
    'forgotten_missing' => 'Вы предоставили не правильный Логин или  E-mail.',
    'forgotten_ok' => 'Новый пароль выслан на Ваш адрес электронной почты.',
    'forgotten_log_error' => 'Неудавшаяся попытка сбросить пароль.',
    'forgotten_log_ok' => 'Новый пароль выслан',
    'rss_access_attempt' => 'Несанкционированная попытка обратиться к приватному фиду RSS. Вы должны повторно подписаться на RSS из формы Сайта.',
    'unknown_error' => 'Кое-что пошло не так, как надо. Возможно (но вряд ли), база данных нарушена. Или Вы произвели явно неверные действия?',
    'unknown_edit_url' => 'URL, для редактирования данной страницы, не действителен.',
    'unknown_referrer' => 'Неизвесная ссылка.',
    'profile_name_error' => 'Укажите полное Имя.', 
    'profile_email_error' => 'Укажите действительный E-mail адрес.', 
    'profile_web_error' => 'Укажите действительный web адрес.', 
    'profile_ok' => 'Ваш профиль обновлен.',
    'profile_password_error' => 'Не получилось сохранить Ваш новый пароль. Почему бы не попробовать еще раз?',
    'profile_password_ok' => 'Ваш пароль был обновлен. Вы должны будете использовать его при следующем входе в систему.',
    'profile_password_invalid' => 'Пароль не верен.',
    'profile_password_invalid_length' => 'Пароль должен состоять по крайней мере из 6 символов.',
    'profile_password_match_error' => 'Пароли не идиентичны.',
    'profile_password_missing' => 'Пожалуйста предоставьте всю запрошенную информацию.',
    'site_name_error' => 'Требуется название Вашего сайта.',
    'site_url_error' =>  'Пожалуйста обеспечьте правильный URL вебсайта.',
    'backup_ok' => 'Архив Б.Д. успешно создан.',
    'backup_delete_ok' => 'Удален архив Б.Д.:',
    'backup_delete_no' => 'Вы не можете удалить последний архив.',
    'backup_delete_error' => 'Сбой при удалении архива.',
    'theme_ok' => 'Тема изменена.',
    'theme_error' => 'Невозможно изменить Вашу тему.',
    'all_content_deleted' => 'Все содержание было удалено из',
    'user_delete_ok' => ' был удален с Сайта.',
    'user_delete_error' => 'Пользователь не удален.',
    'user_name_missing' => 'Введите Логин.',
    'user_realname_missing' => 'Введите Имя.',
    'user_password_missing' => 'Введите пароль.',
    'user_email_error' => 'Введите действительный E-mail адрес.',
    'user_update_ok' => 'Настройки сохранены для ',
    'user_duplicate' => 'Логин занят, введите другой.',
    'user_new_ok' => 'Новый пользователь: ',
    'saved_new_settings_for' => 'Сохранены новые настройки для ',
    'file_upload_error' => 'Проблема с внесением информации в базу данных, данные возможно не загружены.',
    'file_upload_tag_error' => 'Пожалуйста удостоверьтесь в загрузке.',
    'file_delete_ok' => 'Успешное удаление файла:',
    'file_delete_fail' => 'Невозможно удалить файл:',
    'form_build_fail' => 'Невозможно построить доступную для редактирования форму... Вы ввели правильные детали таблицы в своем модуле?',
    'date_error' => 'Вы ввели недопустимую дату.',
    'email_error' => 'Пожалуйста удостоверьтесь, что Вы ввели правильный адрес электронной почты.',
    'url_error' => 'Пожалуйста удостоверьтесь, что Вы ввели правильный URL.',
    'is_required' => 'необходимая область.',
    'saved_new' => 'Сохранены изменения ',
    'in_the' => 'в',
    'on_the' => 'на',
    'saved_new_page' => 'Создана новая страница',
    'save_update_entry' => 'Обновление сохранено',
    'bad_cookie' => 'Ваш cookie просрочен (smelly!), Вы должны будете войти снова.',
    'no_module_selected' => 'Вы не выбрали модуль или плагин для установки, попробуйте еще раз.',
    'install_module_ok' => ' был установлен успешно.',
    /* Helper */
    'helper_plugin' => 'Вы не можете редактировать параметры настроек плагина, тем не менее - Вы можете отключить или удалить плагин воспользвавщись кнопкой выше. Если Вы удалите плагин, например плагин комментариев, то Ваши посетители будут не в состоянии оставлять комментарии на Ваших динамических страницах.',
    'helper_nocontent' => 'Эта страница не имеет никакого содержания, используйте зеленую кнопку выше, чтобы добавить начальную информацию (зеленая кнопка не доступна для плагина комментариев).',
    'helper_nopages' => 'Мудрый человек однажды сказал, что вебсайт без страниц походит на птицу без крыльев... Используйте форму для добавления первой страницы на Ваш сайт. Как только Вы все сделаете, то это проницательное сообщение, будет удалено.',
    'helper_nopages404' => 'У Вашего сайта есть только одна страница, это страница - 404 (ошибочно запрошенных страниц) она может быть отредактирована ниже..',
    'helper_nopagesadmin' => 'Вы можете <a href="?s=settings">добавить больше страниц \'Материал Установки\' раздела</a> Сайта.', 
    'helper_nopagesuser' => 'Свяжитесь с Администратором и попросите, чтобы он добавил нужные страницы на Ваш вебсайт.',
    'helper_search' => 'Поиск не дал результата. Попытайтесь изменить запрос.',
    /* Navigation */
    'nav1_settings' => 'Настройки',
    'nav1_publish' => 'Публикации',
    'nav1_home' => 'Панель',
    'nav2_home' => 'Главная',
    'nav2_profile' => 'Профиль',
    'nav2_security' => 'Пароль',
    'nav2_logs' => 'Логи',
    'nav2_delete' => 'Удалить учетную запись',
    'nav2_pages' => 'Страницы',
    'nav2_files' => 'Менеджер файлов',
    'nav2_backup' => 'Архив БД',
    'nav2_users' => 'Регистрация',
    'nav2_blocks' => 'Блоки',
    'nav2_theme' => 'Темы',
    'nav2_site' => 'Сайт',
    'nav2_settings' => 'Настройки',
    /* Forms */
    'form_login' => 'Вход в систему',
    'form_username' => 'Логин',
    'form_password' => 'Пароль',
    'form_rememberme' => 'Запомнить меня для последующего входа.',
    'form_forgotten' => 'Восстановить забытый пароль',
    'form_returnto' => 'Вернуться к ',
    'form_help_forgotten' => 'Пожалуйста введите свой E-mail адрес или Логин Вашей учетной записи. Ваш пароль будет удален, а новый послан на Ваш E-mail.',
    'form_resetpassword' => 'Пароль удален',
    'form_name' => 'Полное Имя',
    'form_usernameoremail' => 'Логин или E-mail',
    'form_telephone' => 'Телефон',
    'form_email' => 'E-mail',
    'form_website' => 'Мой вебсайт',
    'form_occupation' => 'Род занятий',
    'form_address_street' => 'Домашний адрес',
    'form_address_town' => 'Город (Поселок)',
    'form_address_county' => 'Область/Регион',
    'form_address_pcode' => 'Индекс',
    'form_address_country' => 'Страна',
    'form_address_biography' => 'Авто-Биография',
    'form_fl1' => 'Мои избранные ссылки',
    'form_button_save' => 'Сохранить',
    'form_button_update' => 'Обновить',
    'form_button_cancel' => 'Отменить',
    'form_button_install' => 'Установить',
    'form_button_create_page' => 'Создать страницу',
    'form_current_password' => 'Текущий пароль',
    'form_new_password' => 'Новый пароль',
    'form_confirm_password' => 'Повторить пароль',
    'form_tags' => 'Тэги',
    'form_content' => 'Содержимое',
    'form_comments' => 'Коментарии',
    'form_public' => 'Доступно',
    'form_optional'=> '(не обязательно)',
    'form_required'=> '*',
    'form_title'=> 'Заголовок',
    'form_posted'=> 'Дата и Время',
    'form_date' => 'Формат даты',
    'form_help_comments' => 'Разрешить комментировать сообщение?',
    'form_help_public' => 'Сделать это(у) сообщение/страницу видимой посетителями (пользователями)? (выберите нет, для сохранения в виде черновика).',
    'form_help_tags' => 'Тэги работают как категории и делают поиск более легким и точным. Укажите ключевые слова отделив их пробелами.',
    'form_help_current_tags' => 'Предложения:',
    'form_help_current_blocks' => 'Доступные Блоки:',
    'form_php_warning' => '(Эта страница содержит PHP. Редактор текста был не в состоянии безопасно редактировать данное содержимое),',
    'form_legend_site_settings' => 'Основные настройки вебсайта',
    'form_site_name' => 'Название Сайта',
    'form_help_site_name' => 'Какое название будет показано посетителям Сайта?',
    'form_page_name' => 'Термин/URL',
    'form_help_page_name' => 'Это будет использоваться, для создания URL вашей страницы (e.g. http://www.yoursite.com/<b>somepage</b>/).',
    'form_page_display_name' => 'Название страницы',
    'form_help_page_display_name' => 'Как будет названа ваша страница?',
    'form_page_description' => 'Дескрипт страницы',
    'form_help_page_description' => 'Заполните описание вашей страницы.',
    'form_page_blocks' => 'Блоки на странице',
    'form_help_page_blocks' => 'Блоки - дополнительное содержание, которые находятся на вашей странице. Названия блоков должны быть отделены пробелами. (управление блоками будет улучшено в будущих версиях).',
    'form_searchable' => 'Доступно для поиска',
    'form_help_searchable' => 'Разрешить всем пользователям находить данную страницу посредством поиска по Сайту?',
    'form_posts_per_page' => 'Сообщений не страницу',
    'form_help_posts_per_page' => 'Установите ограничение количества сообщений на страницу.',
    'form_rss' => 'RSS',
    'form_help_rss' => 'Сделать содержание страницы доступным для RSS-фида?',
    'form_in_navigation' => 'В Навигации',
    'form_help_in_navigation' => 'Показывать ссылку на данную страницу в навигации по вебсайту?',
    'form_site_url' => 'Сетевой адрес Сайта',
    'form_help_site_url' => 'Каков URL вашего вебсайта? (например http: // www.yoursite.com/).',
    'form_site_homepage' => 'Первичная страница Сайта',
    'form_help_homepage' => 'Какую из страниц Сайта показывать посетителям как Главную (Домой)?',
    'form_site_keywords' => 'Ключевые метки Сайта',
    'form_help_site_keywords' => 'Напишите список ключевых слов, отделенных запятыми. (например: this, site, rules).',
    'form_site_author' => 'Владелец Сайта',
    'form_site_copyright' => 'Исполнитель',
    'form_site_curl' => 'Включить Чистый URL',
    'form_help_site_curl' => 'Ссылки с Чистым URL выглядят так - www.yoursite.com/clean/, без использования функции это выглядит так - www.yoursite.com?s=clean. Функция чистые URLs работает только на Linux хостингах.',
    'form_legend_pixie_settings' => 'Основные параметры Сайта',
    'form_pixie_language' => 'Язык Сайта',
    'form_help_pixie_language' => 'Выберите язык Сайта из списка.',
    'form_pixie_timezone' => 'Часовой пояс',
    'form_help_pixie_timezone' => 'Выберите соответствующую временную зону.',
    'form_pixie_dst' => 'Переход на летнее время',
    'form_help_pixie_dst' => 'Переходить на летнее/зимнее время автоматически?',
    'form_pixie_date' => 'Дата и Время',
    'form_help_pixie_date' => 'Выберите привычный Вам формат даты и времени.',
    'form_pixie_rte' => 'Расширенный редактор текста',
    'form_help_pixie_rte' => ' Использовать редактор текста Ckeditor? (Это делает редактирование текстов максимально легким, но поддерживается не всеми браузерами).',
    'form_pixie_logs' => 'Информация системы',
    'form_help_pixie_logs' => 'После скольких дней очищать файлы системного журнала?',
    'form_pixie_sysmess' => 'Сообщение системы',
    'form_help_pixie_sysmess' => 'Приветственное сообщение для всех зарегистрированных пользователей Сайта.',
    'form_help_settings_page_type' => 'Какую страницу Вы желаете создать?',
    'form_legend_user_settings' => 'Пользовательские настройки',
    'form_user_username' => 'Логин',
    'form_help_user_username' => 'Логин не может содержать пробелов.',
    'form_user_realname' => 'Полное Имя',
    'form_help_user_realname' => 'введите Полное Имя пользователя.',
    'form_user_permissions' => 'Права',
    'form_help_user_permissions' => 'Какие права у данного пользователя?',
    'form_help_user_permissions_block' => 'Выбор статуса нового пользователя',
    'form_button_create_user' => 'Создать',
    'form_upload_file' => 'Файл',
    'form_help_upload_file' => 'Выберите файл с Вашего компьютера, дя загрузки..',
    'form_help_upload_tags' => 'Ключевые слова разделенные пробелом.',
    'form_upload_replace_files' => 'Заменить файлы', 
    'form_help_upload_replace_files' => 'Отметить при необходимости замены существующего файла новым.',
    'form_search_words' => 'Ключевые слова',
    'form_privs' => 'Права Страницы',
    'form_help_privs' => 'Кому позволено редактировать эту страницу?', 
    /* Email */
    'email_newpassword_subject' => 'Сайт (' . str_replace('http://', "", $site_url) . ') - Новый пароль',
    'email_changepassword_subject' => 'Сайт (' . str_replace('http://', "", $site_url) . ') - Измененный пароль',
    'email_newpassword_message' => 'Ваш пароль отправлен: ',
    'email_account_close_message' => 'Ваш Аккаунт закрыт @ ' . $site_url . '. Пожалуйста свяжитесь с администратором Сайта для получения дополнительной информации.',
    'email_account_close_subject' => 'Сайт (' . str_replace('http://', "", $site_url) . ') - Аккаунт закрыт',
    'email_account_edit_subject' =>	'Сайт (' . str_replace('http://', "", $site_url) . ') - Важная информация относительно вашего Аккаунта',
    'email_account_new_subject' => 'Сайт (' . str_replace('http://', "", $site_url) . ') - Новый Аккаунт',
    /* Front end */
    'continue_reading' => 'Продолжить чтение',
    'permalink' => 'Постоянная ссылка',
    'theme' => 'Темы',
    'navigation' => 'Навигация',
    'skip_to_content' => 'Допустить к содержанию &raquo;',
    'skip_to_nav' => 'Допустить к навигации &raquo;',
    'by' => 'Автор',
    'on' => 'на',
    'view' => 'Просмотр',
    'profile' => 'профиль',
    'all_posts_tagged' => 'все помеченные сообщения',
    'permalink_to' => 'Постоянная ссылка на',
    'comments' => 'Комментарии',
    'comment' => 'Комментарий',
    'no_comments' => 'Нет комментариев...',
    'comment_closed' => 'Новые комментари не возможны.',
    'comment_thanks' => 'Спасибо за ваш комментарий.',
    'comment_leave' => 'Оставьте комментарий',
    'comment_form_info' => 'Comment form is <a href="http://gravatar.com" title="Get a Gravatar">Gravatar</a> and <a href="http://www.cocomment.com" title="Track and share your comments">coComment</a> enabled.',
    'comment_name' => 'Имя или Логин',
    'comment_email' => 'E-mail',
    'comment_web' => 'Вебсайт',
    'comment_button_leave' => 'Отправить',
    'comment_name_error' => 'Укажите Логин или Имя.',
    'comment_email_error' => 'Заполните строку E-mail адреса.',
    'comment_web_error' => 'Укажите адрес Вашего вебсайта.',
    'comment_throttle_error' => 'Вы отправляете комментариев слишком быстро замедляться.',
    'comment_comment_error' => 'Заполните поле для комментария.',	
    'comment_save_log' => 'Прокомментировано: ',
    'tagged' => 'Тэги',
    'tag' => 'Тэг',
    'popular' => 'Самое популярное',
    'archives' => 'Архивы',
    'posts' => 'сообщение',
    'last_updated' => 'Последнее обновление',
    'edit_post' => 'Редактировать',
    'edit_page' => 'Редактировать',
    'popular_posts' => 'Популярные сообщения',
    'next_post' => 'Следующее сообщение',
    'next_page' => 'Следующая страница',
    'previous_post' => 'Предыдущее сообщение',
    'previous_page' => 'Предыдущая страница',
    'dynamic_page' => 'Страница',
	'user_name_dup' => 'Ошибка при сохранении новых ' . $table_name . ' запись. Возможное повторение имени пользователя.',
	'user_name_save_ok' => 'Сохраненные новых пользователей ' . $uname . ', Темп паролей была создана (<b>' . $password . '</b>).',
	'file_del_filemanager_fail' => 'Не удалось удалить файл. Пожалуйста, вручную удалить этот файл.',
	'upload_filemanager_fail' => 'Сбой при загрузке. Пожалуйста, убедитесь, что папка записываемые и правильный набор разрешений.',
	'filemanager_max_upload' => 'Хост-сервера будут принимать закачек для максимального размера файла : ',
	'ck_select_file' => 'Нажмите на имя файла, чтобы создать ссылку.',
	'ck_toggle_advanced' => 'Toggle advanced Mode',
    );
?>