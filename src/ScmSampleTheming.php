<?php

namespace Scm\PluginSampleTheming;

use App\Plugins\PluginRef;
use GuzzleHttp\Client;
use Scm\PluginSampleTheming\Models\SampleThemeQuote;

//this is a facade anywhere in any code can use ScmPluginTest::logMe
class ScmSampleTheming
{
    protected PluginRef $ref;

    public function __construct()
    {
        $this->ref = new PluginRef(dirname(__FILE__,2));
    }


    public function getPluginRef() : PluginRef {
        return $this->ref;
    }

    public function getBladeRoot() : string {
        return ScmSampleThemingProvider::VIEW_BLADE_ROOT;
    }

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
