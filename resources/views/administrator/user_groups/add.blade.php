@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>User Groups</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.user_groups') }}">User Groups</a></div>
            <div class="breadcrumb-item">Add</div>
        </div>
    @endpush
    @push('section_title')
        User Group
    @endpush

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('admin.user_groups.save') }}" method="post" enctype="multipart/form-data"
                    class="form" id="form" data-parsley-validate>
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="first-name-column" class="form-label">Nama</label>
                                <input type="text" id="first-name-column" class="form-control"
                                    placeholder="Masukan Nama User Group" name="name" autocomplete="off"
                                    data-parsley-required="true">
                                <div class="" style="color: red" id="accessErrorName"></div>
                            </div>
                        </div>
                        <div class="col-md-12 pt-3">
                            <div class="form-group mandatory">
                                <label class="required form-label">Permissions</label>
                                <table id="table-permissions" class="compact table table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width:50px">No</th>
                                            <th>Module</th>
                                            <th>All</th>
                                            <th>Access</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; $index = 0; foreach ($modules as $module) { ?>
                                        <tr class="permission-list">
                                            <td><?php echo $no; ?></td>
                                            <td>
                                                <?php echo $module->name; ?>
                                                <input type="hidden" name="access[<?php echo $index; ?>][modul_id]"
                                                    value="<?php echo $module->id; ?>">
                                            </td>
                                            <td>
                                                <span class="akses">
                                                    <label>
                                                        <input class="check_all check_all_<?php echo $index; ?>"
                                                            data-key_all="<?php echo $index; ?>" value="<?php echo $index; ?>"
                                                            type="checkbox" name="access[<?php echo $index; ?>][check_all]">
                                                    </label>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $ind = 0;
                                                foreach ($module->access as $row) {
                                                    $kode_akses = explode('_', $row->identifiers);
                                                    $checked = '';
                                                
                                                    echo '<span class="akses">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <input class="access_' .
                                                        $index .
                                                        '"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         type="checkbox"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         name="access[' .
                                                        $index .
                                                        '][module_access][' .
                                                        $row->id .
                                                        ']"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         value="1" ' .
                                                        $checked .
                                                        '>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  ' .
                                                        $row->name .
                                                        '
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              </label>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          </span>';
                                                    $ind++;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            $no++;
                                            $index++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div id="accessError" style="color: red"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class='form-group mandatory'>
                                <fieldset>
                                    <label class="form-label">
                                        Status
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="1"
                                            id="flexRadioDefault1" checked data-parsley-required="true">
                                        <label class="form-check-label form-label" for="flexRadioDefault1">
                                            Aktif
                                        </label>
                                    </div>
                                </fieldset>
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
                            <a href="{{ route('admin.user_groups') }}" class="btn btn-danger mx-1 mb-1">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
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
                const remoteValidationResult = await validateRemoteName();
                const firstNameColumn = $("#first-name-column");
                const accessErrorName = $("#accessErrorName");

                if (!remoteValidationResult) {
                    // Remote validation failed, display an error message

                    accessErrorName.addClass('invalid-feedback');
                    firstNameColumn.addClass('is-invalid');

                    accessErrorName.text('Nama sudah dipakai');
                    indicatorNone();

                    return;
                } else {
                    accessErrorName.removeClass('invalid-feedback');
                    firstNameColumn.removeClass('is-invalid');
                }


                // Remote validation passed, clear any previous error message
                document.getElementById("accessErrorName").textContent = "";

                // Check if at least one checkbox is checked
                if ($('input[name^="access["]:checked').length === 0) {
                    $("#table-permissions").addClass('table-invalid'); // Add this line
                    document.getElementById("accessError").textContent =
                        "Pilih setidaknya salah satu modul akses";
                    indicatorNone();
                    return;
                } else {
                    $("#table-permissions").removeClass('table-invalid'); // Add this line
                    document.getElementById("accessError").textContent = "";
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
                            const fieldName = field.attr('name');
                            const errorMessage = field.parsley().getErrorsMessages().join(', ');
                            validationErrors.push(fieldName + ': ' + errorMessage);
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

            async function validateRemoteName() {
                const nameInput = $('#first-name-column');
                const remoteValidationUrl = "{{ route('admin.user_groups.checkName') }}";
                const csrfToken = "{{ csrf_token() }}";

                try {
                    const response = await $.ajax({
                        method: "POST",
                        url: remoteValidationUrl,
                        data: {
                            _token: csrfToken,
                            name: nameInput.val()
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



            // Ambil semua checkbox "All"
            $('.permission-list').each(function() {
                var that = this;
                var key_all = $(this).find(".check_all").data('key_all');

                // Event handler for "check all" checkbox
                $(this).find(".check_all").on("click", function() {
                    if ($(this).is(':checked') == false) {
                        $(that).find('.access_' + $(this).val()).prop('checked', false);
                    } else {
                        $(that).find('.access_' + $(this).val()).prop('checked', true);
                    }
                });

                // Event handler for individual access checkboxes
                $(this).find(".access_" + key_all).on("click", function() {
                    if (!$(this).is(':checked')) {
                        $(that).find('.check_all').prop('checked', false);
                    }

                    total_access = $(that).find(".access_" + key_all).length;
                    total_given_access = $(that).find(".access_" + key_all + ":checked").length;

                    if (total_access != 0 && total_access == total_given_access) {
                        $(that).find('.check_all').prop('checked', true);
                    }
                });

                total_access = $(that).find(".access_" + key_all).length;
                total_given_access = $(that).find(".access_" + key_all + ":checked").length;

                if (total_access != 0 && total_access == total_given_access) {
                    $(that).find('.check_all').prop('checked', true);
                }
            });

        });
    </script>
@endpush
