<?php
namespace Scm\PluginSampleTheming;

use App\Helpers\Projects\ProjectFile;
use App\Helpers\Utilities;
use App\Models\Invoice;
use App\Plugins\Plugin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Scm\PluginSampleTheming\Facades\ScmSampleTheming;
use Scm\PluginSampleTheming\Models\ScmPluginSampleInventory;
use Scm\PluginSampleTheming\Models\UrlProjectFile;
use TorMorten\Eventy\Facades\Eventy;

/**
 * This is where the plugin registers its listeners and hooks up the code to deal with notices sent to those listeners
 *
 * It has some simple logic to demonstrate how to listen to one page being run (the dashboard), and has an initialize() function that is run on plugin startup
 */
class PluginLogic extends Plugin {

    /**
     * An action listener sets this bool value based if the laravel framework is currently serving the dashboard page
     * @var bool
     */
    protected bool $onDashboard = false;

    /**
     * Sets the dashboard bool to false
     */
    public function __construct()
    {
        $this->onDashboard = false;
    }

    /**
     * Runs once at plugin startup, registers some listeners
     *
     * here all the listeners are anonymous functions, but for more complicated stuff could easily be functions or classes to contain the logic of the event
     *
     * Registers a listener to change the logo used in the menu
     *
     * ```php
     * Eventy::addFilter(Plugin::FILTER_LOGO_IMAGE, function( string $what)  {
     *      Utilities::markUnusedVar($what);
     *      return ScmSampleTheming::getPluginRef()->getResourceUrl('images/loading-coffee.gif');
     *
     * }, 20, 1);
     * ```
     *
     * Registers a listener to change the blade that has the page loading image, and to change the birthday blade
     *  Eventy::addFilter(Plugin::FILTER_SET_VIEW, function( string $bade_name) {
     *      if ($bade_name === 'layouts.app.preloader') {
     *          return ScmSampleTheming::getBladeRoot().'::override/preloader';
     *      }
     *
     *      if ($bade_name === 'employee.parts.employee_birthdays') {
     *          return ScmSampleTheming::getBladeRoot().'::override/birthdays';
     *      }
     *      return $bade_name;
     * }, 20, 1);
     * ```php
     *
     * ```
     *
     * Registers a listener to add something to the top menu
     * ```php
     *  Eventy::addFilter(Plugin::FILTER_FRAME_END_TOP_MENU, function( string $extra_menu_stuff) {
     *      $item = view(ScmSampleTheming::getBladeRoot().'::content-for-filters.top-menu-item')->render();
     *      return $extra_menu_stuff."\n". $item;
     * });
     * ```
     *
     * Registers a listener to add a new stylesheet
     * ```php
     * Eventy::addFilter(Plugin::FILTER_FRAME_EXTRA_HEAD, function( string $stuff) {
     *
     *      $link = ScmSampleTheming::getPluginRef()->getResourceUrl('css/sample-theming-plugin.css')."?".time();
     *      return $stuff.
     *      "<link href='$link' rel='stylesheet'>";
     *  }, 20, 1);
     * ```
     *
     * Register a listener to see when we are on the dashboard page, and set the bool value if we are
     * ```php
     * Eventy::addAction(Plugin::ACTION_ROUTE_STARTED,function (\Illuminate\Http\Request $request) {
     *      Utilities::markUnusedVar($request);
     *      $route_name = Route::getCurrentRoute()->getName();
     *      if ($route_name === 'dashboard') {
     *          $this->onDashboard = true;
     *      } else {
     *          $this->onDashboard = false;
     *      }
     * });
     * ```
     *
     * Registers a listener to add a new blade to the dashboard at the bottom, to show output from a webservice (the quote service)
     * It is here we use the bool value for if we are on the dashboard
     * ```php
     * Eventy::addFilter(Plugin::FILTER_FRAME_BOTTOM_PANEL, function( string $stuff) {
     *      if ($this->onDashboard) {
     *          $quote = ScmSampleTheming::getQuote();
     *          $item = view(ScmSampleTheming::getBladeRoot().'::content-for-filters.quote')->with('quote',$quote)->render();
     *          return $stuff. "\n".$item;
     *      }
     *      return $stuff;
     * }, 20, 1);
     * ```
     *
     * Register an action to make something new in the database when a new invoice is created.
     * Of course, we could also update this new data when invoices are changed or deleted
     *
     * ```php
     * Eventy::addAction(Plugin::ACTION_MODEL_CREATED.Plugin::ACTION_MODEL_INVOICE , function (Invoice $invoice)
     * {
     *      $invoice_attributes = new ScmPluginSampleInventory();
     *      $invoice_attributes->invoice_id = $invoice->id;
     *      $invoice_attributes->invoice_importance = ScmPluginSampleInventory::STATUS_NORMAL;
     *      $invoice_attributes->invoice_color_code = ScmPluginSampleInventory::COLOR_CODES[ScmPluginSampleInventory::STATUS_NORMAL];
     *      $invoice_attributes->save();
     * }, 10, 1);
     * ```
     *
     * Register listeners to add a new column to the invoice table based on the something new we created.
     * ```php
     *      Eventy::addFilter(Plugin::FILTER_INVOICE_TABLE_HEADERS, function(array $column_array)  {
     *          $column_array['invoice-importance'] = "Sample Plugin Demo";
     *          return $column_array;
     *
     *      }, 5, 1);
     *
     *
     * Eventy::addFilter(Plugin::FILTER_INVOICE_TABLE_HEADERS . Plugin::TABLE_COLUMN_SUFFIX,
     * function(string $html, string $column, Invoice $invoice)
     * {
     *      $item = '';
     *      if ($column === 'invoice-importance') {
     *          $invoice_attributes = ScmPluginSampleInventory::where('invoice_id',$invoice->id)->first();
     *          if (!$invoice_attributes) {
     *              $invoice_attributes = new ScmPluginSampleInventory();
     *              $invoice_attributes->invoice_id = $invoice->id;
     *              $invoice_attributes->invoice_importance = ScmPluginSampleInventory::STATUS_NORMAL;
     *              $invoice_attributes->invoice_color_code = ScmPluginSampleInventory::COLOR_CODES[ScmPluginSampleInventory::STATUS_NORMAL];
     *              $invoice_attributes->save();
     *          }
     *          $item = view(ScmSampleTheming::getBladeRoot().'::content-for-filters.invoice-attribute-cell')
     *          ->with('setting',$invoice_attributes)
     *          ->render();
     *      }
     *      return $html. "\n".$item;
     * },
     * 5, 3);
     * ```
     *
     * @return void
     */
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

