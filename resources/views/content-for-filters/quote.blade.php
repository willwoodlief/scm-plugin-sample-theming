@php
    /**
     * @var \Scm\PluginSampleTheming\Models\SampleThemeQuote $quote
     */
@endphp

<div class="container">
    @if($quote->getContent())
    <blockquote class="blockquote m-auto">
        <p class="mb-0">{{$quote->getContent()}}</p>
        <footer class="blockquote-footer mt-2">
            {{$quote->getAuthor()}}
            <cite title="Source Title">
                https://api.quotable.io/random
            </cite>
        </footer>
    </blockquote>
    @else
        <h2 class="alert alert-warning m-auto" style="width: fit-content">
            Hmm.. looks like the quote generator is not working:
            <br>
            <code>{{$quote->getError()}}</code>
        </h2>
    @endif
</div>

