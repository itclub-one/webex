@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Ekstrakurikuler</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.eskul') }}">Ekstrakurikuler</a></div>
            <div class="breadcrumb-item">Add</div>
        </div>
    @endpush
    @push('section_title')
        Form Ekstrakurikuler
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.eskul.save') }}" method="post" enctype="multipart/form-data" class="form"
                    id="form" data-parsley-validate>
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputSekbid" class="form-label">Sekbid</label>
                                <select class="right wide" name="sekbid" id="inputSekbid" data-parsley-required="true">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputNama" class="form-label">Nama</label>
                                <input type="text" id="inputNama" class="form-control"
                                    placeholder="Masukan Nama Ekstrakurikuler" name="nama" autocomplete="off"
                                    data-parsley-required="true">
                                <div class="" style="color: #dc3545" id="accessErrorNama"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="bodyJadwalKumpulan form-group mandatory">
                                <label for="inputJadwalKumpulan" class="form-label">Jadwal Kumpulan</label>
                                <select class="right wide" name="jadwal_kumpulan[]" multiple tabindex="-2"
                                    id="inputJadwalKumpulan" data-parsley-required="true" style="z-index: 999;">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputPembina" class="form-label">Pembina</label>
                                <input type="text" id="inputPembina" class="form-control"
                                    placeholder="Masukan Nama Pembina" name="pembina" autocomplete="off"
                                    data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputKetua" class="form-label">Ketua</label>
                                <input type="text" id="inputKetua" class="form-control" placeholder="Masukan Nama Ketua"
                                    name="ketua" autocomplete="off" data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputWakilKetua" class="form-label">Wakil Ketua</label>
                                <input type="text" id="inputWakilKetua" class="form-control"
                                    placeholder="Masukan Nama Wakil Ketua" name="wakil_ketua" autocomplete="off"
                                    data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputVisi" class="form-label">Visi</label>
                                <textarea class="summernote-simple" name="visi" id="inputVisi" placeholder="Masukan Visi Ekstrakurikuler"
                                    data-parsley-required="true" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputMisi" class="form-label">Misi</label>
                                <textarea class="summernote-simple" name="misi" id="inputMisi" placeholder="Masukan Misi Ekstrakurikuler"
                                    data-parsley-required="true" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputProgramKerja" class="form-label">Program Kerja</label>
                                <textarea class="summernote-simple" name="program_kerja" id="inputProgramKerja" data-parsley-required="true"
                                    placeholder="Masukan Program Kerja Ekstrakurikuler" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputFileLogo" class="form-label">Logo</label>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput">
                                        <img src="http://placehold.it/500x500?text=Not Found" alt="Masukan Logo"
                                            class="rounded-circle" width="150">
                                    </div>
                                    <div class="my-3">
                                        <label for="inputFileLogo" class="btn btn-outline-primary btn-file">
                                            <span class="fileinput-new ">Select Image</span>
                                            <input type="file" class="d-none" id="inputFileLogo" name="logo_url">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-instagram mr-2 icon-inline text-danger">
                                            <rect x="2" y="2" width="20" height="20" rx="5"
                                                ry="5"></rect>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                        </svg>Instagram</h6>
                                    <input type="text" name="sosmed_instagram" class="form-control"
                                        id="inputSosmedInstagram" placeholder="Masukan link url instagram Ekstrakurikuler"
                                        autocomplete="off">
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" id="formSubmit" class="btn btn-primary mx-1 mb-1">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress" style="display: none;">
                                    Tunggu Sebentar...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button type="reset" class="btn btn-secondary mx-1 mb-1">Reset</button>
                            <a href="{{ route('admin.eskul') }}" class="btn btn-danger mx-1 mb-1">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Basic Tables end -->
@endsection

@push('css')
    <link rel="stylesheet" href="{{ template_stisla('modules/summernote/summernote-bs4.css') }}">
@endpush

