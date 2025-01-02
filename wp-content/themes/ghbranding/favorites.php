<?php

/**
 * Template Name: Lista de Favoritos
 */

get_header();

function get_image_url($reference_image_id)
{
    $api_url = 'https://api.thecatapi.com/v1/images/' . $reference_image_id;
    $api_response = file_get_contents($api_url);
    $image_data = json_decode($api_response);

    return isset($image_data->url) ? $image_data->url : '';
}

$favorites = isset($_COOKIE['favorites']) ? explode(',', $_COOKIE['favorites']) : [];

$api_url = 'https://api.thecatapi.com/v1/breeds';
$api_response = file_get_contents($api_url);
$breeds = json_decode($api_response);

$favorites_data = array_filter($breeds, function ($breed) use ($favorites) {
    return in_array(strtolower($breed->id), array_map('strtolower', $favorites));
});
?>

<div id="favorites-container" class="breeds">
    <?php if (empty($favorites_data)) : ?>
        <p>No favorites yet.</p>
    <?php else : ?>
        <div class="breeds--lists">
            <?php
            foreach ($favorites_data as $breed) :
                include 'components/favorites-breeds-lists.php';
            endforeach;
            ?>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>