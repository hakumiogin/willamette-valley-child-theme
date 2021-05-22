<body id="willamette-body" <?php body_class(); ?>>
<main>
    <?php do_action('theme/after-body') // use this action to hook into theme after-body ?>
	<nav class="nav-bar">
		<div class="nav-bar__inner">
			<div class="nav-bar__logo" data-aos="fade-down">
				<a href="<?= home_url() ?>">
					<img src="<?= $logo_src ?>" srcset="<?= $logo_src_2x ?> 2x" />
				</a>
			</div>
			<div class="nav-bar__right">
				<div class="nav-bar__guide">
					<a class="nav-bar__btn btn btn--purple" href="guide">Request a Visitor's Guide</a>
					<a class="nav-bar__guide--news" href="news">News</a>
					<div class="nav-bar__guide--search">
						<?php get_search_form(); ?>
						<a href="" id="searchToggle"><img class="" src="<?= $mag_icon ?>"></a>
					</div>
				</div>
				<div class="nav-bar__search">
				</div>
				<?php wp_nav_menu( array( 
					'theme_location' => 'header-menu',
					'container_class' => 'nav-menu',
				) ); ?>
			</div>
		</div>
	</nav>

	<!--    Made by Erik Terwan    -->
<!--   24th of November 2015   -->
<!--        MIT License        -->
<nav role="navigation">
  <div id="menuToggle">
    <!--
    A fake / hidden checkbox is used as click reciever,
    so you can use the :checked selector on it.
    -->
    <input type="checkbox" />
    
    <!--
    Some spans to act as a hamburger.
    
    They are acting like a real hamburger,
    not that McDonalds stuff.
    -->
    <span></span>
    <span></span>
    <span></span>
    
    <!--
    Too bad the menu has to be inside of the button
    but hey, it's pure CSS magic.
    -->
    <nav id="menu">
		<a href="<?= home_url() ?>">
			<img class="mobile-nav__logo" src="<?= $logo_src ?>" srcset="<?= $logo_src_2x ?>">
		</a>
		<?php wp_nav_menu( array( 
			'theme_location' => 'header-menu',
			'container_class' => 'mobile-menu',
			'link_after' => '<div class="toggle-icon toggle-icon__plus"></div>'
		) ); ?>
    </nav>
  </div>
</nav>

<div class="hero">
	<img src="<?= $hero_img ?>">
</div>