        /* Plugin files */
        Eventy::addAction(Plugin::ACTION_START_DISCOVERY_PROJECT_FILES, function( \App\Models\Project $project):void {
               //Log::debug("Project starting file discovery",['project'=>$project->toArray()]);
        }, 20, 2);

        Eventy::addFilter(Plugin::FILTER_DISCOVER_PROJECT_FILE, function( ProjectFile $project_file): ?ProjectFile {
              //Log::debug("Project file found",['project_file'=>$project_file->toArray()]);
            // return null; // if do not want this file displayed
            return $project_file;
        }, 20, 2);

        /**
         * @returns ProjectFile[]
         */
        Eventy::addFilter(Plugin::FILTER_APPEND_PROJECT_FILES, function( array $extra_project_files ): array {
            $extra_project_files[] = new UrlProjectFile('https://upload.wikimedia.org/wikipedia/commons/6/6d/CatD9T.jpg','totally-not-on-this-file-system');
             return $extra_project_files;
        }, 20, 2);

        Eventy::addFilter(Plugin::FILTER_SORT_PROJECT_FILES, function( array $all_project_files ): array {
             //do some sorting on the array $all_project_files

            usort($all_project_files, function(ProjectFile $a,ProjectFile $b)  {
                return $a <=> $b;
            });
             return $all_project_files;
        }, 20, 2);


        Eventy::addAction(Plugin::ACTION_BEFORE_DELETING_PROJECT_FILE, function( ProjectFile $project_file):void {
            Log::debug("file for project about to be deleted",['project_file'=>$project_file->toArray()]);
        }, 20, 2);
    }
}
