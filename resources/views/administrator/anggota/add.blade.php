@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Anggota Ekstrakurikuler</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.anggota') }}">Anggota Ekstrakurikuler</a></div>
            <div class="breadcrumb-item">Add</div>
        </div>
    @endpush
    @push('section_title')
        Form Anggota Ekstrakurikuler
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.anggota.save') }}" method="post" enctype="multipart/form-data" class="form"
                    id="form" data-parsley-validate>
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputNama" class="form-label">Nama</label>
                                <input type="text" id="inputNama" class="form-control" placeholder="Masukan Nama"
                                    name="nama" autocomplete="off" data-parsley-required="true">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputKelas" class="form-label">Kelas</label>
                                <select class="right wide" name="kelas" id="inputKelas" data-parsley-required="true">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputJurusan" class="form-label">Jurusan</label>
                                <select class="right wide" name="jurusan" id="inputJurusan" data-parsley-required="true">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputNis" class="form-label">NIS</label>
                                <input type="text" id="inputNis" class="form-control"
                                    placeholder="Masukan Nomor Induk Sekolah" name="nis" autocomplete="off"
                                    data-parsley-required="true" data-parsley-pattern="^[0-9]+$"
                                    data-parsley-trigger="change"
                                    data-parsley-error-message="NIS harus berisi hanya angka.">
                                <div class="" style="color: #dc3545" id="accessErrorNis"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputTelepon" class="form-label">Telepon</label>
                                <input type="text" id="inputTelepon" class="form-control"
                                    placeholder="Masukan No Telepon" name="telepon" autocomplete="off"
                                    data-parsley-required="true" data-parsley-pattern="^(628|08)[0-9]+$"
                                    data-parsley-length="[10,13]"
                                    data-parsley-error-message="Telepon harus dimulai dengan 628 atau 08 dan hanya boleh berisi angka 10 - 13 digit."
                                    data-parsley-trigger="change">
                                <div class="" style="color: #dc3545" id="accessErrorTelepon"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputEmail" class="form-label">E-mail</label>
                                <input type="text" id="inputEmail" class="form-control" placeholder="Masukan E-mail"
                                    name="email" autocomplete="off" data-parsley-required="true" data-parsley-type="email"
                                    data-parsley-trigger="change"
                                    data-parsley-error-message="Masukan alamat email yang valid.">
                                <div class="" style="color: #dc3545" id="accessErrorEmail"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputEskul" class="form-label">Eskul</label>
                                <select class="right wide" name="eskul" id="inputEskul" data-parsley-required="true">

                                </select>
                            </div>
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
                            <a href="{{ route('admin.anggota') }}" class="btn btn-danger mx-1 mb-1">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Basic Tables end -->
@endsection

@push('js')
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
                const remoteValidationResultNis = await validateRemoteNis();
                const inputNis = $("#inputNis");
                const accessErrorNis = $("#accessErrorNis");
                if (!remoteValidationResultNis.valid) {
                    // Remote validation failed, display the error message
                    accessErrorNis.addClass('invalid-feedback');
                    inputNis.addClass('is-invalid');

                    accessErrorNis.text(remoteValidationResultNis
                        .errorMessage); // Set the error message from the response
                    indicatorNone();

                    return;
                } else {
                    accessErrorNis.removeClass('invalid-feedback');
                    inputNis.removeClass('is-invalid');
                    accessErrorNis.text('');
                }

                // Perform remote validation
                const remoteValidationResultTelepon = await validateRemoteTelepon();
                const inputTelepon = $("#inputTelepon");
                const accessErrorTelepon = $("#accessErrorTelepon");
                if (!remoteValidationResultTelepon.valid) {
                    // Remote validation failed, display the error message
                    accessErrorTelepon.addClass('invalid-feedback');
                    inputTelepon.addClass('is-invalid');

                    accessErrorTelepon.text(remoteValidationResultTelepon
                        .errorMessage); // Set the error message from the response
                        indicatorNone();

                    return;
                } else {
                    accessErrorTelepon.removeClass('invalid-feedback');
                    inputTelepon.removeClass('is-invalid');
                    accessErrorTelepon.text('');
                }

                // Perform remote validation
                const remoteValidationResultEmail = await validateRemoteEmail();
                const inputEmail = $("#inputEmail");
                const accessErrorEmail = $("#accessErrorEmail");
                if (!remoteValidationResultEmail.valid) {
                    // Remote validation failed, display the error message
                    accessErrorEmail.addClass('invalid-feedback');
                    inputEmail.addClass('is-invalid');

                    accessErrorEmail.text(remoteValidationResultEmail
                        .errorMessage); // Set the error message from the response
                        indicatorNone();

                    return;
                } else {
                    accessErrorEmail.removeClass('invalid-feedback');
                    inputEmail.removeClass('is-invalid');
                    accessErrorEmail.text('');
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

            async function validateRemoteNis() {
                const inputNis = $('#inputNis');
                const remoteValidationUrl = "{{ route('admin.anggota.checkNis') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            nis: inputNis.val()
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

            async function validateRemoteTelepon() {
                const inputTelepon = $('#inputTelepon');
                const remoteValidationUrl = "{{ route('admin.anggota.checkTelepon') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            telepon: inputTelepon.val()
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

            async function validateRemoteEmail() {
                const inputEmail = $('#inputEmail');
                const remoteValidationUrl = "{{ route('admin.anggota.checkEmail') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            email: inputEmail.val()
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
            var options = {
                searchable: true,
                placeholder: 'select',
                searchtext: 'search',
                selectedtext: 'dipilih'
            };


            var optionEskul = $('#inputEskul');
            var selectInputEskul = NiceSelect.bind(document.getElementById("inputEskul"), options);


            optionEskul.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.anggota.getEskul') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.eskul;
                    var optionsHtml = ''; // Store the generated option elements

                    // Iterate through each in the response data
                    for (var i = 0; i < data.length; i++) {
                        var eskul = data[i];
                        optionsHtml += '<option value="' + eskul.id + '">' + eskul
                            .nama + '</option>';
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = '<option value="" data-display="Select">Nothing</option>' +
                        optionsHtml;

                    optionEskul.html(finalDropdownHtml);
                    selectInputEskul.update();

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


            var optionKelas = $('#inputKelas');
            var selectInputKelas = NiceSelect.bind(document.getElementById("inputKelas"), options);


            optionKelas.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.anggota.getKelas') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.kelas;
                    var optionsHtml = ''; // Store the generated option elements
                    console.log(data);

                    // Iterate through each in the response data
                    for (var i = 0; i < data.length; i++) {
                        var kelas = data[i];
                        optionsHtml += '<option value="' + kelas.id + '">' + kelas
                            .kode + ' ( ' + kelas.alias + ' )</option>';
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = '<option value="" data-display="Select">Nothing</option>' +
                        optionsHtml;

                    optionKelas.html(finalDropdownHtml);

                    selectInputKelas.update();

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


            var optionJurusan = $('#inputJurusan');
            var selectInputJurusan = NiceSelect.bind(document.getElementById("inputJurusan"), options);


            optionJurusan.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.anggota.getJurusan') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.jurusan;
                    var optionsHtml = ''; // Store the generated option elements

                    // Iterate through each in the response data
                    for (var i = 0; i < data.length; i++) {
                        var jurusan = data[i];
                        optionsHtml += '<option value="' + jurusan.id + '">' + jurusan
                            .alias + '</option>';
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = '<option value="" data-display="Select">Nothing</option>' +
                        optionsHtml;

                    optionJurusan.html(finalDropdownHtml);
                    selectInputJurusan.update();

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

        });
    </script>
@endpush
