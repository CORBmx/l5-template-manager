<?php
namespace Corb\TemplateManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;


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
        $validator = Validator::make($request->all(), [
            'slug' => 'required|unique:tm_templates|max:255',
            'name' => 'required',
            'value' => 'required|string|min:1',
        ]);
        if ($validator->fails()) {
            $status = 400;
            $data = [
                'data'    => [],
                'status'  => 'ERROR',
                'message' => $messages = $validator->errors()
            ];
        }
        else {
            $status = 200;
            $template = TemplateModel::create($request->all());
            $data = [
                'data'    => $template,
                'status'  => 'OK',
                'message' => 'Template created',
            ];
        }

        return response()->json($data,$status);
    }

    /**
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @version 0.1.0
     * @since 0.1.0
     * @param Request       $request
     * @param TemplateModel $template
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $template = TemplateModel::find($id);
        if ($template) {
            $validator = Validator::make($request->all(), [
                'slug' => 'required|unique:tm_templates,slug,'.$id.'|max:255',
                'name' => 'required',
                'value' => 'required|string|min:1',
            ]);
            if ($validator->fails()) {
                $status = 400;
                $data = [
                    'data'    => [],
                    'status'  => 'ERROR',
                    'message' => $messages = $validator->errors()
                ];
            }
            else {
                $status = 200;
                $template->update($request->all());

                $data = [
                    'data'    => $template,
                    'status'  => 'OK',
                    'message' => 'Template update',
                ];
            }
        }
        else {
            $status = 404;
            $data = [
                'data'    => [],
                'status'  => 'NOT_FOUND',
                'message' => 'Template not found',
            ];
        }
        return response()->json($data,$status);
    }

    /**
     * @author Gabriel Ortiz <gabriel.ortiz@corb.mx>
     * @version 0.1.0
     * @since 0.1.0
     * @param $id
     */
    public function destroy($id)
    {
        $template = TemplateModel::find($id);
        if ($template){
            $template->delete();
            $data = [
                'data'    => [],
                'status'  => 'OK',
                'message' => 'Template deleted',
            ];
            $status = 200;

        }
        else {
            $data = [
                'data'    => [],
                'status'  => 'NOT_FOUND',
                'message' => 'Template not found',
            ];
            $status = 404;
        }
        return response()->json($data,$status);

    }
}