@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Kelas</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.kelas') }}">Kelas</a></div>
            <div class="breadcrumb-item">Add</div>
        </div>
    @endpush
    @push('section_title')
        Form Kelas
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.kelas.save') }}" method="post" enctype="multipart/form-data" class="form"
                    id="form" data-parsley-validate>
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputKodeRomawi" class="form-label">Kode Romawi</label>
                                <input type="text" id="inputKodeRomawi" class="form-control"
                                    placeholder="Masukan Kelas Romawi (Contoh : XI)" name="kode" autocomplete="off"
                                    data-parsley-required="true">
                                <div class="" style="color: #dc3545" id="accessErrorKodeRomawi"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputKelas" class="form-label">Kelas</label>
                                <input type="text" id="inputKelas" class="form-control"
                                    placeholder="Masukan Kelas (Contoh : 11)" name="kelas" autocomplete="off"
                                    data-parsley-required="true">
                                <div class="" style="color: #dc3545" id="accessErrorKelas"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputAlias" class="form-label">Alias</label>
                                <input type="text" id="inputAlias" class="form-control"
                                    placeholder="Masukan Kelas Alias (Contoh : Sebelas)" name="alias" autocomplete="off"
                                    data-parsley-required="true">
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
                            <a href="{{ route('admin.users') }}" class="btn btn-danger mx-1 mb-1">Cancel</a>
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
                const remoteValidationResult = await validateRemoteKodeRomawi();
                const inputKodeRomawi = $("#inputKodeRomawi");
                const accessErrorKodeRomawi = $("#accessErrorKodeRomawi");
                if (!remoteValidationResult.valid) {
                    // Remote validation failed, display the error message
                    accessErrorKodeRomawi.addClass('invalid-feedback');
                    inputKodeRomawi.addClass('is-invalid');

                    accessErrorKodeRomawi.text(remoteValidationResult
                        .errorMessage); // Set the error message from the response
                    indicatorNone();

                    return;
                } else {
                    accessErrorKodeRomawi.removeClass('invalid-feedback');
                    inputKodeRomawi.removeClass('is-invalid');
                    accessErrorKodeRomawi.text('');
                }

                // Perform remote validation
                const remoteValidationResult = await validateRemoteKelas();
                const inputKelas = $("#inputKelas");
                const accessErrorKelas = $("#accessErrorKelas");
                if (!remoteValidationResult.valid) {
                    // Remote validation failed, display the error message
                    accessErrorKelas.addClass('invalid-feedback');
                    inputKelas.addClass('is-invalid');

                    accessErrorKelas.text(remoteValidationResult
                        .errorMessage); // Set the error message from the response
                    indicatorNone();

                    return;
                } else {
                    accessErrorKelas.removeClass('invalid-feedback');
                    inputKelas.removeClass('is-invalid');
                    accessErrorKelas.text('');
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

            async function validateRemoteKodeRomawi() {
                const inputKodeRomawi = $('#inputKodeRomawi');
                const remoteValidationUrl = "{{ route('admin.kelas.checkKodeRomawi') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            kode: inputKodeRomawi.val()
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

            async function validateRemoteKelas() {
                const inputKelas = $('#inputKelas');
                const remoteValidationUrl = "{{ route('admin.kelas.checkKelas') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            kode: inputKelas.val()
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

        });
    </script>
@endpush
