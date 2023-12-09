@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Jurusan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.jurusan') }}">Jurusan</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    @endpush
    @push('section_title')
        Form Jurusan
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.jurusan.update') }}" method="post" enctype="multipart/form-data"
                    class="form" id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="inputId" value="{{ $data->id }}">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputNama" class="form-label">Nama</label>
                                <input type="text" id="inputNama" class="form-control" value="{{ $data->nama }}"
                                    placeholder="Masukan Nama Jurusan (Contoh : Akuntansi)" name="nama"
                                    autocomplete="off" data-parsley-required="true">
                                <div class="" style="color: #dc3545" id="accessErrorNama"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputAlias" class="form-label">Alias</label>
                                <input type="text" id="inputAlias" class="form-control" value="{{ $data->alias }}"
                                    placeholder="Masukan Kelas Alias (Contoh : AKL)" name="alias" autocomplete="off"
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
                const inputId = $('#inputId');
                const remoteValidationUrl = "{{ route('admin.jurusan.checkNama') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            nama: inputNama.val(),
                            id: inputId.val()
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
