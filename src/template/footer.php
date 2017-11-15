<section class="mbr-section mbr-section--relative mbr-section--fixed-size" id="contacts2-57" style="background-color: #333 ;">
	<div class="mbr-section__container container">
		<div class="mbr-contacts mbr-contacts--wysiwyg row">
			<div class="footer-container col-sm-9 col-sm-offset-2">
				<div class="row">
					<div class="footer-section col-lg-4">
						<h3 class="footer-heading mbr-contacts__text"><strong>LATEST POSTS</strong></h3><br>
						<?php $query->latestPost(); ?>
					</div>
					<div class="footer-section col-lg-4">
						<h3 class="footer-heading mbr-contacts__text"><strong>CATAGORIES</strong></h3><br>
						<?php $query->category(); ?>
					</div>
					<div class="footer-section col-lg-3">
						<h3 class="footer-heading mbr-contacts__text"><strong>ABOUT</strong></h3><br>
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="<?php echo PUBLIC_PATH.'js/custom-js-function.js';?>"></script>
<footer class="mbr-section mbr-section--relative mbr-section--fixed-size" id="footer1-91" style="background-color: rgb(68, 68, 68);">
	<div class="mbr-section__container container">
		<div class="mbr-footer mbr-footer--wysiwyg row">
			<div class="col-sm-8 col-sm-offset-2">
				<p class="mbr-footer__copyright"></p><p>COPYRIGHT (C) <?php echo date("Y"); ?> COPYRIGHT HOLDER ALL RIGHTS RESERVED. | TERMS AND POLICIES |<a href="" class="text-gray"> DISCLAIMER</a></p><p></p>
			</div>
		</div>
	</div>
</footer>