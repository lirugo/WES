@if (count($breadcrumbs))
    <nav>
        <div class="nav-wrapper indigo">
            <div class="col s12">
                <div class="m-l-10">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if ($breadcrumb->url && !$loop->last)
                           <a href="{{ $breadcrumb->url }}" class="breadcrumb"><small>{{ $breadcrumb->title }}</small></a>
                        @else
                           <a class="breadcrumb"><small>{{ $breadcrumb->title }}</small></a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </nav>
@endif