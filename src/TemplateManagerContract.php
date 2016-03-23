<?php
namespace  Corb\TemplateManager;


Interface TemplateManagerContract
{
    public function getModels();

    public function getFields();

    public function parse($template, $data);


}
