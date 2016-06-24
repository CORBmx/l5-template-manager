<?php
namespace Corb\TemplateManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    public function fields(TemplateManager $templateManager)
    {
        return response()->json($templateManager->getFields());
    }

    /**
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @version 0.1.0
     * @since 0.1.0
     * @param TemplateManager $templateManager
     * @return false|string
     */
    public function index()
    {
        return TemplateModel::all();
    }

    /**
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @version 0.1.0
     * @since 0.1.0
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required|unique|max:255',
            'name' => 'required',
            'value' => 'required|string|min:1',
        ]);

        $template = TemplateModel::create($request);
        $data = [
            'status'  => 'OK',
            'message' => 'Template created',
            'data'    => $template
        ];
        return response($data);
    }

    /**
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @version 0.1.0
     * @since 0.1.0
     * @param Request       $request
     * @param TemplateModel $template
     * @return Response
     */
    public function update(Request $request, TemplateModel $template)
    {
        $this->validate($request, [
            'slug' => 'required|unique|max:255',
            'name' => 'required',
            'value' => 'required|string|min:1',
        ]);

        $template->save($request);
        $data = [
            'status'  => 'OK',
            'message' => 'Template updated',
            'data'    => $template
        ];
        return response($data);
    }
}