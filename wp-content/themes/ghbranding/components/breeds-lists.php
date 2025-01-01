<article class="breeds--lists--list breed-item" data-index="<?php echo $i; ?>">
    <div class="breeds--lists--list--image">
        <p class="rare">Rare <span><?php echo esc_attr($breed->rare); ?></span></p>
        <?php
            $image_src = get_template_directory_uri() . '/dist/images/default.jpg';

            if (isset($breed->image) && isset($breed->image->url) && !empty($breed->image->url)) {
                $image_src = $breed->image->url;
            } elseif (isset($breed->reference_image_id) && !empty(get_image_url($breed->reference_image_id))) {
                $image_src = get_image_url($breed->reference_image_id);
            } else {
                error_log("Missing image for breed ID: " . $breed->id);
            }
        ?>

        <img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($breed->name); ?>">    
    </div>
    <div class="breeds--lists--list--content">
        <div class="breeds--lists--list--content--header">
            <div class="name-favorite">
                <h2 class="title"> <?php echo esc_html($breed->name); ?></h2>
                <button 
                    type="submit" 
                    class="button like favorite-button"
                    data-breed-id="<?php echo esc_js($breed->id); ?>" 
                    onclick="toggleFavorite('<?php echo esc_js($breed->id); ?>', this)"
                >
                </button>
            </div>
            <?php if ($breed->alt_names): ?>
                <p class="alt"> <?php echo esc_html($breed->alt_names); ?></p>
            <?php else: ?>
                <p class="alt">No alt names</p>
            <?php endif; ?>
            <h3 class="subtitle"> <?php echo esc_html($breed->temperament); ?></h3>
        </div>
        <div class="breeds--lists--list--content--origin">
            <h4 class="text"> <?php echo esc_html($breed->origin); ?></h4>
        </div>
        <ul class="breeds--lists--list--content--features" id="features-<?php echo esc_attr($breed->id); ?>">
            <?php
            $features = [
                'life_span' => 'Life Span',
                'indoor' => 'Indoor',
                'lap' => 'Lap',
                'adaptability' => 'Adaptability',
                'affection_level' => 'Affection Level',
                'child_friendly' => 'Child Friendly',
                'dog_friendly' => 'Dog Friendly',
                'energy_level' => 'Energy Level',
                'grooming' => 'Grooming',
                'health_issues' => 'Health Issues',
                'intelligence' => 'Intelligence',
                'shedding_level' => 'Shedding Level',
                'social_needs' => 'Social Needs',
                'stranger_friendly' => 'Stranger Friendly',
                'vocalisation' => 'Vocalisation',
                'experimental' => 'Experimental',
                'hairless' => 'Hairless',
                'natural' => 'Natural',
                'rex' => 'Rex',
                'suppressed_tail' => 'Suppressed Tail',
                'short_legs' => 'Short Legs',
                'hypoallergenic' => 'Hypoallergenic',
            ];
            $i = 0;
            foreach ($features as $feature_key => $feature_title):
                if (isset($breed->$feature_key)):
                    $i++;
            ?>
                <li class="feature" <?php if($i > 6) echo 'style="display: none;"';?>>
                    <?php echo esc_html($feature_title); ?>
                    <span class=" tag"> <?php echo esc_html($breed->$feature_key); ?></span>
                </li>
            <?php
                endif;
            endforeach;
            ?>
        </ul>
        <div class="breeds--lists--list--content--desc">
            <p><?php echo esc_html($breed->description); ?></p>
        </div>
        <button class="button default more-info-button" data-breed-id="<?php echo esc_js($breed->id); ?>">More Info</button>
    </div>
</article>
