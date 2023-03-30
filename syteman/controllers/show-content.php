<?php

// var_dump($route_info);

// Initialize the PageBuilder Object 
$page_builder = new PageBuilder;


$page_data = $route_info['page_data'];


// Create the page's Header
$page_builder->do_header($page_data);


// Check for and run the appropriate method as determined by routing
if(method_exists($page_builder, $route_info['process'])) {
	
	if($route_info['process'] != 'show_page_not_found') 
		call_user_func(array($page_builder, $route_info['process']), $page_data);
	else 
		call_user_func($page_builder, $route_info['process']);
	
} else {

	$page_builder->show_page_with_standard_content(null, null);

}


// Create the page's Footer
$page_builder->do_footer();