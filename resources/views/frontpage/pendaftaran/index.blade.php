@extends('frontpage.layouts.main')

@section('content')
    <section class="page-header -type-4 bg-beige-1">
        <div class="container">
            <div class="page-header__content">
                <div class="row">
                    <div class="col-auto">
                        <div data-anim="slide-up delay-1">
                            <h1 class="page-header__title">Pendaftaran Ekstrakurikuler</h1>
                        </div>

                        <div data-anim="slide-up delay-2">
                            <p class="page-header__text">Jangan pernah berhenti belajar,<br> karena hidup tak pernah berhenti
                                mengajarkan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row y-gap-50 justify-between">
                <div class="col-xl-5 col-lg-6">
                    <h3 class="text-24 lh-1 fw-500">Motivasi</h3>
                    <div class="row y-gap-30 pt-40">

                        <div class="col-sm-6">
                            {{-- <div class="text-20 fw-500 text-dark-1">London</div> --}}
                            <div class="y-gap-10 pt-15">
                                <p class="d-block">Belajar memang melelahkan,<br> namun akan lebih melelahkan lagi jika saat
                                    ini kamu tidak belajar.</p>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            {{-- <div class="text-20 fw-500 text-dark-1">London</div> --}}
                            <div class="y-gap-10 pt-15">
                                <p class="d-block">Berjuang itu capek,<br> namun kesuksesan butuh perjuangan.</p>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            {{-- <div class="text-20 fw-500 text-dark-1">London</div> --}}
                            <div class="y-gap-10 pt-15">
                                <p class="d-block">Orang hebat tidak dihasilkan dari kemudahan, kesenangan, dan
                                    kenyamanan.<br> Mereka dibentuk melalui kesulitan, tantangan, dan air mata.</p>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            {{-- <div class="text-20 fw-500 text-dark-1">London</div> --}}
                            <div class="y-gap-10 pt-15">
                                <p class="d-block">Orang bijak belajar ketika mereka bisa.<br> Orang bodoh belajar ketika
                                    mereka terpaksa.</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="px-40 py-40 bg-white border-light shadow-1 rounded-8 contact-form-to-top">
                        <h3 class="text-24 fw-500">Masukan Data anda</h3>
                        <p class="mt-25">Pilih Ekstrakurikuler sesuai dengan kemauan anda</p>
                        @if ($message = Session::get('success'))
                            <div style="width: 500px">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i type="button" class="fa-solid fa-xmark mx-2" style="color: black; "
                                        data-bs-dismiss="alert" aria-label="Close">
                                    </i>
                                    <p><strong>Success! </strong>{{ $message }}</p>
                                </div>
                                <br>
                                <strong>Segera Lihat Email Anda!</strong>
                            </div>
                        @endif

                        @if ($message = Session::get('error'))
                            <div style="width: 500px">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i type="button" class="fa-solid fa-xmark mx-2" style="color: black; "
                                        data-bs-dismiss="alert" aria-label="Close">
                                    </i>
                                    <p><strong>Error! </strong>{{ $message }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- <a class="cursor-pointer" href="/list-eskul-pendaftaran">Lihat Data Calon Ekstrakurikuler</a> --}}

                        @php
                            $status = array_key_exists('status_pendaftaran', $settings) ? $settings['status_pendaftaran'] : 'tidak aktif';
                        @endphp
                        @if ($status == 'aktif')
                            <form class="contact-form row y-gap-30 pt-60 lg:pt-40" id="form"
                                action="{{ route('web.pendaftaran.save') }}" method="POST" data-parsley-validate>
                                @csrf
                                @method('POST')
                                <div class="form-group col-12 form-control">
                                    <label class="text-16 lh-1 fw-500 text-dark-1 mb-10" for="inputNis">Nomor Induk
                                        Siswa</label>
                                    <input autocomplete="off" class="form-check-input" type="text" name="nis"
                                        id="inputNis" placeholder="Nomor Induk Siswa..." autocomplete="off"
                                        data-parsley-required="true" data-parsley-pattern="^[0-9]+$"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        data-parsley-trigger="change"
                                        data-parsley-error-message="NIS harus berisi hanya angka.">
                                    <div class="" style="color: #dc3545" id="accessErrorNis"></div>
                                </div>
                                <div class="form-group col-12">
                                    <label class="text-16 lh-1 fw-500 text-dark-1 mb-10" for="inputNama">Nama Siswa</label>
                                    <input autocomplete="off" class="form-check-input" type="text" id="inputNama"
                                        name="nama" placeholder="Nama Siswa..." autocomplete="off"
                                        data-parsley-required="true">
                                </div>
                                <div class="form-group col-12">
                                    <label class="text-16 lh-1 fw-500 text-dark-1 mb-10" for="inputEmail">Email</label>
                                    <input autocomplete="off" class="form-check-input" type="text" name="email"
                                        id="inputEmail" placeholder="Email Siswa..." autocomplete="off"
                                        data-parsley-required="true" data-parsley-type="email" data-parsley-trigger="change"
                                        data-parsley-error-message="Masukan alamat email yang valid.">
                                    <div class="" style="color: #dc3545" id="accessErrorEmail"></div>
                                </div>
                                <div class="form-group col-12">
                                    <label class="text-16 lh-1 fw-500 text-dark-1 mb-10" for="inputTelepon">Nomor
                                        Whatsapp</label>
                                    <input autocomplete="off" class="form-check-input" type="text" name="telepon"
                                        id="inputTelepon" placeholder="Nomor Whatsapp Siswa " autocomplete="off"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        data-parsley-required="true" data-parsley-pattern="^(628|08)[0-9]+$"
                                        data-parsley-length="[10,13]"
                                        data-parsley-error-message="Telepon harus dimulai dengan 628 atau 08 dan hanya boleh berisi angka 10 - 13 digit."
                                        data-parsley-trigger="change">
                                    <div class="" style="color: #dc3545" id="accessErrorTelepon"></div>
                                </div>
                                <div class="form-group">
                                    <label class="text-16 lh-1 fw-500 text-dark-1 mb-10" for="inputKelas">Kelas</label>
                                    <select class="custom-select rounded-0" name="kelas" id="inputKelas"
                                        autocomplete="off" data-parsley-required="true">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="text-16 lh-1 fw-500 text-dark-1 mb-10"
                                        for="inputJurusan">Jurusan</label>
                                    <select class="custom-select rounded-0" name="jurusan" id="inputJurusan"
                                        autocomplete="off" data-parsley-required="true">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="text-16 lh-1 fw-500 text-dark-1 mb-10"
                                        for="inputEskul">Ekstrakurikuler</label>
                                    <select class="custom-select rounded-0" name="eskul" id="inputEskul"
                                        autocomplete="off" data-parsley-required="true">

                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label class="text-16 lh-1 fw-500 text-dark-1 mb-10" for="inputAlasanMasuk">Alasan
                                        Masuk Ekstrakurikuler
                                        tersebut</label>
                                    <textarea class="form-check-input" type="text" name="alasan_masuk" id="inputAlasanMasuk"
                                        placeholder="Alasan... " autocomplete="off" data-parsley-required="true"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button type="submit" id="formSubmit" class="button -md -purple-1 text-white">
                                        <span class="indicator-label">Daftar</span>
                                        <span class="indicator-progress" style="display: none;">
                                            Tunggu Sebentar...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        @else
                            <h3 class="my-5 text-center"><strong>Pendaftaran ditutup</strong></h3>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/src/parsley.min.css">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>

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

            var inputEskul = $('#inputEskul');

            async function validateRemoteNis() {
                const inputNis = $('#inputNis');
                const remoteValidationUrl = "{{ route('web.pendaftaran.checkNis') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            nis: inputNis.val(),
                            eskul: inputEskul.val()
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
                const remoteValidationUrl = "{{ route('web.pendaftaran.checkTelepon') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            telepon: inputTelepon.val(),
                            eskul: inputEskul.val()
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
                const remoteValidationUrl = "{{ route('web.pendaftaran.checkEmail') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            email: inputEmail.val(),
                            eskul: inputEskul.val()
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
                url: '{{ route('web.getEskul') }}',
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
                url: '{{ route('web.getKelas') }}',
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
                url: '{{ route('web.getJurusan') }}',
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
