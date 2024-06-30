<?php

namespace Scm\PluginSampleTheming\Models;


use App\Models\ProjectFile;
use App\Plugins\EventConstants\ModelActions;

/**
 * This shows how a ProjectFile can be extended to allow for remote content, or to handle files differently than the core logic
 *
 * This class is used in the demonstration of the @see ModelActions::ALL_PROJECT_FILE_EVENTS
 *
 * When overloading existing project files, find the target project file that is the base, copy over the attributes as needed, and replace the child with the derived.
 * And return that substitute in the MANAGE_PROJECT_FILES filter
 *
 * When its time for the file to be deleted, either by user action or when a project is deleted, then the base ProjectFile delete action will be called,
 * and can look up that to manage resources where the file is actually stored
 *
 * important overrides is isDownloadableFromThisServer, and get_url
 */
class UrlProjectFileHelper extends ProjectFile {
    protected ?string $url = null;


    public function __construct(?int $project_id,string $url,string $file_name = null) {
        parent::__construct([]);
        $this->url = $url;
        $path = parse_url($url, PHP_URL_PATH);
        $paths = explode('/',$path);
        $file = $paths[count($paths) - 1];
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if (empty($file_name)) {
            $file_name = pathinfo($file, PATHINFO_FILENAME);
        }




        //Derived classes that are handling resources not on the file system, pass in null for the first two params and the file extension for the third

        $this->project_id = $project_id;
        $this->uploaded_by_user_id = null;
        $this->file_display_order = 0;
        $this->file_mime_type = null;
        $this->managing_plugin_name = null;
        $this->is_secure = ProjectFile::SECURITY_STATUS_IS_NORMAL;
        $this->file_extension = $extension;
        $this->file_name = $file_name;
        $this->file_human_name = $file_name;
        $this->file_size_bytes = 13.58;
        $this->created_at_ts = time();
        $this->created_at = date('F j, Y', $this->file_unix_timestamp);

    }

    public function get_url(): ?string
    {
        return $this->url;
    }





}
