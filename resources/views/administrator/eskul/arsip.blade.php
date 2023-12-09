@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Ekstrakurikuler</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.eskul') }}">Ekstrakurikuler</a></div>
            <div class="breadcrumb-item">Arsip</div>
        </div>
    @endpush
    @push('section_title')
        Arsip Ekstrakurikuler
    @endpush

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-8">
                        <h4>List Data</h4>
                    </div>
                    <div class="col-4" style="display: flex; justify-content: flex-end;">
                        @if (isallowed('eskul', 'add'))
                            <a href="{{ route('admin.eskul.add') }}" class="btn btn-primary">Tambah Data</a>
                        @endif
                        <a href="{{ route('admin.eskul') }}" class="btn btn-primary mx-3">Kembali</a>
                        <a href="javascript:void(0)" class="btn btn-primary" id="filterButton">Filter</a>
                    </div>

                </div>
                @include('administrator.eskul.filter.main')
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th width="25">No</th>
                                    <th width="">Nama</th>
                                    <th width="">Sekbid</th>
                                    <th width="">Slug</th>
                                    <th width="200">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('administrator.eskul.modal.detail')
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
                    url: '{{ route('admin.eskul.getDataArsip') }}',
                    dataType: "JSON",
                    type: "GET",
                    data: function(d) {
                        d.sekbid = getSekbid();
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
                        data: 'sekbid.tingkat',
                        name: 'sekbid.tingkat'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
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
                    title: 'Apakah anda yakin ingin menghapus data ini secara permanent',
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
                            url: "{{ route('admin.eskul.forceDelete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "DELETE",
                                "id": id,
                            },
                            success: function() {
                                // data_table.ajax.url(
                                //         '{{ route('admin.eskul.getData') }}')
                                //     .load();
                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire(
                                    'Berhasil!',
                                    'Data berhasil dihapus secara permanent.',
                                    'success'
                                );

                                // Remove the deleted row from the DataTable without reloading the page
                                // data_table.row($(this).parents('tr')).remove().draw();
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.restore', function(event) {
                var id = $(this).data('id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-4',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin ingin memulihkan data ini',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Saya yakin!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "PUT",
                            url: "{{ route('admin.eskul.restore') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "PUT",
                                "id": id,
                            },
                            success: function() {
                                // data_table.ajax.url(
                                //         '{{ route('admin.eskul.getData') }}')
                                //     .load();
                                data_table.ajax.reload(null, false);
                                swalWithBootstrapButtons.fire(
                                    'Berhasil!',
                                    'Data berhasil dipulihkan.',
                                    'success'
                                );

                                // Remove the PUT row from the DataTable without reloading the page
                                // data_table.row($(this).parents('tr')).remove().draw();
                            }
                        });
                    }
                });
            });

            var options = {
                searchable: true,
                placeholder: 'select',
                searchtext: 'search',
                selectedtext: 'dipilih'
            };
            var selectfilterSekbid = NiceSelect.bind(document.getElementById("filterSekbid"), options);
            var optionSekbid = $('#filterSekbid');


            optionSekbid.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.eskul.getSekbid') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.sekbid;
                    var optionsHtml = ''; // Store the generated option elements

                    // Iterate through each user group in the response data
                    for (var i = 0; i < data.length; i++) {
                        var sekbid = data[i];
                        optionsHtml += '<option value="' + sekbid.id + '">' + sekbid
                            .tingkat + '</option>';
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = '<option value="">Pilih Data</option>' + optionsHtml;

                    optionSekbid.html(finalDropdownHtml);

                    loadingSpinner.hide(); // Hide the loading spinner after data is loaded
                    selectfilterSekbid.update();
                },
                error: function() {
                    // Handle the error case if the AJAX request fails
                    console.error('Gagal memuat data User Group.');
                    optionSekbid.html('<option>Gagal memuat data</option>')
                    loadingSpinner
                        .hide(); // Hide the loading spinner even if there's an error
                }
            });

            $('#filterButton').on('click', function() {
                $('#filter_section').slideToggle();
            });

            $('#filter_submit').on('click', function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                // Get the filter value using the getSekbid() function
                var filterSekbid = getSekbid();

                // Update the DataTable with the filtered data
                data_table.ajax.url('{{ route('admin.eskul.getData') }}?sekbid=' + filterSekbid)
                    .load();
            });

            function getSekbid() {
                return $("#filterSekbid").val();
            }

        });
    </script>
@endpush
