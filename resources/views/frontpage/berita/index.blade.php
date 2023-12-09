@extends('frontpage.layouts.main')

@section('content')
    <section data-anim="fade" class="breadcrumbs ">
        <div class="container">
            <div class="row">
                <div class="col-auto">
                    <div class="breadcrumbs__content">

                        <div class="breadcrumbs__item ">
                            <a href="{{ route('web') }}">Home</a>
                        </div>

                        <div class="breadcrumbs__item ">
                            <a href="#">Berita</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-header -type-1">
        <div class="container">
            <div class="page-header__content">
                <div class="row justify-center text-center">
                    <div class="col-auto">
                        <div data-anim="slide-up delay-1">

                            <h1 class="page-header__title">Berita</h1>

                        </div>

                        <div data-anim="slide-up delay-2">

                            <p class="page-header__text">Semua berita seputar ekstrakulikuler ada disini.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!empty($berita_terbaru))
    <section class="layout-pt-sm layout-pb-lg">
        <div data-anim-wrap class="container">
            <div class="tabs -pills js-tabs">

                <div class="tabs__content pt-40 js-tabs-content">

                    <div class="tabs__pane -tab-item-1 is-active">
                        <div class="row y-gap-30">

                            <div data-anim-child="slide-up delay-4" class="col-lg-8 md:d-none">
                                <a href="{{ route('web.berita.showByEskulAndSlug', ['eskul' => $berita_terbaru->eskul->slug, 'slug' => $berita_terbaru->slug]) }}"
                                    class="blogCard -type-1 texttt">
                                    <div class="blogCard__image">
                                        <img class="w-1/1 rounded-8" src="{{ img_src($berita_terbaru->img_url, 'berita') }}"
                                            alt="{{ $berita_terbaru->judul }}">
                                    </div>
                                    <div class="blogCard__content mt-20">
                                        <h4 class="blogCard__title text-20 lh-15 fw-500 mt-5">
                                            {{ \Illuminate\Support\Str::limit($berita_terbaru->judul, 50) }}</h4>
                                        <p class="blogCard__subtitle text-16">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($berita_terbaru->content), 100) }}
                                        </p> <!-- Tambahkan kode untuk menampilkan sub judul -->
                                        <div class="blogCard__author text-14">
                                            <img class="rounded-8" width="20px"
                                                src="{{ img_src($berita_terbaru->eskul->eskul_detail->logo_url, 'eskul') }}"
                                                alt="">
                                            {{ $berita_terbaru->eskul->nama }}
                                        </div>
                                        <div class="blogCard__date text-14 mt-2">
                                            {{ \Carbon\Carbon::parse($berita_terbaru->created_at)->format('F d, Y') }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4">

                                @foreach ($berita_terbaru2 as $row)
                                    <div data-anim-child="slide-up delay-4" class="col-lg-10 md:d-none">
                                        <a href="{{ route('web.berita.showByEskulAndSlug', ['eskul' => $row->eskul->slug, 'slug' => $row->slug]) }}"
                                            class="blogCard -type-1 texttt">
                                            <div class="blogCard__image">
                                                <img class="w-1/1 rounded-8" src="{{ img_src($row->img_url, 'berita') }}"
                                                    alt="{{ $row->judul }}">
                                            </div>
                                            <div class="blogCard__content mt-20">
                                                <h4 class="blogCard__title text-20 lh-15 fw-500 mt-5">
                                                    {{ \Illuminate\Support\Str::limit($row->judul, 50) }}</h4>
                                                <p class="blogCard__subtitle text-16">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($row->content), 100) }}
                                                </p> <!-- Tambahkan kode untuk menampilkan sub judul -->
                                                <div class="blogCard__author text-14">
                                                    <img class="rounded-8" width="20px"
                                                        src="{{ img_src($row->eskul->eskul_detail->logo_url, 'eskul') }}"
                                                        alt="">
                                                    {{ $row->eskul->nama }}
                                                </div>
                                                <div class="blogCard__date text-14 mt-2">
                                                    {{ \Carbon\Carbon::parse($row->created_at)->format('F d, Y') }}</div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="container" id="beritaData">
                <div class="tabs -pills js-tabs">

                    <div class="tabs__content pt-40 js-tabs-content">

                        <div class="tabs__pane -tab-item-1 is-active">
                            <div class="row y-gap-30">

                                @foreach ($data as $row)
                                    <div class="col-lg-4 col-md-6 col-6">
                                        <a href="{{ route('web.berita.showByEskulAndSlug', ['eskul' => $row->eskul->slug, 'slug' => $row->slug]) }}"
                                            class="blogCard -type-1 texttt">
                                            <div class="blogCard__image">
                                                <img class="w-1/1 rounded-8" src="{{ img_src($row->img_url, 'berita') }}"
                                                    alt="{{ $row->judul }}">
                                            </div>
                                            <div class="blogCard__content mt-20">
                                                <h4 class="blogCard__title text-20 lh-15 fw-500 mt-5">
                                                    {{ \Illuminate\Support\Str::limit($row->judul, 50) }}</h4>
                                                <p class="blogCard__subtitle text-16">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($row->content), 100) }}
                                                </p> <!-- Tambahkan kode untuk menampilkan sub judul -->
                                                <div class="blogCard__author text-14">
                                                    <img class="rounded-8" width="20px"
                                                        src="{{ img_src($row->eskul->eskul_detail->logo_url, 'eskul') }}"
                                                        alt="">
                                                    {{ $row->eskul->nama }}
                                                </div>
                                                <div class="blogCard__date text-14 mt-2">
                                                    {{ \Carbon\Carbon::parse($row->created_at)->format('F d, Y') }}</div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

                                <div class="row">
                                    {{ $data->links('frontpage.layouts.pagination.index') }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    url: "{{ route('web.berita.fetchData') }}?page=" + page,
                    success: function(data) {
                        $('#beritaData').html(data);
                    },
                });
            }
        });
    </script>
@endpush
