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

                        <div class="breadcrumbs__item">
                            <a style="pointer-events: none; cursor: default;">Ekstrakurikuler</a>
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

                            <h1 class="page-header__title">Ekstrakurikuler</h1>

                        </div>

                        <div data-anim="slide-up delay-1">

                            <p class="page-header__text" id="info"></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-lg">
        <div data-anim="slide-up delay-1" class="container">

            <div id="eskul_data">
                <div class="row y-gap-30">
                    @foreach ($data as $row)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                            <a class="" href="{{route('web.ekstrakurikuler.showBySlug',$row->slug)}}">
                                <div class="infoCard -type-1">
                                    <div class="infoCard__image">
                                        <img style="width: 100px; height: 99px;"
                                            src="{{ img_src($row->eskul_detail->logo_url, 'eskul') }}"
                                            alt="{{ $row->nama }}">
                                    </div>
                                    <h5 class="infoCard__title text-17 lh-15 mt-10">{{ $row->nama }}</h5>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    {{ $data->links('frontpage.layouts.pagination.index') }}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {

            var infoBody = $('#info');
            infoBody.html('<div id="loadingSpinner" style="display: none;">' +
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
                        infoBody.html('Terdiri dari ' + data.length +
                            ' Ekstrakulikuler yang ada di SMKN 1 Garut! <a href="{{ route('web.pendaftaran') }}">klik disini</a> untuk daftar'
                        );

                        loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                    } else {
                        console.error("Data respons tidak valid: ", response);
                    }
                },
                error: function(response) {
                    console.error("Terjadi kesalahan dalam permintaan: ", response);
                }
            });

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    url: "{{ route('web.ekstrakurikuler.fetchData') }}?page=" + page,
                    success: function(data) {
                        $('#eskul_data').html(data);
                    },
                });
            }
        });
    </script>
@endpush
