<main class="container">
	<div class="row">
		<?php
				
			if (isset($page_data)) {
			
				// Then page is properly defined on the pages table in the Database
				// Get that Information and begin checking what type of data it contains
			
				if (isset($feature_data)) {
						
					// Then page is a feature page and a link has ben sent to fetch data for that particular feature from it's Table 
					// So fetch the content from that feature's table and display.
					$values = [
						'feature_data' => $feature_data,
						'template' => PATH_TO_THEME . '/web/views/default-feature-view.html',
						'back' => $page_data['link']
					];

					echo Run::render_template_with_content($values['template'], $values);
			
				} elseif (isset($features)) {
			
					if (isset($category_data)) echo '
						<div class="category-title d-block my-3 text-center"><h3>' . $category_data['title'] . '</h3></div>
					';
							
					// Then page is a feature page and no link has been sent, so fetch all of the features and preview them 
					foreach ($features as $post) {
							
						$values = [
							'feature_data' => $post,
							'back' => $page_data['link']
						];
							
						echo Run::render_template_with_content($template, $values);					
			
					}
			
					if (isset($category_data)) echo '
						<div class="d-block text-center"><a href="' . BASE_URL . '/' . CURRENT_PAGE . '">&larr; other Categories</a></div>
					';
			
				} else {
			
					// Then page is a standard page, so show it's content.
					echo Run::render_template_with_content($template, 
						array(
							'page_data' => $page_data
						)
					);
			
				}
			
			}
			
		?>


		<?php 
			// Do Pagination
			if (isset($paginate)) {

				echo '<div class="">';
					echo Run::paginate($paginate['number_of_pages'], $paginate['page'], $paginate['current_page'], (PATH_TO_THEME . '/web/views/paging.html'));
				echo '</div>';
				
			}
		?>
		
	</div>
</main>