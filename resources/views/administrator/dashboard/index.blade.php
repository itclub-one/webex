@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Dashboard</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">Dashboard</div>
        </div>
    @endpush
    @push('section_title')
        Dashboard
    @endpush
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Anggota</h4>
                    </div>
                    <div class="card-body">
                        {{ $anggota->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pendaftar</h4>
                    </div>
                    <div class="card-body">
                        {{ $pendaftar->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Dokumentasi</h4>
                    </div>
                    <div class="card-body">
                        {{ $dokumentasi->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>News</h4>
                    </div>
                    <div class="card-body">
                        {{ $berita->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Referral URL</h4>
                </div>
                <div class="card-body">
                    @php
                        $groupedStatistics = $statistic->groupBy('browser');
                        $totalStatistics = $statistic->count();
                    @endphp

                    @foreach ($groupedStatistics as $browser => $statistics)
                        @php
                            $count = count($statistics);
                            $percentage = ($count / $totalStatistics) * 100;
                        @endphp
                        <div class="mb-4">
                            <div class="text-small float-right font-weight-bold text-muted">{{ $count }}</div>
                            <div class="font-weight-bold mb-1">{{ $browser }}</div>
                            <div class="progress" data-height="3">
                                <div class="progress-bar" role="progressbar" data-width="{{ $percentage }}%"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Popular Browser</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $groupedStatistics = $statistic->groupBy('browser');
                            $totalStatistics = $statistic->count();
                        @endphp

                        @foreach ($groupedStatistics as $browser => $statistics)
                            @php
                                $count = count($statistics);
                                $percentage = ($count / $totalStatistics) * 100;
                            @endphp
                            <div class="col text-center">
                                <div class="browser browser-{{ strtolower($browser) }}"></div>
                                <div class="mt-2 font-weight-bold">{{ $browser }}</div>
                                <div class="text-muted text-small"><span class="text-primary"><i
                                            class="fas fa-caret-up"></i></span> {{ round($percentage) }}%</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if (isallowed('module_management', 'view'))
        <div class="col-lg-4 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Aktifitas Pendaftaran</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border" id="aktifitasPendaftaran">

                    </ul>
                    <div class="text-center pt-1 pb-1">
                        <a href="{{ route('admin.pendaftaran') }}" class="btn btn-primary btn-lg btn-round">
                            View All
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    </section>
@endsection

@push('js')
    <script src="{{ template_stisla('modules/moment.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            var aktifitasPendaftaranBody = $('#aktifitasPendaftaran');
            aktifitasPendaftaranBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.dashboard.getPendaftaran') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.pendaftaran;
                    console.log(data);
                    // Mendapatkan URL logo menggunakan JavaScript
                    var body = '';
                    var no = 1;
                    for (let i = 0; i < data.length; i++) {
                        const imgUrl = '{{ template_stisla('') }}/img/avatar/avatar-' + no + '.png';
                        no = (no % 4) + 1;
                        const pendaftar = data[i];
                        const created_at = moment(pendaftar.created_at);
                        const diffForHumansCreatedAt = created_at.fromNow();
                        body += '<li class="media">' +
                            '<img class="mr-3 rounded-circle" width="50"src="' + imgUrl +
                            '" alt="avatar">' +
                            '<div class="media-body">' +
                            '<div class="float-right text-primary">' + diffForHumansCreatedAt +
                            '</div>' +
                            '<div class="media-title">' + pendaftar.nama + '</div>' +
                            '<span class="text-small text-muted">Calon Anggota telah mendaftarkan diri ke Ekstrakurikuler ' +
                            pendaftar.eskul.nama + '.</span>' +
                            '<div class="btn-action float-right mt-4">' +
                            '<a href="javascript:void(0)" data-id="' + pendaftar.id +
                            '" class="btn btn-primary btn-sm mx-1 accept">Accept</a>' +
                            '<a href="javascript:void(0)" data-id="' + pendaftar.id +
                            '" class="btn btn-danger btn-sm mx-1 reject">Reject</a>' +
                            '</div>' +
                            '</div>' +
                            '</li>';
                    }

                    aktifitasPendaftaranBody.html(
                        body
                    );


                    loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                }
            });

            $(document).on('click', '.accept', function(event) {
                var id = $(this).data('id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin ingin menerima calon anggota ini',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Saya yakin!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.pendaftaran.accept') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "POST",
                                "id": id,
                            },
                            success: function() {
                                $.ajax({
                                    url: '{{ route('admin.dashboard.getPendaftaran') }}',
                                    method: 'GET',
                                    success: function(response) {
                                        var data = response.pendaftaran;
                                        var body = '';
                                        var no = 1;
                                        for (let i = 0; i < data
                                            .length; i++) {
                                            const imgUrl =
                                                '{{ template_stisla('') }}/img/avatar/avatar-' +
                                                no + '.png';
                                            no = (no % 4) + 1;
                                            const pendaftar = data[i];
                                            const created_at = moment(
                                                pendaftar.created_at);
                                            const diffForHumansCreatedAt =
                                                created_at.fromNow();
                                            body += '<li class="media">' +
                                                '<img class="mr-3 rounded-circle" width="50" src="' +
                                                imgUrl + '" alt="avatar">' +
                                                '<div class="media-body">' +
                                                '<div class="float-right text-primary">' +
                                                diffForHumansCreatedAt +
                                                '</div>' +
                                                '<div class="media-title">' +
                                                pendaftar.nama + '</div>' +
                                                '<span class="text-small text-muted">Calon Anggota telah mendaftarkan diri ke Ekstrakurikuler ' +
                                                pendaftar.eskul.nama +
                                                '.</span>' +
                                                '<div class="btn-action float-right mt-4">' +
                                                '<a href="javascript:void(0)" data-id="' +
                                                pendaftar.id +
                                                '" class="btn btn-primary btn-sm mx-1 accept">Accept</a>' +
                                                '<a href="javascript:void(0)" data-id="' +
                                                pendaftar.id +
                                                '" class="btn btn-danger btn-sm mx-1 reject">Reject</a>' +
                                                '</div>' +
                                                '</div>' +
                                                '</li>';
                                        }

                                        aktifitasPendaftaranBody.html(
                                            body
                                        );
                                    }
                                });
                                swalWithBootstrapButtons.fire({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success',
                                    timer: 1500, // 2 detik
                                    showConfirmButton: false
                                });
                            },
                            error: function(response) {
                                console.log(response);
                                swalWithBootstrapButtons.fire({
                                    title: 'Gagal!',
                                    text: response.responseJSON.message + '.',
                                    icon: 'error',
                                    timer: 1500, // 2 detik
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.reject', function(event) {
                var id = $(this).data('id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin ingin menolak calon anggota ini',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Saya yakin!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('admin.pendaftaran.reject') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "DELETE",
                                "id": id,
                            },
                            success: function() {
                                $.ajax({
                                    url: '{{ route('admin.dashboard.getPendaftaran') }}',
                                    method: 'GET',
                                    success: function(response) {
                                        var data = response.pendaftaran;
                                        var body = '';
                                        var no = 1;
                                        for (let i = 0; i < data
                                            .length; i++) {
                                            const imgUrl =
                                                '{{ template_stisla('') }}/img/avatar/avatar-' +
                                                no + '.png';
                                            no = (no % 4) + 1;
                                            const pendaftar = data[i];
                                            const created_at = moment(
                                                pendaftar.created_at);
                                            const diffForHumansCreatedAt =
                                                created_at.fromNow();
                                            body += '<li class="media">' +
                                                '<img class="mr-3 rounded-circle" width="50" src="' +
                                                imgUrl + '" alt="avatar">' +
                                                '<div class="media-body">' +
                                                '<div class="float-right text-primary">' +
                                                diffForHumansCreatedAt +
                                                '</div>' +
                                                '<div class="media-title">' +
                                                pendaftar.nama + '</div>' +
                                                '<span class="text-small text-muted">Calon Anggota telah mendaftarkan diri ke Ekstrakurikuler ' +
                                                pendaftar.eskul.nama +
                                                '.</span>' +
                                                '<div class="btn-action float-right mt-4">' +
                                                '<a href="javascript:void(0)" data-id="' +
                                                pendaftar.id +
                                                '" class="btn btn-primary btn-sm mx-1 accept">Accept</a>' +
                                                '<a href="javascript:void(0)" data-id="' +
                                                pendaftar.id +
                                                '" class="btn btn-danger btn-sm mx-1 reject">Reject</a>' +
                                                '</div>' +
                                                '</div>' +
                                                '</li>';
                                        }

                                        aktifitasPendaftaranBody.html(
                                            body
                                        );
                                    }
                                });
                                swalWithBootstrapButtons.fire({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success',
                                    timer: 1500, // 2 detik
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
