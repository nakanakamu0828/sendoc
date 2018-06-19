<?php
use Illuminate\Support\Facades\View;

if (!function_exists('link_to_add_fields')) {

    /**
     * 子フィールドを追加するリンクを作成する
     * 
     * @param $title リンクタイトル
     * @param $pathPrefix パス名の接頭辞（plan._action_filedの場合、'plan')
     * @param $model モデル名
     * @param $attributes リンクの属性値
     * @return リンク
     */
    function link_to_add_fields($title, $model, $pathPrefix = '', $attributes = [], $addLimit = null)
    {
        $class = 'App\\Models\\' . $model;
        $action = new $class;

        $viewPath = (strlen($pathPrefix) ? $pathPrefix . '.' : '') . '_' . str_replace('\\', '_', strtolower($model)) . '_field';
        if (!View::exists($viewPath)) return '';
        $view = view($viewPath);
        $attributes = array_merge($attributes, [ 'data-template' => $view, 'data-addfiled' => 'true' ]);
        if (!empty($addLimit) && is_numeric($addLimit) && $addLimit > 0) $attributes['data-addlimit'] = $addLimit;
        return link_to('#', $title, $attributes);
    }

    function link_to_add_tables($title, $model, $pathPrefix = '', $attributes = [], $addLimit = null)
    {
        $class = 'App\\Models\\' . $model;
        $action = new $class;

        $viewPath = (strlen($pathPrefix) ? $pathPrefix . '.' : '') . '_' . str_replace('\\', '_', strtolower($model)) . '_table';
        if (!View::exists($viewPath)) return '';
        $view = view($viewPath);
        $attributes = array_merge($attributes, [ 'data-template' => $view, 'data-addtable' => 'true' ]);
        if (!empty($addLimit) && is_numeric($addLimit) && $addLimit > 0) $attributes['data-addlimit'] = $addLimit;
        return link_to('#', $title, $attributes);
    }
}
