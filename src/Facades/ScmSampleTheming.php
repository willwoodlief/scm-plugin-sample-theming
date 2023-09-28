<?php

namespace Scm\PluginSampleTheming\Facades;

use App\Plugins\PluginRef;
use Illuminate\Support\Facades\Facade;
use Scm\PluginSampleTheming\Models\SampleThemeQuote;

/**
 * Plugins do not need any facades, but given this is laravel, this these are convenient to lump some logic together that is needed by the plugin
 *
 * This class is found by the laravel framework  via the composer.json extra field "aliases"
 *
 * All this class does is hook up the Scm\PluginSampleTheming\ScmSampleTheming class to the framework
 *
 * @uses \Scm\PluginSampleTheming\ScmSampleTheming::getPluginRef()
 * @uses \Scm\PluginSampleTheming\ScmSampleTheming::getBladeRoot()
 * @uses \Scm\PluginSampleTheming\ScmSampleTheming::getQuote()
 * @method static PluginRef getPluginRef()
 * @method static string getBladeRoot()
 * @method static SampleThemeQuote getQuote()
 */
class ScmSampleTheming extends Facade
{
    /**
     * This laravel function does the hooking up of our class with the name of this Facade
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Scm\PluginSampleTheming\ScmSampleTheming::class;
    }
}
