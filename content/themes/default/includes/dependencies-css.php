<!-- 
        Content added here will be added to the <head> tag Dependency Additions to the <head> tag 
        These can include dependencies, <link> <style> etc... Basically anything code that needs to be added inside the <head> tag.
    -->

<?php if(file_exists(PATH_TO_THEME . 'assets/css/main.css')): ?>
    
    <!-- Local Stylesheets -->
    <link rel="stylesheet" href="<?=BASE_URL . REL_PATH_TO_THEME; ?>assets/css/main.css" type="text/css" />
    
<?php endif; ?>