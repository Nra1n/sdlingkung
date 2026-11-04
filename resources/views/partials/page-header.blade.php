@php
    $crumbs = $breadcrumb ?? [['label' => $title ?? 'Halaman', 'url' => null]];
@endphp
<section class="page-header">
    <div class="container position-relative" style="z-index: 2;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-3">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                @foreach($crumbs as $crumb)
                    @if(!empty($crumb['url']))
                        <li class="breadcrumb-item"><a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a></li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $crumb['label'] }}</li>
                    @endif
                @endforeach
            </ol>
        </nav>
        <h1>{{ $title ?? 'Judul Halaman' }}</h1>
        @isset($subtitle)
            <p>{{ $subtitle }}</p>
        @endisset
    </div>
</section>
