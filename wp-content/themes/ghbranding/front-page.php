<?php get_header(); ?>
<section class="breeds home">
        <?php
        include 'components/breeds-tools.php';
        echo '<div class="breeds--lists">';
        $breeds = fetch_cat_breeds_with_wp_remote();
        if ($breeds) :
            foreach ($breeds as $breed):
                include 'components/breeds-lists.php';
            endforeach;
        else:
            echo "<p>Erro ao buscar raças de gatos.</p>";
        endif;
        echo '</div>';
        include 'components/breeds-pagination.php';
        ?>
    </div>
</section>
<?php get_footer();
