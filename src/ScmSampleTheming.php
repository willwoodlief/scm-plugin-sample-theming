<?php

namespace Scm\PluginSampleTheming;

use App\Plugins\PluginRef;
use GuzzleHttp\Client;
use Scm\PluginSampleTheming\Models\SampleThemeQuote;

//this is a facade anywhere in any code can use ScmPluginTest::logMe

/**
 * This is called from the class Scm\PluginSampleTheming\Facades\ScmSampleTheming
 *
 * The methods here are called as the facade static methods, so ScmSampleTheming::getPluginRef()
 *
 */
class ScmSampleTheming
{
    /**
     * use a plugin ref to resolve the media path via the getResourceUrl() method
     * @var PluginRef
     */
    protected PluginRef $ref;

    /**
     * This plugin only uses a single instance of this class, and that only uses a single instance of the PluginRef, here we create that
     */
    public function __construct()
    {
        $this->ref = new PluginRef(dirname(__FILE__,2));
    }


    /**
     * Public accessor to get the plugin ref, usage done in the blades mostly
     * @return PluginRef
     */
    public function getPluginRef() : PluginRef {
        return $this->ref;
    }

    /**
     * Useful for forming the full plugin blade name
     * @return string
     */
    public function getBladeRoot() : string {
        return ScmSampleThemingProvider::VIEW_BLADE_ROOT;
    }

    /**
     * This uses a web service to generate a quote when called, used in the plugin as demonstration
     *
     * This is an example how to hook a web service into a plugin framework. Of course, this can be done other ways too
     * @return SampleThemeQuote
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getQuote() : SampleThemeQuote{

        try {
            $client = new Client();

            $request_forecast = $client->get(
                'https://api.quotable.io/random',
                [

                ]
            );
            $quote = json_decode($request_forecast->getBody(), false);
            return new SampleThemeQuote($quote);
        } catch (\Exception $e) {
            return new SampleThemeQuote((object)['error'=> $e->getMessage() . ' /code '. $e->getCode()]);
        }
    }
}
