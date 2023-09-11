<?php
namespace Scm\PluginSampleTheming;

use App\Helpers\Utilities;
use App\Models\Invoice;
use App\Plugins\Plugin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Scm\PluginSampleTheming\Facades\ScmSampleTheming;
use Scm\PluginSampleTheming\Models\ScmPluginSampleInventory;
use TorMorten\Eventy\Facades\Eventy;

class PluginLogic extends Plugin {

    protected bool $onDashboard = false;

    public function __construct()
    {
        $this->onDashboard = false;
    }

    public function initialize()
    {
        Eventy::addFilter(Plugin::FILTER_LOGO_IMAGE, function( string $what)  {
            Utilities::markUnusedVar($what);
            return ScmSampleTheming::getPluginRef()->getResourceUrl('images/loading-coffee.gif');

        }, 20, 1);

        Eventy::addFilter(Plugin::FILTER_SET_VIEW, function( string $bade_name) {
            if ($bade_name === 'layouts.app.preloader') {
                return ScmSampleTheming::getBladeRoot().'::override/preloader';
            }

            if ($bade_name === 'employee.parts.employee_birthdays') {
                return ScmSampleTheming::getBladeRoot().'::override/birthdays';
            }
            return $bade_name;
        }, 20, 1);

        Eventy::addFilter(Plugin::FILTER_FRAME_END_TOP_MENU, function( string $extra_menu_stuff) {
            $item = view(ScmSampleTheming::getBladeRoot().'::content-for-filters.top-menu-item')->render();
            return $extra_menu_stuff."\n". $item;
        });


        Eventy::addFilter(Plugin::FILTER_FRAME_EXTRA_HEAD, function( string $stuff) {

            $link = ScmSampleTheming::getPluginRef()->getResourceUrl('css/sample-theming-plugin.css')."?".time();
            return $stuff.
                "<link href='$link' rel='stylesheet'>";
        }, 20, 1);

        Eventy::addFilter(Plugin::FILTER_FRAME_BOTTOM_PANEL, function( string $stuff) {
            if ($this->onDashboard) {
                $quote = ScmSampleTheming::getQuote();
                $item = view(ScmSampleTheming::getBladeRoot().'::content-for-filters.quote')->with('quote',$quote)->render();
                return $stuff. "\n".$item;
            }
            return $stuff;
        }, 20, 1);

        //dashboard
        Eventy::addAction(Plugin::ACTION_ROUTE_STARTED,function (\Illuminate\Http\Request $request) {
            Utilities::markUnusedVar($request);
            $route_name = Route::getCurrentRoute()->getName();
            if ($route_name === 'dashboard') {
                $this->onDashboard = true;
            } else {
                $this->onDashboard = false;
            }
        });

        Eventy::addAction(Plugin::ACTION_MODEL_CREATED.Plugin::ACTION_MODEL_INVOICE , function (Invoice $invoice)
        {
            $invoice_attributes = new ScmPluginSampleInventory();
            $invoice_attributes->invoice_id = $invoice->id;
            $invoice_attributes->invoice_importance = ScmPluginSampleInventory::STATUS_NORMAL;
            $invoice_attributes->invoice_color_code = ScmPluginSampleInventory::COLOR_CODES[ScmPluginSampleInventory::STATUS_NORMAL];
            $invoice_attributes->save();
        }, 10, 1);


        Eventy::addFilter(Plugin::FILTER_INVOICE_TABLE_HEADERS, function(array $column_array)  {
            $column_array['invoice-importance'] = "Sample Plugin Demo";
            return $column_array;

        }, 5, 1);


        Eventy::addFilter(Plugin::FILTER_INVOICE_TABLE_HEADERS . Plugin::TABLE_COLUMN_SUFFIX,
            function(string $html, string $column, Invoice $invoice)
            {
                $item = '';
                if ($column === 'invoice-importance') {
                    $invoice_attributes = ScmPluginSampleInventory::where('invoice_id',$invoice->id)->first();
                    if (!$invoice_attributes) {
                        $invoice_attributes = new ScmPluginSampleInventory();
                        $invoice_attributes->invoice_id = $invoice->id;
                        $invoice_attributes->invoice_importance = ScmPluginSampleInventory::STATUS_NORMAL;
                        $invoice_attributes->invoice_color_code = ScmPluginSampleInventory::COLOR_CODES[ScmPluginSampleInventory::STATUS_NORMAL];
                        $invoice_attributes->save();
                    }
                    $item = view(ScmSampleTheming::getBladeRoot().'::content-for-filters.invoice-attribute-cell')
                        ->with('setting',$invoice_attributes)
                        ->render();
                }
                return $html. "\n".$item;
            },
            5, 3);

    }
}
