<?php

namespace  Corb\TemplateManager;
use Illuminate\Database\Eloquent\Model;

$template_table = config('template-manager.template_table');
class TemplateModel extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'value',
    ];

    protected  $table = 'tm_templates';


}
