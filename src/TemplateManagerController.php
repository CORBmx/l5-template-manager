<?php
namespace Corb\TemplateManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

use Barryvdh\DomPDF\Facade as PDF;
use PhpOffice\PhpWord\PhpWord;




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


    public function parse(Request $request, TemplateManager $template_manager ,$id)
    {
        $template = TemplateModel::find($id);
        if ($template) {
            $output = $request->input('output');
            if (!$output) {
                $output ='html';
            }
            $data = $request->input('data');
            if ( !$data ) {
                $data = [];
            }
            $html = $template_manager->bladeCompile($template->value, $data);

            switch ($output)
            {
                case 'pdf':
                    return PDF::loadHTML($html)->setWarnings(false)->download($template->slug.'.pdf');
                break;


                case 'html':  default:
                    return $html;
                break;


                case 'doc':
                    $phpWord = new PhpWord();
                    $toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML("<p>te<b>s</b>t</p>");
                    $phpWord->setValue('test', $toOpenXML);
                    $filename = $template->slug.'.docx';
                    $phpWord->save($filename);
                    flush();
                    readfile($filename);
                    unlink($filename);
                    dd($phpWord);
                break;

            }

        }
        else {

            $data = [
                'data'    => [],
                'status'  => 'NOT_FOUND',
                'message' => 'Template not found',
            ];
            return response()->json($data, 404);
        }

    }

    public function show(Request $request, $id, TemplateManager $template_manager)
    {
        $template = TemplateModel::find($id);
        if ($template) {
            $data = [
                'data'    => $template,
                'status'  => 'OK',
                'message' => '',
            ];
            return response()->json($data, 200);
        }
        else {

            $data = [
                'data'    => [],
                'status'  => 'NOT_FOUND',
                'message' => 'Template not found',
            ];
            return response()->json($data, 404);
        }
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
     * @return mixed
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
