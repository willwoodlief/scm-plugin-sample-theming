<?php
namespace Scm\PluginSampleTheming\Controllers;


use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Scm\PluginSampleTheming\Facades\ScmSampleTheming;

/**
 * This is an example controller class in a plugin, its called from the routes and uses the blades with some data that is demonstrated
 */
class SampleThemeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Makes a new url in the main site that does not use the logged in frame of menu and footer
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function about(Request $request)
    {
        $number_projects = Project::all()->count();
        return view(ScmSampleTheming::getBladeRoot().'::about')
            ->with('number_projects',$number_projects);
    }

    /**
     * Makes a new url in the main site that that uses the same menu and footer as all the other pages do
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function about_framed(Request $request)
    {
        $number_projects = Project::all()->count();
        return view(ScmSampleTheming::getBladeRoot().'::about-with-frame')
            ->with('number_projects',$number_projects);
    }



}
