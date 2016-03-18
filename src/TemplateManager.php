<?php
namespace  Corb\TemplateManager;
/**
 * Created by IntelliJ IDEA.
 * User: usuario
 * Date: 18/03/16
 * Time: 04:01 PM
 */
class TemplateManager implements  TemplateManagerContract
{

    protected $models;

    public function __construct($models = array())
    {
        $this->models = $models;
    }

    public function holis()
    {
        return ('cosa');
    }
}
