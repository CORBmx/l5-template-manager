<?php
namespace  Corb\TemplateManager;
use Schema;
use DB;

/**
 * Class TemplateManager
 * @package Corb\TemplateManager
 */
class TemplateManager implements  TemplateManagerContract
{

    protected $models;

    /**
     * TemplateManager constructor.
     */
    public function __construct()
    {
        $this->models = config('template-manager.models');
    }

    /**
     * @return mixed
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        $fields  = [];
        foreach($this->models as $model)
        {
            $schema  = new $model;
            $table   = $schema->getTable();
            $columns = Schema::getColumnListing($table);
            $fields[$table] = $columns;
        }
        $this->fields = $fields;
        return $this->fields;
    }

    public function parse($slug, $data)
    {
        $template = DB::table(config('template-manager.template_table'))
                      ->where('slug',$slug)
                      ->first();
        if($template)
        {

            dd($this->bladeCompile($template->value, $data));
        }
        dd($template);

    }

    public function bladeCompile($value, array $args = array())
    {
        $generated = \Blade::compileString($value);

        ob_start() and extract($args, EXTR_SKIP);

        // We'll include the view contents for parsing within a catcher
        // so we can avoid any WSOD errors. If an exception occurs we
        // will throw it out to the exception handler.
        try
        {
            eval('?>'.$generated);
        }

            // If we caught an exception, we'll silently flush the output
            // buffer so that no partially rendered views get thrown out
            // to the client and confuse the user with junk.
        catch (\Exception $e)
        {
            ob_get_clean(); throw $e;
        }

        $content = ob_get_clean();

        return $content;
    }
}


