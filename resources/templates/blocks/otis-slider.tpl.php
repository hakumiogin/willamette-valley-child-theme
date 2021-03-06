<?php 

    use function Madden\Theme\Child\Setup\get_otis_posts;
    use function Madden\Theme\Child\Setup\build_otis_slider;
    $categories = get_field("category");
    $pageposts = get_otis_posts( $categories );
    if ($pageposts): ?>
    <div class="otis-block">
        <div class="dropdowns otisDropdowns">
            <div class="dropdown">
                <a id="dropdownlink" href class="dropdown__button dropdown__button__triangle">Filters</a>
                <div id="dropdown__links" class="dropdown__content">
                    <?php if( count( $categories) > 1 ) : ?>
                        <a class="category-toggle" >Category</a>
                    <?php endif; ?>
                    <a class="regions-toggle" >Region</a>
                    <a class="date-toggle" >Date</a>
                </div>
            </div>
            <?php if( count( $categories )> 1 ) : ?>
                <?php $terms = []; $has_events = 0; foreach ($categories as $categoryi) : ?>
                    <?php 
                        $term = get_term_by('ID', $categoryi, 'type');
                        // check if is event
                        $termchildren = get_term_children( $categoryi, 'type' );
                        if( count($termchildren) > 0){
                            foreach ($termchildren as $child_id){
                                if (!in_array($child_id, $terms)){
                                    $child = get_term_by('ID', $child_id, 'type');
                                  if( property_exists(  $child, 'term_id') && $child->term_id ){
                                        $terms[$child->term_id] = $child;
                                    }
                                }
                            }
                        }
                        else{
                            // dont show category as filter option if it is a parent? 
                            if (!array_key_exists($categoryi, $terms)){
                                if( property_exists( $term, 'term_id') && $term->term_id ){
                                    $terms[$categoryi] = $term;
                                } 
                            }
                        }

                    ?>
                <?php endforeach;  ?>
                <div class="dropdown <?= $category ? "" : "hiddenDropdown"; ?> categoryDropdown otisDropdown">
                    <a id="dropdownlink" href class="dropdown__button dropdown__button__triangle"><?= $category ? $category : "category" ?></a>
                    <div id="dropdown__links" class="dropdown__content">
                        <a class="dropdown_select" data-term_id="all">All</a>
                        <?php foreach( $terms as $term ) : ?>
                            <a class="dropdown_select" data-term_id="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="dropdown <?= $regions ? "" : "hiddenDropdown"; ?> regionsDropdown otisDropdown">
                <a id="dropdownlink" href class="dropdown__button dropdown__button__triangle"><?= $regions ? $regions : "regions" ?></a>
                <div id="dropdown__links" class="dropdown__content">
                    <a class="dropdown_select"  data-region="all">All</a>
                    <a class="north-valley dropdown_select"  data-region="north-valley">North Valley</a>
                    <a class="mid-valley dropdown_select" data-region="mid-valley">Mid Valley</a>
                    <a class="south-valley dropdown_select" data-region="south-valley" >South Valley</a>
                    <a class="west-cascades dropdown_select" data-region="west-cascades" >West Cascades</a>
                </div>
            </div>
            <div class="dropdown <?= $show_date ? "" : "hiddenDropdown"; ?> dateDropdown otisDropdown">
                <a id="dropdownlink" href class="dropdown__button dropdown__button__triangle"><?= isset($_GET["date"]) ? ($date == "ASC" ? "oldest" : "newest") : "date" ?></a>
                <div id="dropdown__links" class="dropdown__content">
                    <a class="dropdown__links__oldest dropdown_select date-select" >Newest</a>
                    <a class="dropdown__links__newest dropdown_select date-select">Oldest</a>
                </div>
            </div>
        </div> 
        <div class="category-slider-parent otis-slider loading" data-categories="<?php echo json_encode($categories); ?>">
        </div>
    </div>
<?php endif; ?>