@push('js')
    <script src="{{ asset_administrator('assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>
    <script src="{{ template_stisla('modules/summernote/summernote-bs4.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            //validate parsley form
            const form = document.getElementById("form");
            const validator = $(form).parsley();

            const submitButton = document.getElementById("formSubmit");

            form.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });

            submitButton.addEventListener("click", async function(e) {
                e.preventDefault();

                indicatorBlock();

                // Perform remote validation
                const remoteValidationResult = await validateRemoteNama();
                const inputNama = $("#inputNama");
                const accessErrorNama = $("#accessErrorNama");
                if (!remoteValidationResult.valid) {
                    // Remote validation failed, display the error message
                    accessErrorNama.addClass('invalid-feedback');
                    inputNama.addClass('is-invalid');

                    accessErrorNama.text(remoteValidationResult
                        .errorMessage); // Set the error message from the response
                    indicatorNone();

                    return;
                } else {
                    accessErrorNama.removeClass('invalid-feedback');
                    inputNama.removeClass('is-invalid');
                    accessErrorNama.text('');
                }

                // Validate the form using Parsley
                if ($(form).parsley().validate()) {
                    indicatorSubmit();
                    // Submit the form
                    form.submit();
                } else {
                    // Handle validation errors
                    const validationErrors = [];
                    $(form).find(':input').each(function() {
                        indicatorNone();

                        const field = $(this);
                        if (!field.parsley().isValid()) {
                            const attrName = field.attr('name');
                            const errorMessage = field.parsley().getErrorsMessages().join(
                                ', ');
                            validationErrors.push(attrName + ': ' + errorMessage);
                        }
                    });
                    console.log("Validation errors:", validationErrors.join('\n'));
                }
            });

            function indicatorSubmit() {
                submitButton.querySelector('.indicator-label').style.display =
                    'inline-block';
                submitButton.querySelector('.indicator-progress').style.display =
                    'none';
            }

            function indicatorNone() {
                submitButton.querySelector('.indicator-label').style.display =
                    'inline-block';
                submitButton.querySelector('.indicator-progress').style.display =
                    'none';
                submitButton.disabled = false;
            }

            function indicatorBlock() {
                // Disable the submit button and show the "Please wait..." message
                submitButton.disabled = true;
                submitButton.querySelector('.indicator-label').style.display = 'none';
                submitButton.querySelector('.indicator-progress').style.display =
                    'inline-block';
            }

            async function validateRemoteNama() {
                const inputNama = $('#inputNama');
                const remoteValidationUrl = "{{ route('admin.eskul.checkNama') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            nama: inputNama.val()
                        }
                    });

                    // Assuming the response is JSON and contains a "valid" key
                    return {
                        valid: response.valid === true,
                        errorMessage: response.message
                    };
                } catch (error) {
                    console.error("Remote validation error:", error);
                    return {
                        valid: false,
                        errorMessage: "An error occurred during validation."
                    };
                }
            }

            var optionSekbid = $('#inputSekbid');

            var options = {
                searchable: true,
                placeholder: 'select',
                searchtext: 'search',
                selectedtext: 'dipilih'
            };
            var selectInputSekbid = NiceSelect.bind(document.getElementById("inputSekbid"), options);


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
                    var finalDropdownHtml = '<option value="" data-display="Select">Nothing</option>' +
                        optionsHtml;

                    optionSekbid.html(finalDropdownHtml);
                    selectInputSekbid.update();

                    loadingSpinner.hide(); // Hide the loading spinner after data is loaded


                },
                error: function() {
                    // Handle the error case if the AJAX request fails
                    console.error('Gagal memuat data User Group.');
                    optionSekbid.html('<option>Gagal memuat data</option>')
                    loadingSpinner
                        .hide(); // Hide the loading spinner even if there's an error
                }
            });

            var optionJadwalKumpulan = $('#inputJadwalKumpulan');

            var options = {
                searchable: true,
                placeholder: 'select',
                searchtext: 'search',
                selectedtext: 'dipilih'
            };
            var selectInputJadwalKumpulan = NiceSelect.bind(document.getElementById("inputJadwalKumpulan"),
            options);


            optionJadwalKumpulan.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.eskul.getJadwal') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.jadwal;
                    var optionsHtml = ''; // Store the generated option elements
                    console.log(data);

                    // Iterate through each user group in the response data
                    for (var i = 0; i < data.length; i++) {
                        var jadwal = data[i];
                        optionsHtml += '<option value="' + jadwal.id + '">' + jadwal
                            .hari + '</option>';
                    }

                    // Construct the final dropdown HTML
                    // var finalDropdownHtml = '<option value="">Pilih Data</option>' + optionsHtml;

                    optionJadwalKumpulan.html(optionsHtml);

                    selectInputJadwalKumpulan.update();

                    loadingSpinner.hide(); // Hide the loading spinner after data is loaded


                },
                error: function() {
                    // Handle the error case if the AJAX request fails
                    console.error('Gagal memuat data User Group.');
                    optionJadwalKumpulan.html('<option>Gagal memuat data</option>')
                    loadingSpinner
                        .hide(); // Hide the loading spinner even if there's an error
                }
            });

        });
    </script>
@endpush
