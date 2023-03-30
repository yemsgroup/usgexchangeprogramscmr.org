<!-- 
        Content added here will be added to the <head> tag Dependency Additions to the <head> tag 
        These can include dependencies, <link> <style> etc... Basically anything code that needs to be added inside the <head> tag.
    -->

<?php if(defined('DEVELOPMENT')): ?>

	<!-- Styling and Scripting -->
	<!--Bootstrap local -->
	<link rel="stylesheet" href="<?=LOCALHOST; ?>9-libraries-and-frameworks/bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css">

<?php else: ?>

	<!-- Styling and Scripting -->
	<!-- Bootstrap CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<?php endif; ?>


<?php if(file_exists(PATH_TO_THEME . 'assets/css/main.css')): ?>
    
    <!-- Local Stylesheets -->
    <link rel="stylesheet" href="<?=BASE_URL . REL_PATH_TO_THEME; ?>assets/css/main.css" type="text/css" />
    
<?php endif; ?>