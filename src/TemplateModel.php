<?php

namespace  Corb\TemplateManager;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TemplateModel
 * @package Corb\TemplateManager
 * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
 * @version 0.1.0
 * @since 0.1.0
 */
class TemplateModel extends Model
{

    protected  $table = 'tm_templates';

    protected $fillable = [
        'name',
        'slug',
        'value',
    ];

    public $timestamps = false;
}
