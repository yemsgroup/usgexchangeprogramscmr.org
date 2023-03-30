<?php 

class ThemeTemplate extends Feature
{

    function __construct()
    {

        parent::__construct();

        $this->feature = 'theme_template';
        $this->feature_category = 'templates';
        $this->feature_category_table = 'themes';
        $this->feature_table = 'theme_templates';
        $this->join_column = 'theme_id';

        // Feature Category Columns to be included in RD Statements
        $this->select_category_columns = $this->feature_category_table . '.id AS id,'
            . $this->feature_category_table . '.link AS link,'
            . $this->feature_category_table . '.title AS title,'
            . $this->feature_category_table . '.description AS description,'
            . $this->feature_category_table . '.image AS image'
        ;

        // Feature Category Columns to be included in CU statements
        $this->feature_category_table_columns = [
            $this->feature_category_table . '.link' => 'link',
            $this->feature_category_table . '.title' => 'title',
            $this->feature_category_table . '.description' => 'description',
            $this->feature_category_table . '.image' => 'image'
        ];


        // Feature Columns to be included in RD Statements
        $this->select_columns = $this->feature_table . '.id AS id,'
            . $this->feature_table . '.theme_id AS category_id,'
            . $this->feature_table . '.link AS link,'
            . $this->feature_table . '.title AS title,'
            . $this->feature_table . '.description AS description,'
            . $this->feature_table . '.filename AS filename'
        ;

        // Columns to be included in CU statements
        $this->feature_table_columns = [
            $this->feature_table . '.theme_id' => 'category_id',
            $this->feature_table . '.link' => 'link',
            $this->feature_table . '.title' => 'title',
            $this->feature_table . '.description' => 'description',
            $this->feature_table . '.filename' => 'filename'
        ];

    }

}