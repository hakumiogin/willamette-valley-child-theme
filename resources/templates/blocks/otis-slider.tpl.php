<?php 

    use function Madden\Theme\Child\Setup\get_otis_posts;
    use function Madden\Theme\Child\Setup\build_otis_slider;
    $categories = get_field("category");
    $pageposts = get_otis_posts( $categories );
    if ($pageposts): ?>
    <div class="dropdowns otisDropdowns">
        <div class="dropdown">
            <a id="dropdownlink" href="#" class="dropdown__button">Filters<span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="regions-toggle" href="#">Region</a>
                <a class="date-toggle" href="#">Date</a>
                <?php if( count( $categories) > 1 ) : ?>
                    <a class="category-toggle" href="#">Category</a>
                <?php endif; ?>
            </div>
        </div>
        <?php if( count( $categories )> 1 ) : ?>
            <?php $terms = []; foreach ($categories as $categoryi) : ?>
                <?php 
                    $term = get_term_by('ID', $categoryi, 'type');
                    $termchildren = get_term_children( $categoryi, $taxonomy_name );
                    if (!array_key_exists($categoryi, $terms)){
                        if( property_exists( $term, 'term_id') && $term->term_id ){
                    //print_r($term);
                            $terms[$categoryi] = $term;
                        } 
                    }
                    foreach ($termchildren as $child){
                        if (!in_array($child, $terms)){
                            if( array_key_exists( 'term_id', $child) && $child['term_id'] ){
                                $terms[] = $child;
                            }
                        }
                    }
                ?>
            <?php endforeach;  ?>
            <div class="dropdown <?= $category ? "" : "hiddenDropdown"; ?> categoryDropdown otisDropdown">
                <a id="dropdownlink" href="#" class="dropdown__button"><?= $category ? $category : "category" ?><span class="dropdown__button__triangle"></span></a>
                <div id="dropdown__links" class="dropdown__content">
                    <?php foreach( $terms as $term ) : ?>
                        <a class="dropdown_select" data-term_id="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="dropdown <?= $regions ? "" : "hiddenDropdown"; ?> regionsDropdown otisDropdown">
            <a id="dropdownlink" href="#" class="dropdown__button"><?= $regions ? $regions : "regions" ?><span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="north-valley dropdown_select"  data-category="north-valley">North Valley</a>
                <a class="mid-valley dropdown_select" data-category="mid-valley">Mid Valley</a>
                <a class="south-valley dropdown_select" data-category="south-valley" >South Valley</a>
                <a class="west-cascades dropdown_select" data-category="west-cascades" >West Cascades</a>
            </div>
        </div>
        <div class="dropdown <?= $show_date ? "" : "hiddenDropdown"; ?> dateDropdown otisDropdown">
            <a id="dropdownlink" href="#" class="dropdown__button"><?= isset($_GET["date"]) ? ($date == "ASC" ? "oldest" : "newest") : "date" ?><span class="dropdown__button__triangle"></span></a>
            <div id="dropdown__links" class="dropdown__content">
                <a class="dropdown__links__oldest dropdown_select" >Newest</a>
                <a class="dropdown__links__newest dropdown_select">Oldest</a>
            </div>
        </div>
        <div class="dropdown">
            <a id="otisSubmit" href="#" class="dropdown__button">Submit</a>
        </div>
    </div> 
    <div class="category-slider-parent otis-slider" data-categories="<?php echo json_encode($categories); ?>">
    </div>
    <div class="category-slider-parent  ">

<?php
//print_r($pageposts);
        echo build_otis_slider( $pageposts );
    endif;
    ?>
</div>
    