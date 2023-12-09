@extends('frontpage.layouts.main')

@section('content')
    <section data-anim="fade" class="breadcrumbs ">
        <div class="container">
            <div class="row">
                <div class="col-auto">
                    <div class="breadcrumbs__content">

                        <div class="breadcrumbs__item ">
                            <a href="{{route('web')}}">Home</a>
                        </div>

                        <div class="breadcrumbs__item ">
                            <a href="javascript:void(0)">Tentang Kami</a>
                        </div>

                        <div class="breadcrumbs__item ">
                            <a style="pointer-events: none; cursor: default;">Sambutan Kepala Sekolah</a>
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

                            <h1 class="page-header__title">Sambutan</h1>

                        </div>

                        <div data-anim="slide-up delay-2">

                            <p class="page-header__text">Sambutan dari kepala sekolah SMK Negeri 1 Garut</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-md">
        <div data-anim-wrap class="container">
            <div class="row y-gap-50 justify-between items-center">

                <div class="col-lg-6 pr-50 sm:pr-15">
                    <div class="composition -type-8">
                        <div class="-el-1"><img src="{{ array_key_exists('image_kepsek', $settings) ? img_src($settings['image_kepsek'], 'settings') : '' }}"
                                alt="{{ array_key_exists('nama_kepsek', $settings) ? $settings['nama_kepsek'] : '' }}"></div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <h2 class="text-30 lh-16">{{ array_key_exists('nama_kepsek', $settings) ? $settings['nama_kepsek'] : '' }}</h2>
                    <p class="text-dark-1 mt-30">{!! array_key_exists('content_kepsek', $settings) ? $settings['content_kepsek'] : '' !!}</p>
                    
                </div>
            </div>

        </div>
        </div>
    </section>
@endsection
