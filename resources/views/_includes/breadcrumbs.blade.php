@if (count($breadcrumbs))
    <nav>
        <div class="nav-wrapper indigo">
            <div class="col s12">
                <div class="m-l-10">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if ($breadcrumb->url && !$loop->last)
                           <a href="{{ $breadcrumb->url }}" class="breadcrumb">{{ $breadcrumb->title }}</a>
                        @else
                            <a class="breadcrumb">{{ $breadcrumb->title }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </nav>
@endif