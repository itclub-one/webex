@extends('frontpage.layouts.main')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp
    <section  class="masthead -type-3 bg-light-6 js-mouse-move-container">
        <div class="container">
            <div class="row y-gap-30 items-center justify-center">
                <div class="col-xl-7 col-lg-11 relative z-5">
                    <div class="masthead__content pl-32 lg:pl-0">
                        <h1  class="masthead__title">
                            Temukan <span class="text-purple-1">Ekstrakulikuler</span> <br>yang ada di <br> SMKN 1 Garut
                        </h1>

                        <p  class="masthead__text text-17 text-dark-1 mt-25">
                            Webex merupakan web yang berfungsi sebagai media<br class="lg:d-none">
                            untuk mengakses ekstrakulikuler yang ada di SMKN 1 Garut.
                        </p>
                    </div>
                </div>

                <div class="col-xl-5 col-lg-7 relative z-2">
                    <div class="masthead-image">
                        <div class="masthead-image__img1">
                            <div class="masthead-image__shape xl:d-none">
                                <img src="{{ asset('webex/img/home-4/masthead/shape.svg') }}" alt="image">
                            </div>
                            <img data-move="20" class="js-mouse-move" src="{{ asset('webex/img/logo/smeaa.png') }}"
                                alt="image">
                        </div>

                        <div class="masthead-image__el1">
                            <div data-move="40"
                                class="lg:d-none img-el -w-250 px-20 py-20 d-flex items-center bg-white rounded-8 js-mouse-move">
                                <div class="size-50 d-flex justify-center items-center bg-red-2 rounded-full">
                                    <img src="{{ asset('webex/img/masthead/1.svg') }}" alt="icon">
                                </div>
                                <div class="ml-20">
                                    <div class="text-orange-1 text-16 fw-500 lh-1" ><span id="eskulTotal"></span></div>
                                    <div class="mt-3">Ekstrakulikuler</div>
                                </div>
                            </div>
                        </div>

                        <div class="masthead-image__el2">
                            <div data-move="40"
                                class="shadow-4 img-el -w-260 px-40 py-20 d-flex items-center bg-white rounded-8 js-mouse-move">
                                <div class="img-el__side">
                                    <div class="size-50 d-flex justify-center items-center bg-dark-1 rounded-full">
                                        <img src="{{ asset('webex/img/masthead/2.svg') }}" alt="icon">
                                    </div>
                                </div>
                                <div class="">
                                    <div class="text-purple-1 text-16 fw-500 lh-1">Selamat Datang!</div>
                                    <div class="mt-3">Para Juara</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    
    <section class="layout-pt-md layout-pb-md border-bottom-light">
        <div class="container">
            <div class="row justify-center">
                <div class="col text-center">
                    <p class="text-lg text-dark-1">Web ini dikembangkan oleh :</p>
                </div>
            </div>

            <div class="row y-gap-30 justify-between sm:justify-start items-center pt-60 md:pt-50">

                <div class="col-lg-auto col-md-2 col-sm-3 col-4">
                    <div class="justify-center items-center px-4">
                        <img class="w-1/1" src="{{ asset('webex/img/logo_pengembang/itc.png') }}" alt="logo image">
                    </div>
                </div>
                <div class="col-lg-auto col-md-2 col-sm-3 col-4">
                    <div class="justify-center items-center px-4">
                        <img class="w-1/1" src="{{ asset('webex/img/logo_pengembang/osis.png') }}" alt="clients image">
                    </div>
                </div>
                <div class="col-lg-auto col-md-2 col-sm-3 col-4">
                    <div class="justify-center items-center px-4">
                        <img class="w-1/1" src="{{ asset('webex/img/logo_pengembang/bc.png') }}" alt="clients image">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="layout-pt-lg layout-pb-lg">
        <div class="container">
            <div class="row y-gap-20 justify-center text-center">
                <div class="col-auto">

                    <div class="sectionTitle ">

                        <h2 class="sectionTitle__title ">Ekstrakulikuler</h2>

                        <p class="sectionTitle__text " id="eskulTotal2"></p>

                        <a href="{{route('web.ekstrakurikuler')}}" class="btn btn-primary ">Lihat Semua</a>

                    </div>

                </div>
            </div>

            <div data-anim-wrap class="pt-60 lg:pt-50">
                <div class="overflow-hidden js-section-slider" data-gap="30" data-loop data-pagination
                    data-slider-cols="xl-6 lg-4 md-3 sm-2">
                    <div class="swiper-wrapper">

                        @foreach ($eskul as $row)
                            <div class="swiper-slide h-100">
                                <a class="" href="{{route('web.ekstrakurikuler.showBySlug',$row->slug)}}">
                                    <div data-anim-child="slide-left delay-2" class="infoCard -type-1">
                                        <div class="infoCard__image">
                                            <img style="width: 100px; height: 99px;"
                                                src="{{ img_src($row->eskul_detail->logo_url,'eskul') }}"
                                                alt="{{ $row->nama }}">
                                        </div>
                                        <h5 class="infoCard__title text-17 lh-15 mt-10">{{ $row->nama }}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                        
                    </div>

                    <div class="d-flex justify-center x-gap-15 items-center pt-60 lg:pt-40">
                        <div class="col-auto">
                            <div class="pagination -arrows js-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="layout-pt-lg layout-pb-lg section-bg">
        <div class="section-bg__item bg-light-6"></div>

        <div data-anim-wrap class="container">
            <div class="row y-gap-15 justify-between items-center">
                <div class="col-lg-6">

                    <div class="sectionTitle ">

                        <h2 class="sectionTitle__title ">Dokumentasi</h2>

                        <p class="sectionTitle__text ">Geser untuk melihat dokumentasi dari semua ekstrakulikuler di sini!
                        </p>

                        <a href="{{route('web.dokumentasi')}}" class="btn btn-primary ">Lihat Semua</a>

                    </div>

                </div>
            </div>

            <div class="relative">
                <div class="overflow-hidden pt-60 lg:pt-50 js-section-slider" data-gap="30" data-loop data-pagination
                    data-nav-prev="js-courses-prev" data-nav-next="js-courses-next"
                    data-slider-cols="xl-4 lg-3 md-2 sm-2">
                    <div class="swiper-wrapper">

                        @foreach ($dokumentasi as $row)
                            <div class="swiper-slide">
                                <div data-anim-child="slide-up delay-1">

                                  <a href="{{ route('web.dokumentasi.showByEskulAndSlug', ['eskul' => $row->eskul->slug, 'slug' => $row->slug]) }}"
                                        class=" coursesCard -type-1 px-10 py-10 border-light bg-white rounded-8">
                                        <div class="relative d-flex flex-column h-100">
                                            <div class="coursesCard__image overflow-hidden rounded-8">
                                                <img class="w-1/1"
                                                    src="{{ img_src($row->img_url,'dokumentasi') }}"
                                                    alt="{{ $row->nama_kegiatan }}">
                                                <div class="coursesCard__image_overlay rounded-8"></div>
                                            </div>
                                            <div class="d-flex justify-between py-10 px-10 absolute-full-center z-3">

                                            </div>
                                        </div>

                                        <div class="h-100 px-10 pt-10">

                                            <div class="text-17 lh-15 fw-500 text-dark-1 mt-10">{{ $row->nama_kegiatan }}
                                            </div>

                                            <div class="d-flex x-gap-10 items-center pt-10">

                                                <div class="d-flex items-center">
                                                    <div class="mr-2">
                                                    </div>
                                                    <div class="text-14 lh-1">{{ Str::limit(strip_tags($row->caption), 100) }}</div>
                                                </div>

                                            </div>

                                            <div class="coursesCard-footer">
                                                <div class="coursesCard-footer__author">
                                                    <img src="{{ img_src($row->eskul->eskul_detail->logo_url,'eskul') }}"
                                                        alt="{{ $row->eskul->nama }}">
                                                    <div>{{ $row->eskul->nama }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        @endforeach
                     

                    </div>
                </div>

         

            </div>
        </div>
    </section>

    <section class="layout-pt-lg layout-pb-lg">
        <div data-anim-wrap class="container">
            <div data-anim-child="slide-left delay-1" class="row y-gap-20 justify-between items-center">
                <div class="col-lg-6">

                    <div class="sectionTitle ">

                        <h2 class="sectionTitle__title ">Berita Terkini</h2>

                        <p class="sectionTitle__text ">Lihat berita terbaru dari SMKN 1 Garut di sini!</p>

                        <a href="{{route('web.berita')}}" class="btn btn-primary ">Lihat Semua</a>
                    </div>

                </div>
            </div>

            <div class="row y-gap-30 pt-50">

                @foreach ($berita1 as $row)
                    <div data-anim-child="slide-left delay-2" class="col-lg-9 col-md-6">
                        <a href="{{ route('web.berita.showByEskulAndSlug', ['eskul' => $row->eskul->slug, 'slug' => $row->slug]) }}" class=" blogCard -type-1">
                            <div class="blogCard__image">
                                <img src="{{ img_src($row->img_url,'berita') }}" alt="image">
                            </div>
                            <div class="blogCard__content">
                                <h4 class="blogCard__title">{{ $row->judul }}</h4>
                                <div class="blogCard__date">
                                    {{ \Carbon\Carbon::parse($row->created_at)->format('F d, Y') }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach

             

                <div class="col-lg-3">
                    <div class="row y-gap-30">

                        @foreach ($berita5 as $row)
                            <div class="col-lg-12 col-md-6">
                                <a href="{{ route('web.berita.showByEskulAndSlug', ['eskul' => $row->eskul->slug, 'slug' => $row->slug]) }}" data-anim-child="slide-left delay-4"
                                    class="blogCard -type-2">
                                    <div class="blogCard__image">
                                        <img src="{{ img_src($row->img_url,'berita') }}" alt="image">
                                    </div>
                                    <div class="blogCard__content">
                                        <h4 class="blogCard__title">{{ $row->judul }}</h4>
                                        <div class="blogCard__date">
                                            {{ \Carbon\Carbon::parse($row->created_at)->format('F d, Y') }}</div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            var eskulTotalBody = $('#eskulTotal');
            var eskulTotal2Body = $('#eskulTotal2');
            eskulTotalBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> ' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('web.getEskul') }}',
                method: 'GET',
                success: function(response) {
                    if (response) {
                        var data = response.eskul;
                        eskulTotalBody.html('<div>' + data.length + '+</div>');
                        eskulTotal2Body.html('Terdiri dari ' + data.length + ' Ekstrakulikuler yang ada di SMKN 1 Garut! <a href="{{route("web.pendaftaran")}}">klik disini</a> untuk daftar');

                        loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                    } else {
                        console.error("Data respons tidak valid: ", response);
                    }
                },
                error: function(response) {
                    console.error("Terjadi kesalahan dalam permintaan: ", response);
                }
            });

            // var lBody = $('#l');
            // lBody.html('<div id="loadingSpinner" style="display: none;">' +
            //     '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
            //     '</div>');
            // var loadingSpinner = $('#loadingSpinner');

            // loadingSpinner.show(); // Tampilkan elemen animasi

            // $.ajax({
            //     url: '{{ route('web.getEskul') }}',
            //     method: 'GET',
            //     success: function(response) {
            //         var data = response.eskul;
            //         // Mendapatkan URL logo menggunakan JavaScript
            //         var body = '';
            //         var no = 1;
            //         for (let i = 0; i < data.length; i++) {
            //             const imgUrl = '{{ template_stisla('') }}/img/avatar/avatar-' + no + '.png';
            //             no = (no % 4) + 1;
            //             const pendaftar = data[i];
            //             const created_at = moment(pendaftar.created_at);
            //             const diffForHumansCreatedAt = created_at.fromNow();
            //             body += '<li class="media">' +
            //                 '<img class="mr-3 rounded-circle" width="50"src="' + imgUrl +
            //                 '" alt="avatar">' +
            //                 '<div class="media-body">' +
            //                 '<div class="float-right text-primary">' + diffForHumansCreatedAt +
            //                 '</div>' +
            //                 '<div class="media-title">' + pendaftar.nama + '</div>' +
            //                 '<span class="text-small text-muted">Calon Anggota telah mendaftarkan diri ke Ekstrakurikuler ' +
            //                 pendaftar.eskul.nama + '.</span>' +
            //                 '<div class="btn-action float-right mt-4">' +
            //                 '<a href="javascript:void(0)" data-id="' + pendaftar.id +
            //                 '" class="btn btn-primary btn-sm mx-1 accept">Accept</a>' +
            //                 '<a href="javascript:void(0)" data-id="' + pendaftar.id +
            //                 '" class="btn btn-danger btn-sm mx-1 reject">Reject</a>' +
            //                 '</div>' +
            //                 '</div>' +
            //                 '</li>';
            //         }

            //         lBody.html(
            //             body
            //         );


            //         loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
            //     }
            // });
        });
    </script>
@endpush
