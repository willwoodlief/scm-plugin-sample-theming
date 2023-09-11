@php
use \Scm\PluginSampleTheming\Models\ScmPluginSampleInventory;
    /**
     * @var ScmPluginSampleInventory $setting
     */
@endphp
<div class="p-1 text-center" style="background-color: {{$setting->invoice_color_code}}">
    <span class="badge @if($setting->invoice_importance === ScmPluginSampleInventory::STATUS_NORMAL) badge-info @elseif($setting->invoice_importance === ScmPluginSampleInventory::STATUS_LEVEL_2) badge-warning @else badge-default @endif">
        {{md5($setting->invoice_importance)}}
    </span>
</div>
