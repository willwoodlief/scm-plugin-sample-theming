<?php

namespace Scm\PluginSampleTheming\Models;

use App\Helpers\Projects\ProjectFile;
use App\Plugins\EventConstants\ModelActions;

/**
 * This shows how a ProjectFile can be extended to allow for remote content, or to handle files differently than the core logic
 *
 * This class is used in the demonstration of the @see ModelActions::ALL_PROJECT_FILE_EVENTS
 *
 *
 * When calling the parent constructor, Derived classes that are handling resources not on the file system,
 * should pass in null for the first two params : but pass in the file extension for the third
 *
 * Then then derived class can fill in the file_name, which is for display purposes, and should not include the extension (so cat and not cat.gif),
 * the file size (in mb), the unix timestamp for the file date, a human readable date/time string
 *
 * If the derived class is storing the file outside of the website's regular upload file directory, then it should also overload the function of getPublicFilePath()
 *
 * A derived class should also overload the deleteProjectFile()
 *
 * When its time for the file to be deleted, either by user action or when a project is deleted, then the class's deleteProjectFile will be called
 */
class UrlProjectFile extends ProjectFile {
    protected ?string $url = null;


    public function __construct(string $url,string $file_name = null) {
        $this->url = $url;
        $path = parse_url($url, PHP_URL_PATH);
        $paths = explode('/',$path);
        $file = $paths[count($paths) - 1];
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if (empty($file_name)) {
            $file_name = pathinfo($file, PATHINFO_FILENAME);
        }


        //Derived classes that are handling resources not on the file system, pass in null for the first two params and the file extension for the third
        parent::__construct(null,null,$extension);

        $this->file_name = $file_name;
        $this->file_size = 13.58;
        $this->file_unix_timestamp = time();
        $this->file_date = date('F j, Y', $this->file_unix_timestamp);

    }

    public function getPublicFilePath(): ?string
    {
        return $this->url;
    }

    public function deleteProjectFile() {
        //nothing being done here, we are linking to a url we cannot control in this demo
    }




}
