<?php/** *  Поверка существования функции */function helperFunctionCheck( $func ): bool{    if( function_exists($func) )        dd("The helper function '$func' already exists.");    return true;}if( helperFunctionCheck('postCategories') ){    /**     * @param bool $refresh     * @return \App\ServicesYz\PostCategoriesService     */    function postCategories( bool $refresh = false ) : \App\ServicesYz\PostCategoriesService    {        static $post_categories_service_instance = false;        if( $refresh )            $post_categories_service_instance = false;        if( !$post_categories_service_instance )            $post_categories_service_instance = new \App\ServicesYz\PostCategoriesService();        return $post_categories_service_instance;    }}