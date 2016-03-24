<?php
namespace Corb\TemplateManager;

use App\Http\Controllers\Controller;

use App\Models\User;

/**
 * Class TemplateManagerController
 * @package Corb\TemplateManager
 * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
 */
class TemplateManagerController extends Controller
{

    /**
     * Get available database columns from config models.
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @param TemplateManager $templateManager
     * @return mixed
     */
    public function index(TemplateManager $templateManager)
    {
        return response()->json($templateManager->getFields());
    }
}