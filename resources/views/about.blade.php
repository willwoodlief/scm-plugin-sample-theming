@component(ScmSampleTheming::getBladeRoot().'::frame')

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
                    <img src="{{\Scm\PluginSampleTheming\Facades\ScmSampleTheming::getPluginRef()->getResourceUrl('images/sample.jpg')}}"
                         class="card-img-top" alt="Sample image">
                    <div class="card-body">
                        <h5 class="card-title">An about page for the plugin theme sample</h5>
                        <p class="card-text">
                            There are {{$number_projects}} Projects
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">This plugin can be extended and experimented with</li>
                        <li class="list-group-item">Its fun and educational!!</li>
                        <li class="list-group-item">
                            This plugin uses different css and js than the normal pages, but it can also link into the regular page frame too
                        </li>
                        <li class="list-group-item p-4">
                            <a href="{{route('scm-sample-themes.about-framed')}}" >
                                <span class="alert alert-info">
                                    See the page that uses the normal app frame
                                </span>

                            </a>
                        </li>
                    </ul>
                    <div class="card-body">
                        <a href="https://github.com/willwoodlief/scm-plugin-sample-theming" class="card-link">On github</a>
                        <a href="{{route('dashboard')}}" class="card-link">Back to the dashboard</a>
                    </div>
                </div>

            </div>
        </div>

    @endsection
@endcomponent
