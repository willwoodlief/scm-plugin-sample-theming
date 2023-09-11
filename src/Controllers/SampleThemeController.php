<?php
namespace Scm\PluginSampleTheming\Controllers;


use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Scm\PluginSampleTheming\Facades\ScmSampleTheming;

class SampleThemeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function about(Request $request)
    {
        $number_projects = Project::all()->count();
        return view(ScmSampleTheming::getBladeRoot().'::about')
            ->with('number_projects',$number_projects);
    }

    public function about_framed(Request $request)
    {
        $number_projects = Project::all()->count();
        return view(ScmSampleTheming::getBladeRoot().'::about-with-frame')
            ->with('number_projects',$number_projects);
    }



}
