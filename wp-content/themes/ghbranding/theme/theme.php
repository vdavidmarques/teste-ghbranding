<?php

/*******************************
    Adding scripts and Css
 ********************************/
function enqueue_custom_scripts() {
    wp_enqueue_style('styles', get_template_directory_uri() . '/dist/css/styles.css', array(), '1.0.0');
    wp_enqueue_script('scripts', get_template_directory_uri() . '/dist/js/scripts.js', ['jquery'], '1.0.0', true);

    wp_localize_script('scripts', 'my_ajax_object', [
        'ajaxurl' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

/*******************************
        Adding logo
 ********************************/

function theme_custom_logo_setup()
{
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'theme_custom_logo_setup');

/*******************************
    Adding Thumbnail
 ********************************/

function my_theme_setup()
{
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'my_theme_setup');

/*******************************
    Get ID by Slug
 ********************************/

function get_page_id_by_slug($slug)
{
    $page = get_page_by_path($slug, OBJECT, 'page');
    if ($page) {
        return $page->ID;
    }
    return 0;
}

/*******************************
    Assync font load - Google Fonts
    Change font's name if needed
 ********************************/
function carregar_fontes_assincronas()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap', array(), '1.0');
}

add_action('wp_enqueue_scripts', 'carregar_fontes_assincronas');

/*******************************
   Connecting with cats Api
 ********************************/

function fetch_cat_breeds_with_wp_remote()
{
    $api_url = "https://api.thecatapi.com/v1/breeds";
    $api_key = "your_api_key_here";

    $response = wp_remote_get($api_url, [
        'headers' => [
            'x-api-key' => $api_key,
        ],
    ]);

    if (is_wp_error($response)) {
        echo "Erro: " . $response->get_error_message();
        return [];
    }

    $body = wp_remote_retrieve_body($response);
    return json_decode($body);
}

function ajax_fetch_cat_breeds()
{
    if (!isset($_GET['search_term']) || empty($_GET['search_term'])) {
        wp_send_json_error('Nenhum termo de busca fornecido ou erro ao buscar raças.');
    }

    $search_term = sanitize_text_field($_GET['search_term']);
    $breeds = fetch_cat_breeds_with_wp_remote();

    if (!$breeds) {
        wp_send_json_error('Erro ao buscar dados da API.');
    }

    $filtered_breeds = array_filter($breeds, function($breed) use ($search_term) {
        return stripos($breed->name, $search_term) !== false;
    });

    if (empty($filtered_breeds)) {
        wp_send_json_error('Nenhuma raça encontrada para o termo fornecido.');
    }

    wp_send_json_success(array_values($filtered_breeds));
}
add_action('wp_ajax_fetch_cat_breeds', 'ajax_fetch_cat_breeds');
add_action('wp_ajax_nopriv_fetch_cat_breeds', 'ajax_fetch_cat_breeds');

/*******************************
   Search Function - Cats
 ********************************/
function search_breeds() {
    $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $breeds = fetch_cat_breeds_with_wp_remote();

    if (!$breeds || empty($search_query)) {
        wp_send_json_error('Nenhum termo de busca fornecido ou erro ao buscar raças.');
        return;
    }

    $filtered_breeds = array_filter($breeds, function($breed) use ($search_query) {
        return stripos($breed->name, $search_query) !== false;
    });

    if (!empty($filtered_breeds)) {
        ob_start();
        foreach ($filtered_breeds as $breed) {
            echo "<p>" . esc_html($breed->name) . " - " . esc_html($breed->origin) . "</p>";
        }
        wp_send_json_success(ob_get_clean());
    } else {
        wp_send_json_error('Nenhuma raça encontrada para o termo "' . esc_html($search_query) . '".');
    }
}
add_action('wp_ajax_search_breeds', 'search_breeds');
add_action('wp_ajax_nopriv_search_breeds', 'search_breeds');

