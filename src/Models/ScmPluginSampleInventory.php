<?php

namespace Scm\PluginSampleTheming\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin Builder
 * @mixin \Illuminate\Database\Query\Builder
 * @property int id
 * @property int invoice_id
 * @property string invoice_importance
 * @property string invoice_color_code
 * @property string created_at
 * @property string updated_at
 *
 */
class ScmPluginSampleInventory extends Model {


    use HasFactory;

    protected $table = 'scm_plugin_sample_inventory';

    const STATUS_NORMAL = 0;
    const STATUS_LEVEL_2 = 2;

    const COLOR_CODES = [
      self::STATUS_NORMAL => 'green',
      self::STATUS_LEVEL_2 => 'blue',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'invoice_importance',
        'invoice_color_code'
    ];



}
