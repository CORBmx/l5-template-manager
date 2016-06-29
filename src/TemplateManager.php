<?php
namespace  Corb\TemplateManager;
use Schema;
use DB;
use Blade;

/**
 * Class TemplateManager
 * @package Corb\TemplateManager
 * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
 */
class TemplateManager implements  TemplateManagerContract
{


    protected $models;

    /**
     * TemplateManager constructor.
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     */
    public function __construct()
    {
        $this->models = config('template-manager.models');
    }

    /**
     * Get models found in config file
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @return mixed
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @return array of database fields
     * @access public
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

    /**
     * Parse a database template
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @param $slug Template slug from database
     * @param $data Array of data to be used in template
     * @return string|false
     * @access public
     */
    public function parse($slug, $data = [])
    {
        $template = TemplateModel::where('slug',$slug)
                                 ->first();
        if ($template) {
            return $this->bladeCompile($template->value, $data);
        }
        return false;
    }

    /**
     * Thanks stackoverflow http://stackoverflow.com/a/33872239
     * @param $value Template value to be compiled
     * @param array $args Data to be used in template
     * @return string Compiled template
     * @throws \Exception
     * @access public
     */
    public function bladeCompile($value, array $args = array())
    {
        $generated = Blade::compileString($value);

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
