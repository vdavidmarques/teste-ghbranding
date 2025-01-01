<div class="breeds--tools">
    <div class="breeds--tools--search">
        <form id="search-breeds" action="" method="GET">
            <label class="search-input-wrapper">
                <button type="submit" class="search-icon"></button>
                <input type="text" name="s" placeholder="Search..." required>
            </label>
        </form>
    </div>
    <div class="breeds--tools--favorite">
        <a href="<?php echo home_url() . '/my-favorites'?>" class="button default like favorite-button">
            My favorites
        </a>
    </div>
</div>