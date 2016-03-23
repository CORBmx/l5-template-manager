<?php
namespace Corb\TemplateManager;

use App\Http\Controllers\Controller;
class TemplateManagerController extends Controller
{
    /**
     * @param TemplateManager $templateManager
     * @return mixed
     */
    public function index(TemplateManager $templateManager)
    {
        return response()->json($templateManager->getFields());
    }

}