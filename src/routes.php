<?php
$route_name = config('template-manager.route');

Route::resource($route_name, 'Corb\TemplateManager\TemplateManagerController');


