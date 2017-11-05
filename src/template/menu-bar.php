<section class="mbr-navbar mbr-navbar--freeze mbr-navbar--absolute mbr-navbar--transparent mbr-navbar--sticky mbr-navbar--auto-collapse" id="menu-74">
	<div class="mbr-navbar__section mbr-section">
		<div class="mbr-section__container container">
			<div class="mbr-navbar__container">
				<div class="mbr-navbar__column mbr-navbar__column--s mbr-navbar__brand">
					<span class="mbr-navbar__brand-link mbr-brand mbr-brand--inline">
						<span class="mbr-brand__logo">
							<img class="mbr-navbar__brand-img mbr-brand__img" src="<?php echo PUBLIC_PATH.'images/discover-mobile-350x350-53.png'?>" alt="Mobirise"></a>
						</span>
						<span class="mbr-brand__name"><a class="mbr-brand__name text-white">BLOG TEMPLATE</a></span>
					</span>
				</div>
				<div class="mbr-navbar__hamburger mbr-hamburger text-white">
					<span class="mbr-hamburger__line"></span>
				</div>
				<div class="mbr-navbar__column mbr-navbar__menu">
					<nav class="mbr-navbar__menu-box mbr-navbar__menu-box--inline-right">
						<div class="mbr-navbar__column">
							<ul class="mbr-navbar__items mbr-navbar__items--right mbr-buttons mbr-buttons--freeze mbr-buttons--right btn-decorator mbr-buttons--active">
								<li class="mbr-navbar__item"><a class="mbr-buttons__link btn text-white" href="<?php echo LINK_BASE_PATH; ?>">HOME</a>
								</li>
								<?php 
								// if user login then display add-post or logout menu
								if (isset($_SESSION['user']['user_email'])) {
									$user_role = $_SESSION['user']['user_role'];
									// if login user is admin then he can add posts in blog
									if($user_role == 'admin'){
										echo "<li class='mbr-navbar__item'><a class= 'mbr-buttons__link btn text-white' href=".SRC_PATH.'template/add-edit_post.php'.">ADD POST</a></li>";
										echo "<li class='mbr-navbar__item'><a class= 'mbr-buttons__link btn text-white' href=".SRC_PATH.'template/logout.php'.">LOGOUT</a></li>";
									}
									// if not the he can view and logout
									else{
										echo "<li class='mbr-navbar__item'><a class= 'mbr-buttons__link btn text-white' href=".SRC_PATH.'template/logout.php'.">LOGOUT</a></li>";
									}
								}
								
								// if user not login then display login or signup menu
								else {
									echo "<li class='mbr-navbar__item'><a class= 'mbr-buttons__link btn text-white' href=".SRC_PATH.'template/login-form.php'.">LOGIN</a></li>";
									echo "<li class='mbr-navbar__item'><a class= 'mbr-buttons__link btn text-white' href=".SRC_PATH.'template/signup-form.php'.">SIGN UP</a></li>";
								}
								?>
								<li class="mbr-navbar__item"><a class="mbr-buttons__link btn text-white" href="<?php echo SRC_PATH; ?>template/contact-us.php">CONTACT US</a></li>
							</ul>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>