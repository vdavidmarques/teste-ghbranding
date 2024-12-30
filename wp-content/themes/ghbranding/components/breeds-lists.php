
    <article class="breeds--lists--list">
        <div class="breeds--lists--list--image">
            <p class="rare">Rare <span><?php echo esc_attr($breed->rare); ?></span></p>
            <?php if (isset($breed->image->url)): ?>
                <img src="<?php echo esc_url($breed->image->url); ?>" alt="<?php echo esc_attr($breed->name); ?>">
            <?php else: ?>
                <img src="<?php echo get_template_directory_uri() . '/dist/images/default.jpg' ?>" alt="<?php echo esc_attr($breed->name); ?>">
            <?php endif; ?>
        </div>
        <div class="breeds--lists--list--content">
            <div class="breeds--lists--list--content--header">
                <h2 class="title"> <?php echo esc_html($breed->name); ?></h2>
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
            <ul class="breeds--lists--list--content--features">
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

                foreach ($features as $feature_key => $feature_title):
                    if (isset($breed->$feature_key)):
                ?>
                        <li class="feature"">
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
            <button class="button default">More Info</button>
        </div>
    </article>
