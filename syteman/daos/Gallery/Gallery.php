<?php

class Gallery extends Feature
{

    public function __construct()
    {

        parent::__construct();

        $this->feature = 'gallery';
        $this->feature_category = 'gallery_album';

        $this->feature_category_table = 'gallery_albums';
        $this->feature_category_content_table = 'gallery_album_content';
        $this->feature_table = 'gallery';
        $this->feature_content_table = 'gallery_content';

        $this->join_column_category = 'album_id';

        // Feature Category Columns to be included in RD Statements
        $this->select_category_columns = $this->feature_category_table . '.id AS id,'
            . $this->feature_category_table . '.type,'
            . $this->feature_category_table . '.is_active,'
            . $this->feature_category_table . '.link,'
            . $this->feature_category_table . '.image,'
            . $this->feature_category_content_table . '.lang_id,'
            . $this->feature_category_content_table . '.title,'
            . $this->feature_category_content_table . '.description,'
            . $this->feature_category_content_table . '.image_caption'
        ;

        // Feature Category Columns to be included in CU statements
        $this->feature_category_table_columns = [
            $this->feature_category_table . '.type' => 'type',
            $this->feature_category_table . '.is_active' => 'is_active',
            $this->feature_category_table . '.link' => 'link',
            $this->feature_category_table . '.image' => 'image'
        ];

        $this->feature_category_content_table_columns = [
            $this->feature_category_content_table . '.album_id' => 'album_id',
            $this->feature_category_content_table . '.lang_id' => 'lang_id',
            $this->feature_category_content_table . '.title' => 'title',
            $this->feature_category_content_table . '.description' => 'description',
            $this->feature_category_content_table . '.image_caption' => 'image_caption'
        ];

        // Feature Columns for RD
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.album_id,'
            . $this->feature_table . '.is_active,'
            . $this->feature_table . '.image,'
            . $this->feature_table . '.image_tags,'
            . $this->feature_content_table . '.lang_id,'
            . $this->feature_content_table . '.title,'
            . $this->feature_content_table . '.image_caption'
        ;

        // Define Feature columns for CU
        $this->feature_table_columns = [
            $this->feature_table . '.album_id' => 'album_id',
            $this->feature_table . '.is_active' => 'is_active',
            // $this->feature_table . '.link' => 'link',
            $this->feature_table . '.image' => 'image',
            $this->feature_table . '.image_tags' => 'image_tags',
        ];

        $this->feature_content_table_columns = [
            $this->feature_content_table . '.gallery_id' => 'gallery_id',
            $this->feature_content_table . '.title' => 'title',
            $this->feature_content_table . '.image_caption' => 'image_caption'
        ];

        
        // Define SYM templates
        // $this->preview_template = 'user-preview.html';
        // $this->detail_template = 'user-detail.html';
        // $this->edit_template = 'user-edit.html';
        
    }

}