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
                            <a href="{{ route('web.ekstrakurikuler') }}">Ekstrakurikuler</a>
                        </div>

                        <div class="breadcrumbs__item ">
                            <a style="pointer-events: none; cursor: default;">{{ $data->nama }}</a>
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

                            <h1 class="page-header__title">{{ $data->nama }}</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row no-gutters justify-content-center">
                <div class="col-xl-8 col-lg-9 col-md-11">
                    <div class="shopCompleted-header">
                        <img src="{{ img_src($data->eskul_detail->logo_url, 'eskul') }}" alt="{{ $data->nama }}"
                            width="500px">
                    </div>

                    <div class="shopCompleted-info">
                        <div class="row no-gutters y-gap-32">
                            <div class="col-md-3 col-sm-6">
                                <div class="shopCompleted-info__item">
                                    <div class="subtitle">PEMBINA</div>
                                    <div class="title text-purple-1">{{ $data->eskul_detail->pembina }}</div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="shopCompleted-info__item">
                                    <div class="subtitle">KETUA</div>
                                    <div class="title text-purple-1">{{ $data->eskul_detail->ketua }}</div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="shopCompleted-info__item">
                                    <div class="subtitle">WAKIL KETUA</div>
                                    <div class="title text-purple-1">{{ $data->eskul_detail->wakil_ketua }}</div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="shopCompleted-info__item">
                                    <div class="subtitle">JADWAL KUMPULAN</div>
                                    <div class="title text-purple-1" id="jadwalKumpulan"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-center mt-3"><a href="{{ route('web.pendaftaran') }}">klik disini</a> untuk daftar
                        </p>
                    </div>

                    <div class="shopCompleted-footer bg-light-4 border-light rounded-8">
                        <div class="shopCompleted-footer__wrap">
                            <center>
                                <h2 class="title">
                                    VISI & MISI
                                </h2>
                            </center>
                            <div data-anim="slide-up delay-3" class="row justify-center">
                                <div class="col-xl-8 col-lg-9 col-md-11">
                                    <h5>VISI</h5>
                                    <p class="mt-30">{!! $data->eskul_detail->visi !!}</p>
                                </div>

                                <div class="col-xl-8 col-lg-9 col-md-11">
                                    <div class="mt-60 lg:mt-40">
                                        <h5>MISI</h5>
                                        <p class="mt-30">{!! $data->eskul_detail->misi !!}</p>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-9 col-md-11">
                                    <div class="mt-60 lg:mt-40">
                                        <h5>Program Kerja</h5>
                                        <p class="mt-30">{!! $data->eskul_detail->program_kerja !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="shopCompleted-footer bg-light-4 border-light rounded-8">
                        <div class="shopCompleted-footer__wrap">
                            <center>
                                <h2 class="title">
                                    Anggota {{ $data->nama }}
                                </h2>
                            </center>
                            <div class="row">
                                <table id="datatable" class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama Anggota</th>
                                            <th>Kelas</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-lg">
        <div class="container" id="dokumentasiData">

            <div class="row y-gap-30">
                @foreach ($dokumentasiByEskul as $row)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                        <a href="/dokumentasi/{{ $row->slug }}" class="coursesCard -type-1 texttt">
                            <div class="relative">
                                <div class="coursesCard__image overflow-hidden rounded-8">
                                    <img class="w-1/1" src="{{ img_src($row->img_url, 'dokumentasi') }}"
                                        alt="{{ $row->nama_kegiatan }}">
                                    <div class="coursesCard__image_overlay rounded-8"></div>
                                </div>
                                <div class="d-flex justify-between py-10 px-10 absolute-full-center z-3">
                                </div>
                            </div>
                            <div class="h-100 pt-15">
                                <div class="text-17 lh-15 fw-500 text-dark-1 mt-10">{{ $row->nama_kegiatan }}</div>
                                <div class="d-flex x-gap-10 items-center pt-10">
                                    <div class="d-flex items-center">
                                        <div class="text-14 lh-1">{{ Str::limit(strip_tags($row->caption), 100) }}</div>
                                    </div>
                                </div>
                                <div class="coursesCard-footer">
                                    <div class="coursesCard-footer__author">
                                        <img src="{{ img_src($row->eskul->eskul_detail->logo_url, 'eskul') }}"
                                            alt="">
                                        <div>{{ $row->eskul->nama }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>

            <div class="row">
                {{ $dokumentasiByEskul->links('frontpage.layouts.pagination.index') }}
            </div>
        </div>
    </section>
@endsection

@push('css')
    <!-- CSS jQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css">

    <!-- CSS DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.semanticui.min.css">

    <style>
        div.dataTables_processing {
            position: relative !important;
        }
    </style>
@endpush

@push('js')
    <!-- JS jQuery UI -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.semanticui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var jadwalKumpulanBody = $('#jadwalKumpulan');
            jadwalKumpulanBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> ' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('web.ekstrakurikuler.getEskulBySlug') }}',
                method: 'GET',
                data: {
                    slug: '{{ $data->slug }}'
                },
                success: function(response) {
                    if (response) {
                        var data = response.eskul;
                        var jadwal_kumpulan = response.jadwal_kumpulan;
                        var jadwal_html = '';

                        for (let i = 0; i < jadwal_kumpulan.length; i++) {
                            var jadwal = jadwal_kumpulan[i];
                            var jadwal_eskul = jadwal.jadwal.hari + ', ';
                            jadwal_html += jadwal_eskul;
                        }

                        jadwalKumpulanBody.html(
                            jadwal_html
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

            var data_table = $('#datatable').DataTable({
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": "<i class='ti-angle-left'></i>",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": "<i class='ti-angle-right'></i>"
                    }
                },
                processing: true,
                serverSide: true,
                order: [
                    [0, 'asc']
                ],
                scrollX: true, // Enable horizontal scrolling
                ajax: {
                    url: '{{ route('web.ekstrakurikuler.getDataAnggota') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: {
                        id: '{{ $data->id }}'
                    },
                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'kelas.kode',
                        name: 'kelas.kode',
                        render: function(data, type, row) {
                            return row.kelas.kode + ' - ' + row.jurusan.alias;
                        }
                    },
                ],
            });

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    url: "{{ route('web.ekstrakurikuler.fetchDataDokumentasi', $data->slug) }}?page=" +
                        page,
                    success: function(data) {
                        $('#dokumentasiData').html(data);
                    },
                });
            }
        });
    </script>
@endpush
