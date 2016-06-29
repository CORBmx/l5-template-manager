<?php
$route_name = config('template-manager.route');

Route::get($route_name.'/fields', "Corb\TemplateManager\TemplateManagerController@fields");
Route::post($route_name.'/{id}/parse', "Corb\TemplateManager\TemplateManagerController@parse");
Route::get($route_name.'/{id}/parse', "Corb\TemplateManager\TemplateManagerController@parse");
Route::resource($route_name, 'Corb\TemplateManager\TemplateManagerController');
