<?php 

    use function Madden\Theme\Child\Setup\get_otis_posts;
    use function Madden\Theme\Child\Setup\build_otis_slider;
    $pageposts = get_otis_posts();
    if ($pageposts): ?>
    <div class="dropdowns">
        <div class="dropdown">
            <a id="dropdownlink" href="#" class="dropdown__button">Filters<span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="regions-toggle" href="#">Region</a>
                <a class="date-toggle" href="#">Date</a>
            </div>
        </div>
        <div class="dropdown <?= $regions ? "" : "hiddenDropdown"; ?> regionsDropdown">
            <a id="dropdownlink" href="#" class="dropdown__button"><?= $regions ? $regions : "regions" ?><span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="north-valley" href="articles/?category=north-valley<?= $date ? "&date=".$date : "" ?>">North Valley</a>
                <a class="mid-valley" href="articles/?category=mid-valley<?= $date ? "&date=".$date : "" ?>">Mid Valley</a>
                <a class="south-valley" href="articles/?category=south-valley<?= $date ? "&date=".$date : "" ?>">South Valley</a>
                <a class="west-cascades" href="articles/?category=west-cascades<?= $date ? "&date=".$date : "" ?>">West Cascades</a>
            </div>
        </div>
        <div class="dropdown <?= $show_date ? "" : "hiddenDropdown"; ?> dateDropdown">
            <a id="dropdownlink" href="#" class="dropdown__button"><?= isset($_GET["date"]) ? ($date == "ASC" ? "oldest" : "newest") : "date" ?><span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="dropdown__links__oldest" href="articles/?date=DESC<?= $category ? "&category=".$category : "" ?>">Newest</a>
                <a class="dropdown__links__newest" href="articles/?date=ASC<?= $category ? "&category=".$category : "" ?>">Oldest</a>
            </div>
        </div>
    </div> 
    <div class="category-slider-parent  ">

<?php
//print_r($pageposts);
        echo build_otis_slider( $pageposts );
    endif;
    ?>
</div>
    