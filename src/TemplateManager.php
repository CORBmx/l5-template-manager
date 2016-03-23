<?php
namespace  Corb\TemplateManager;
use Schema;

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
            $schema = new $model;
            $table = $schema->getTable();
            $columns = Schema::getColumnListing($table);
            $fields[$table] = $columns;
        }
        $this->fields = $fields;
        return $this->fields;
    }
}
