@component('layouts.app')

    @section('page_title')
        About Page
    @endsection

    @section('main_content')
        <div class="row mt-5">

            <div class="col-12">

                <div class="card m-auto" style="width: 35rem;">
                    <div class="card-header">
                        <div class="card-title">
                            <h1>
                                @auth
                                    Hello
                                @else
                                    <a href="{{route('login')}}">
                                        Please Login
                                    </a>
                                @endauth

                            </h1>
                        </div>
                    </div>
                    <img src="{{\Scm\PluginSampleTheming\Facades\ScmSampleTheming::getPluginRef()->getResourceUrl('images/dozers.jpg')}}" class="card-img-top" alt="Sample image">
                    <div class="card-body">
                        <h5 class="card-title">A sample page from a plugin</h5>
                        <p class="card-text">
                            There are {{$number_projects}} Projects
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">This plugin can be extended and experimented with</li>
                        <li class="list-group-item">Its fun and educational!!</li>
                        <li class="list-group-item">
                            <span class="alert-success">
                                This page from the plugin uses the normal app layout
                            </span>
                        </li>
                        <li class="list-group-item">
                            <a href="{{route('scm-sample-themes.about')}}" class="alert alert-info">
                                See the page that uses totally different frame
                            </a>
                        </li>
                    </ul>
                    <div class="card-body" style="min-height: 80px">
                        <a href="https://github.com/willwoodlief/scm-plugin-sample-theming" class="card-link">On github</a>
                        <a href="{{route('dashboard')}}" class="card-link">Back to the dashboard</a>
                    </div>
                </div>

            </div>
        </div>

    @endsection
@endcomponent
