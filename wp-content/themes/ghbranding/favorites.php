<?php
/**
 * Template Name: Lista de Favoritos
 */

get_header();

function get_image_url($reference_image_id) {
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
    return in_array($breed->id, $favorites);
});
?>

<div id="favorites-container" class="breeds">
    <?php if (empty($favorites_data)) : ?>
        <p>No favorites yet.</p>
    <?php else : ?>
        <div class="breeds--lists">
            <?php foreach ($favorites_data as $breed) : ?>
               <?php include 'components/breeds-lists.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return '';
    }

    function setCookie(name, value, days = 7) {
        const expires = new Date(Date.now() + days * 864e5).toUTCString();
        document.cookie = `${name}=${value}; expires=${expires}; path=/`;
    }

    function toggleFavorite(id) {
        let favorites = getCookie('favorites') ? getCookie('favorites').split(',') : [];
        
        if (favorites.includes(id)) {
            favorites = favorites.filter(fav => fav !== id); 
        } else {
            favorites.push(id); 
        }

        setCookie('favorites', favorites.join(','), 7);
        
        alert('Favorites updated!');
        location.reload(); 
    }
</script>

<?php get_footer(); ?>