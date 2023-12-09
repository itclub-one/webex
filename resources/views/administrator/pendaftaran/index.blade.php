@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Pendaftaran Anggota</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Pendaftaran Anggota</div>
        </div>
    @endpush
    @push('section_title')
    Pendaftaran Anggota Ekstrakurikuler
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-8">
                        <h4>List Data</h4>
                    </div>
                    <div class="col-4" style="display: flex; justify-content: flex-end;">
                        @if (isallowed('pendaftaran', 'add'))
                            <a href="{{ route('admin.pendaftaran.add') }}" class="btn btn-primary mx-1">Tambah Data</a>
                        @endif
                        <a href="javascript:void(0)" class="btn btn-primary mx-1" id="filterButton">Filter</a>
                        @if (isallowed('pendaftaran', 'export'))
                            <a href="{{ route('admin.pendaftaran.export') }}" class="btn btn-primary mx-1">Export Data</a>
                        @endif
                    </div>
                    
                </div>
                @include('administrator.pendaftaran.filter.main')
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th width="25">No</th>
                                    <th width="">Nama</th>
                                    <th width="">Kelas</th>
                                    <th width="">Jurusan</th>
                                    <th width="">Ekstrakurikuler</th>
                                    <th width="150">Status</th>
                                    <th width="200">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('administrator.pendaftaran.modal.detail')
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
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
                    url: '{{ route('admin.pendaftaran.getData') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.eskul = getEskul();
                        d.kelas = getKelas();
                        d.jurusan = getJurusan();
                    }

                },
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'kelas.kode',
                        name: 'kelas.kode'
                    },
                    {
                        data: 'jurusan.alias',
                        name: 'jurusan.alias'
                    },
                    {
                        data: 'eskul.nama',
                        name: 'eskul.nama'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        searchable: false,
                        class: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        class: 'text-center'
                    }
                ],
            });


            $(document).on('click', '.delete', function(event) {
                var id = $(this).data('id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin ingin menghapus data ini',
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
                            url: "{{ route('admin.pendaftaran.delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "DELETE",
                                "id": id,
                            },
                            success: function() {
                                // data_table.ajax.url(
                                //         '{{ route('admin.pendaftaran.getData') }}')
                                //     .load();
                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success',
                                    timer: 1500, // 2 detik
                                    showConfirmButton: false
                                });

                                // Remove the deleted row from the DataTable without reloading the page
                                // data_table.row($(this).parents('tr')).remove().draw();
                            }
                        });
                    }
                });
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
                                // data_table.ajax.url(
                                //         '{{ route('admin.pendaftaran.getData') }}')
                                //     .load();
                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success',
                                    timer: 1500, // 2 detik
                                    showConfirmButton: false
                                });

                                // Remove the deleted row from the DataTable without reloading the page
                                // data_table.row($(this).parents('tr')).remove().draw();
                            },
                            error: function(response) {
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
                                // data_table.ajax.url(
                                //         '{{ route('admin.pendaftaran.getData') }}')
                                //     .load();
                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire({
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success',
                                    timer: 1500, // 2 detik
                                    showConfirmButton: false
                                });

                                // Remove the deleted row from the DataTable without reloading the page
                                // data_table.row($(this).parents('tr')).remove().draw();
                            }
                        });
                    }
                });
            });
            var options = {searchable: true, placeholder: 'select', searchtext: 'search', selectedtext: 'dipilih'};

            var optionEskul = $('#filterEskul');
            var selectfilterEskul = NiceSelect.bind(document.getElementById("filterEskul"), options);


            optionEskul.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.pendaftaran.getEskul') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.eskul;
                    var optionsHtml = ''; // Store the generated option elements

                    // Iterate through each user group in the response data
                    for (var i = 0; i < data.length; i++) {
                        var eskul = data[i];
                        optionsHtml += '<option value="' + eskul.id + '">' + eskul
                            .nama + '</option>';
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = '<option value="">Pilih Data</option>' + optionsHtml;

                    optionEskul.html(finalDropdownHtml);
                    selectfilterEskul.update();

                    loadingSpinner.hide(); // Hide the loading spinner after data is loaded
                },
                error: function() {
                    // Handle the error case if the AJAX request fails
                    console.error('Gagal memuat data.');
                    optionEskul.html('<option>Gagal memuat data</option>')
                    loadingSpinner
                        .hide(); // Hide the loading spinner even if there's an error
                }
            });

            var optionKelas = $('#filterKelas');
            var selectfilterKelas = NiceSelect.bind(document.getElementById("filterKelas"), options);


            optionKelas.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.pendaftaran.getKelas') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.kelas;
                    var optionsHtml = ''; // Store the generated option elements

                    // Iterate through each user group in the response data
                    for (var i = 0; i < data.length; i++) {
                        var kelas = data[i];
                        optionsHtml += '<option value="' + kelas.id + '">' + kelas
                            .kode + ' ( '+kelas.alias+' )</option>';
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = '<option value="">Pilih Data</option>' + optionsHtml;

                    optionKelas.html(finalDropdownHtml);
                    selectfilterKelas.update();

                    loadingSpinner.hide(); // Hide the loading spinner after data is loaded
                },
                error: function() {
                    // Handle the error case if the AJAX request fails
                    console.error('Gagal memuat data.');
                    optionKelas.html('<option>Gagal memuat data</option>')
                    loadingSpinner
                        .hide(); // Hide the loading spinner even if there's an error
                }
            });

            var optionJurusan = $('#filterJurusan');
            var selectfilterJurusan = NiceSelect.bind(document.getElementById("filterJurusan"), options);


            optionJurusan.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.pendaftaran.getJurusan') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.jurusan;
                    var optionsHtml = ''; // Store the generated option elements

                    // Iterate through each user group in the response data
                    for (var i = 0; i < data.length; i++) {
                        var jurusan = data[i];
                        optionsHtml += '<option value="' + jurusan.id + '">' + jurusan
                            .alias + '</option>';
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = '<option value="">Pilih Data</option>' + optionsHtml;

                    optionJurusan.html(finalDropdownHtml);
                    selectfilterJurusan.update();

                    loadingSpinner.hide(); // Hide the loading spinner after data is loaded
                },
                error: function() {
                    // Handle the error case if the AJAX request fails
                    console.error('Gagal memuat data.');
                    optionJurusan.html('<option>Gagal memuat data</option>')
                    loadingSpinner
                        .hide(); // Hide the loading spinner even if there's an error
                }
            });

            $('#filterButton').on('click', function() {
                $('#filter_section').slideToggle();
            });

            $('#filter_submit').on('click', function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                // Get the filter value using the getEskul() function
                var filterEskul = getEskul();

                var filterKelas = getKelas();

                var filterJurusan = getJurusan();

                // Update the DataTable with the filtered data
                data_table.ajax.url('{{ route('admin.pendaftaran.getData') }}?sekbid=' + filterEskul + '|kelas=' + filterKelas + '|jurusan=' + filterJurusan )
                    .load();
            });

            function getEskul() {
                return $("#filterEskul").val();
            }

            function getKelas() {
                return $("#filterKelas").val();
            }

            function getJurusan() {
                return $("#filterJurusan").val();
            }

        });
    </script>
@endpush
