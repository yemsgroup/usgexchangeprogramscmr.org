<!-- 
    Content added here will be added to the end of the file (just before the closing </html> tag) tag Dependency Additions to the <foot> tag 
    These can include dependencies, etc... Basically anything code that needs to be added at the bottom of site.
-->

<?php if(file_exists(PATH_TO_THEME . 'assets/js/main.js')): ?>
    
    <!-- Local JS -->
    <script src="<?=BASE_URL . REL_PATH_TO_THEME; ?>assets/js/main.js"></script>
    
<?php endif; ?>