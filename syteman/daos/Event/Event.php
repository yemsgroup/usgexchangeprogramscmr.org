<?php

class Event extends Feature
{

    public function __construct()
    {

        parent::__construct();

        $this->feature = 'event';
        $this->feature_category = 'event_category';

        // For front end... the page on which the features will be displayed
        $this->feature_page = 'activities';
        $this->template_preview = 'event-preview.html';

        $this->feature_category_table = 'event_categories';
        $this->feature_category_content_table = 'event_category_content';
        $this->feature_table = 'events';
        $this->feature_content_table = 'event_content';

        // Feature Category Columns to be included in RD Statements
        $this->select_category_columns = $this->feature_category_table . '.id AS id,'
            . $this->feature_category_table . '.is_active AS is_active,'
            . $this->feature_category_table . '.link AS link,'
            . $this->feature_category_table . '.image AS image,'
            . $this->feature_category_content_table . '.lang_id AS lang_id,'
            . $this->feature_category_content_table . '.title AS title,'
            . $this->feature_category_content_table . '.description AS description,'
            . $this->feature_category_content_table . '.image_caption AS image_caption'
        ;

        // Feature Category Columns to be included in CU statements
        $this->feature_category_table_columns = [
            $this->feature_category_table . '.is_active' => 'is_active',
            $this->feature_category_table . '.link' => 'link',
            $this->feature_category_table . '.image' => 'image'
        ];

        $this->feature_category_content_table_columns = [
            $this->feature_category_content_table . '.lang_id' => 'lang-id',
            $this->feature_category_content_table . '.title' => 'title',
            $this->feature_category_content_table . '.description' => 'description',
            $this->feature_category_content_table . '.image_caption' => 'image_caption'
        ];

        // Feature Columns for RD
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.category_id AS category_id,'
            . $this->feature_table . '.is_active AS is_active,'
            . $this->feature_table . '.from_date AS from_date,'
            . $this->feature_table . '.to_date AS to_date,'
            . $this->feature_table . '.link AS link,'
            . $this->feature_table . '.venue AS venue,'
            . $this->feature_table . '.image AS image,'
            . $this->feature_content_table . '.event_id AS event_id,'
            . $this->feature_content_table . '.lang_id AS lang_id,'
            . $this->feature_content_table . '.last_update AS last_update,'
            . $this->feature_content_table . '.title AS title,'
            . $this->feature_content_table . '.description AS description,'
            . $this->feature_content_table . '.content AS content,'
            . $this->feature_content_table . '.image_caption AS image_caption'
        ;

        // Define Feature columns for CU
        $this->feature_table_columns = [
            $this->feature_table . '.category_id' => 'category_id',
            $this->feature_table . '.is_active' => 'is_active',
            $this->feature_table . '.from_date' => 'from_date',
            $this->feature_table . '.to_date' => 'to_date',
            $this->feature_table . '.link' => 'link',
            $this->feature_table . '.venue' => 'venue',
            $this->feature_table . '.image' => 'image'
        ];

        $this->feature_content_table_columns = [
            $this->feature_content_table . '.last_update' => 'last_update',
            $this->feature_content_table . '.title' => 'title',
            $this->feature_content_table . '.description' => 'description',
            $this->feature_content_table . '.content' => 'content',
            $this->feature_content_table . '.image_caption' => 'image_caption'
        ];
        
    }

}