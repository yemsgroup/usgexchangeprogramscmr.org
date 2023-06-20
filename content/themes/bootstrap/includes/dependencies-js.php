<!-- 
    Content added here will be added to the end of the file (just before the closing </html> tag) tag Dependency Additions to the <foot> tag 
    These can include dependencies, etc... Basically anything code that needs to be added at the bottom of site.
-->

<?php if(defined('DEVELOPMENT')): ?>

	<!-- Call up JavaScripts -->
		<!-- Jquery	-->
		<script src="<?=LOCALHOST; ?>9-libraries-and-frameworks/jquery/jquery-3.6.1.min.js"></script>
		
		<!--Bootstrap local -->
		<script src="<?=LOCALHOST; ?>9-libraries-and-frameworks/bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>

		<!-- Font Awesome link -->
		<script defer src="<?=LOCALHOST; ?>9-libraries-and-frameworks/fontawesome/fontawesome-free-5.11.2-web/js/all.js"></script>

<?php else: ?>

	<!-- Call up JavaScripts -->
		<!-- Jquery	-->
		<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

		<!-- Bootstrap CDN -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

		<!-- Font Awesome link -->
		<script src="https://kit.fontawesome.com/d6da8be169.js" crossorigin="anonymous"></script>
		
		<!-- recaptcha link -->
		<script src='https://www.google.com/recaptcha/api.js'></script>

<?php endif; ?>

<?php if(file_exists(PATH_TO_THEME . 'assets/js/main.js')): ?>
    
    <!-- Local JS -->
    <script src="<?=BASE_URL . REL_PATH_TO_THEME; ?>assets/js/main.js"></script>
    
<?php endif; ?>