@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Jadwal</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.jadwal') }}">Jadwal</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    @endpush
    @push('section_title')
        Form Jadwal
    @endpush
    <!-- Basic Tables start -->
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.jadwal.update') }}" method="post" enctype="multipart/form-data" class="form"
                    id="form" data-parsley-validate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="inputId" value="{{ $data->id }}">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="inputHari" class="form-label">Hari</label>
                                <select class="wide" name="hari" id="inputHari" data-parsley-required="true">

                                </select>
                                <div class="" style="color: #dc3545" id="accessErrorHari"></div>
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
                const remoteValidationResult = await validateRemoteHari();
                const inputHari = $("#inputHari");
                const accessErrorHari = $("#accessErrorHari");
                if (!remoteValidationResult.valid) {
                    // Remote validation failed, display the error message
                    accessErrorHari.addClass('invalid-feedback');
                    inputHari.addClass('is-invalid');

                    accessErrorHari.text(remoteValidationResult
                        .errorMessage); // Set the error message from the response
                    indicatorNone();

                    return;
                } else {
                    accessErrorHari.removeClass('invalid-feedback');
                    inputHari.removeClass('is-invalid');
                    accessErrorHari.text('');
                }

                // Validate the form using Parsley
                if ($(form).parsley().validate()) {
                    indicatorSubmit();

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

            async function validateRemoteHari() {
                const inputHari = $('#inputHari');
                const inputId = $('#inputId');
                const remoteValidationUrl = "{{ route('admin.jadwal.checkHari') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            hari: inputHari.val(),
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

            var options = {
                searchable: true,
                placeholder: 'select',
                searchtext: 'search',
                selectedtext: 'dipilih'
            };
            var optionHari = $('#inputHari');
            var selectinputHari = NiceSelect.bind(document.getElementById("inputHari"), options);


            optionHari.html(
                '<option id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin">' +
                '</i> Sedang memuat...</option>'
            );

            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.jadwal.getHari') }}',
                method: 'GET',
                success: function(response) {
                    var data = response.hari;
                    var optionsHtml = ''; // Store the generated option elements

                    // Get the selectedHari from PHP
                    var selectedHari = '{{ $data->hari ?? '' }}';

                    // Iterate through each day in the response data
                    for (var i = 0; i < data.length; i++) {
                        var hari = data[i];

                        // Check if hari is not equal to selectedHari before adding it to optionsHtml
                        if (hari !== selectedHari) {
                            optionsHtml += '<option value="' + hari + '">' + hari + '</option>';
                        }
                    }

                    // Construct the final dropdown HTML
                    var finalDropdownHtml = '<option value="' + selectedHari + '" selected>' +
                        selectedHari + '</option>' + optionsHtml;

                    // Assuming inputHari is the ID of your dropdown element
                    $('#inputHari').html(finalDropdownHtml);
                    selectinputHari.update();
                    loadingSpinner.hide(); // Hide the loading spinner after data is loadeds
                },
                error: function() {
                    // Handle the error case if the AJAX request fails
                    console.error('Gagal memuat data User Group.');
                    // Assuming inputHari is the ID of your dropdown element
                    $('#inputHari').html('<option>Gagal memuat data</option>');
                    loadingSpinner.hide(); // Hide the loading spinner even if there's an error
                }
            });




        });
    </script>
@endpush
