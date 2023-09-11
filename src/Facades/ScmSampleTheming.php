<?php

namespace Scm\PluginSampleTheming\Facades;

use App\Plugins\PluginRef;
use Illuminate\Support\Facades\Facade;
use Scm\PluginSampleTheming\Models\SampleThemeQuote;

/**
 * @uses \Scm\PluginSampleTheming\ScmSampleTheming::getPluginRef()
 * @uses \Scm\PluginSampleTheming\ScmSampleTheming::getBladeRoot()
 * @uses \Scm\PluginSampleTheming\ScmSampleTheming::getQuote()
 * @method static PluginRef getPluginRef()
 * @method static string getBladeRoot()
 * @method static SampleThemeQuote getQuote()
 */
class ScmSampleTheming extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Scm\PluginSampleTheming\ScmSampleTheming::class;
    }
}
