@extends('frontpage.layouts.main')

@section('content')
    <section data-anim="fade" class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-auto">
                    <div class="breadcrumbs__content">

                        <div class="breadcrumbs__item">
                            <a href="{{route('web')}}">Home</a>
                        </div>
                        
                        <div class="breadcrumbs__item">
                            <a href="{{route('web.berita')}}">Berita</a>
                        </div>
                        
                        <div class="breadcrumbs__item">
                            <a href="{{route('web.berita.showByEskul', $data->eskul->slug)}}">{{$data->eskul->nama}}</a>
                        </div>

                        <div class="breadcrumbs__item">
                            <a href="#">{{$data->judul}}</a>
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

                            <h1 class="page-header__title">Berita {{$data->eskul->nama}}</h1>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-sm layout-pb-lg">
        <div data-anim-wrap class="container">
            <div class="tabs -pills js-tabs">

                <div class="tabs__content pt-40 js-tabs-content">

                    <div class="tabs__pane -tab-item-1 is-active">
                        <div class="row y-gap-30">

                            <div data-anim-child="slide-up delay-4" class="col-lg-12 col-md-6">
                                <a class="blogCard -type-1 texttt">
                                    <div class="blogCard__image">
                                        <img class="w-1/1 rounded-8"
                                            src="{{ img_src($data->img_url, 'berita') }}"
                                            alt="{{ $data->judul }}">
                                    </div>
                                    <div class="blogCard__content mt-20">
                                        <h3 class="blogCard__title text-20 lh-15 fw-500 mt-5">{{ $data->judul }}
                                        </h3>
                                        <!-- Tambahkan deskripsi berita di sini -->
                                        <div class="col-lg-12 col-md-6">
                                            <div data-anim-child="slide-up delay-4" class="blogCard__content">
                                                <p class="blogCard__text text-16 mt-3">{!! $data->content !!}</p>
                                            </div>
                                        </div>
                                        <!-- Akhir dari deskripsi berita -->
                                        <div class="blogCard__author text-14">
                                            <img class="rounded-8" width="20px"
                                                src="{{ asset($data->eskul->eskul_detail->logo_url, 'eskul') }}"
                                                alt="">
                                            {{ $data->eskul->nama}}
                                        </div>
                                        <div class="blogCard__date text-14 mt-2">
                                            {{ \Carbon\Carbon::parse($data->created_at)->format('F d, Y') }}</div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
