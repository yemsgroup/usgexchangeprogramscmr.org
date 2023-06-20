<main class="container my-4">
	<div class="row justify-content-center">
		<?php

			if (isset($title)) 
				echo '<div class="col-10 title text-center text-uppercase">
					<h1 class="h6">' . $title . '</h1>
				</div><div class="w-100"></div>';
			
			if (isset($description)) 
				echo '<div class="col-10 description text-center small">
					<p class="">' . $description . '</p>
				</div><div class="w-100"></div>';
			
			if (isset($content)) 
				echo '<div class="col-10 content text-center">
					<p class="">' . $content . '</p>
				</div><div class="w-100"></div>';
			

			if (isset($login)) 
				echo '<div class="col-10 text-center">' . 
					Run::render_template_with_content(
						PATH_TO_SYM_THEME . '/web/views/' . $template,
						[
							// 'feature_data' => $feature,
							// 'page' => $page
						]
					) .
				'</div>';

				
			if (isset($categories)) {
				
				echo '<div class="col-12 mb-3 text-center">';

					$template = isset($template_file) ? $template_file : 'default-feature-category-preview.html';
					
					foreach($categories as $category) 
						echo \Run::render_template_with_content(
							PATH_TO_SYM_THEME . '/web/views/' . $template,
							[
								'feature_data' => $category,
								'page' => $page
							]
						);

					echo '<a href="' . $page . '/c/NULL" class="badge bg-secondary ms-1">uncategorized</a> <a href="' . $page . '" class="badge bg-secondary ms-1">all</a>';

				echo '</div>';

			}

		
			if (isset($features)) {

				$template = isset($template_file) ? $template_file : 'default-feature-preview.html';
				foreach($features as $feature)
					echo \Run::render_template_with_content(
						PATH_TO_SYM_THEME . '/web/views/' . $template,
						[
							'feature_data' => $feature,
							'categories' => (isset($categories) ? $categories : null),
							'page' => $page
						]
					);
		
			} elseif (isset($add)) {

				$template = isset($template_file) ? $template_file : 'default-feature-add.html';
				
				echo \Run::render_template_with_content(
					PATH_TO_SYM_THEME . '/web/views/' . $template,
					[
						// 'feature_data' => $feature,
						'page' => $page
					]
				);
		
			}
		
		?>
	</div>
</main>