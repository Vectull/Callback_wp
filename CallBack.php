<?php
/**
 * Plugin Name: Wp contcat form
 * Description: contact form for wordpress simple 
 * Plugin URI:  https://github.com/Vectull/Callback_wp
 * Author URI:  https://github.com/Vectull
 * Author:      Vectull
 * Version:     1.0
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

 function contact_form_settings_page() {
    add_options_page(
        'Настройки формы контакта',
        'Форма контакта',
        'manage_options',
        'contact-form-settings',
        'contact_form_settings'
    );
}
add_action('admin_menu', 'contact_form_settings_page');
// Создаем функцию настроек плагина
function contact_form_settings() {
    ?>
    <div class="wrap">
        <h1>Настройки формы контакта</h1>
        <form method="post" action="options.php">
            <?php settings_fields('contact-form-settings-group'); ?>
            <?php do_settings_sections('contact-form-settings'); ?>
            <?php submit_button('Сохранить настройки'); ?>
        </form>
    </div>
    <?php
}

// Создаем поля настроек
function contact_form_settings_fields() {
    add_settings_section(
        'contact-form-settings-section',
        'Основные настройки',
        'contact_form_settings_section',
        'contact-form-settings'
    );
    add_settings_field(
        'contact-form-email',
        'Email для отправки сообщений',
        'contact_form_email_field',
        'contact-form-settings',
        'contact-form-settings-section'
    );
    add_settings_field(
        'contact-form-required-fields',
        'Обязательные поля формы',
        'contact_form_required_fields_field',
        'contact-form-settings',
        'contact-form-settings-section'
    );
    register_setting(
        'contact-form-settings-group',
        'contact-form-email'
    );
    register_setting(
        'contact-form-settings-group',
        'contact-form-required-fields'
    );
}

add_action('admin_init', 'contact_form_settings_fields');
// Функция для вывода описания секции настроек
function contact_form_settings_section() {
    echo '<p>Настройте основные параметры формы контакта.</p>';
}
// Функция для вывода поля настройки email
function contact_form_email_field() {
    $email = get_option('contact-form-email');
    echo '<input type="email" name="contact-form-email" value="' . esc_attr($email) . '" />';
}
// Функция для вывода поля настройки обязательных полей формы
function contact_form_required_fields_field() {
    $required_fields = get_option('contact-form-required-fields');
    ?>
    <label>
        <input type="checkbox" name="contact-form-required-fields[]" value="name" <?php if (in_array('name', $required_fields)) echo 'checked'; ?> />
        Имя
    </label>
    <br />
    <label>
        <input type="checkbox" name="contact-form-required-fields[]" value="email" <?php if (in_array('email', $required_fields)) echo 'checked'; ?> />
        Email
    </label>
    <br />
    <label>
        <input type="checkbox" name="contact-form-required-fields[]" value="message" <?php if (in_array('message', $required_fields)) echo 'checked'; ?> />
        Сообщение
    </label>
    <?php
}