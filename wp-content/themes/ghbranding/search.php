<?php
/* Template Name: Search Results */

get_header();
include 'components/breeds-tools.php';

$search_term = get_query_var('s', '');
if (!$search_term):
    echo '<p>Por favor, insira um termo de busca.</p>';
else:
    $breeds = fetch_cat_breeds_with_wp_remote();

    if ($breeds):
        $filtered_breeds = array_filter($breeds, function ($breed) use ($search_term) {
            return stripos($breed->name, $search_term) !== false;
        });

        if (!empty($filtered_breeds)):
            echo '<section class="breeds search" id="search-breeds">';
            echo '<div class="breeds--lists">';
            foreach ($filtered_breeds as $breed):
                include 'components/breeds-lists.php';
            endforeach;
            echo '</div>';
            echo '</section>';
        else:
            echo '<p>Nenhuma raça encontrada para o termo: ' . esc_html($search_term) . '</p>';
        endif;
    else:
        echo '<p>Erro ao buscar raças.</p>';
    endif;
endif;
include 'components/breeds-pagination.php';
?>


<?php get_footer();
