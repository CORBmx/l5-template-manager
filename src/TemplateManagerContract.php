<?php
namespace  Corb\TemplateManager;

/**
 * Interface TemplateManagerContract
 * @package Corb\TemplateManager
 * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
 */
Interface TemplateManagerContract
{
    public function getModels();

    public function getFields();

    public function parse($template, $data);
}
