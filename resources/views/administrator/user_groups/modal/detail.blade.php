<!-- Modal Detail User Group -->
<div class="modal fade" tabindex="-1" role="dialog" id="detailUserGroups" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailUserGroupsLabel">Detail User Group</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailUserGroupsBody">

            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#detailUserGroups').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modalBody = $('#detailUserGroupsBody');
            modalBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.user_groups.getDetail', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    var data = response.data;
                    var modules = response.modules;
                    var permission = response.permission[data.id];

                    var permissionTableHTML =
                        '<table id="table-permissions" class="compact table" style="border: 1px solid #000;" width="100%">' +
                        '<thead>' +
                        '<tr>' +
                        '<th style="width:50px; border: 1px solid #000;">No</th>' +
                        '<th style="border: 1px solid #000;">Module</th>'; // No additional column for description

                    var hasAccessColumn = false; // To track if there is at least one module with access

                    for (var i = 0; i < modules.length; i++) {
                        var module = modules[i];
                        var modulePermissions = permission[module.identifiers];
                        var hasAccess = false;

                        for (var key in modulePermissions) {
                            if (modulePermissions[key] === '1') {
                                hasAccess = true;
                                hasAccessColumn = true;
                                break;
                            }
                        }

                        if (hasAccess) {
                            permissionTableHTML += '<th style="border: 1px solid #000;">Access</th>';
                            break; // Only need one column
                        }
                    }

                    permissionTableHTML += '</tr></thead><tbody>';

                    for (var i = 0; i < modules.length; i++) {
                        var module = modules[i];
                        var modulePermissions = permission[module.identifiers];
                        var hasAccess = false;

                        for (var key in modulePermissions) {
                            if (modulePermissions[key] === '1') {
                                hasAccess = true;
                                break;
                            }
                        }

                        if (hasAccess) {
                            permissionTableHTML += '<tr class="permission-list">' +
                                '<td style="border: 1px solid #000;">' + (i + 1) + '</td>' +
                                '<td style="border: 1px solid #000;">' + module.name + '</td>';

                            permissionTableHTML += '<td style="border: 1px solid #000;">';

                            for (var key in modulePermissions) {
                                if (modulePermissions[key] === '1') {
                                    permissionTableHTML +=
                                        '<div style="margin-top: 3px;padding: 5px; border: 1px solid #000; margin-bottom: 5px;">' +
                                        key + '</div>';
                                }
                            }

                            permissionTableHTML += '</td></tr>';
                        }
                    }

                    permissionTableHTML += '</tbody></table>';


                    modalBody.html(
                        '<p>ID: ' + data.id + '</p>' +
                        '<p>Nama User Group: ' + data.name + '</p>' +
                        '<p>Status: ' + (data.status === '1' ? 'Aktif' : 'Tidak Aktif') + '</p>' +
                        '<p><strong>Permission:</strong></p>' + (hasAccessColumn ?
                            permissionTableHTML : 'No access permissions for any module')
                    );

                    loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                }
            });
        });
    </script>
@endpush
