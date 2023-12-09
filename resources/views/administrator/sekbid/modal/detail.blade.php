<!-- Modal Detail Sekbid -->
<div class="modal fade" tabindex="-1" role="dialog" id="detailSekbid" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailSekbidLabel">Detail Sekbid</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailSekbidBody">

            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#detailSekbid').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modalBody = $('#detailSekbidBody');
            modalBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.sekbid.getDetail', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    var data = response.data;
                    console.log(data);
                    var eskul = data.eskul;
                    var no = 1;

                    var tableHtmlSekbid =
                        '<table id="table-sekbid" class="compact table table-bordered" width="100%">' +
                        '<thead>' +
                        '<tr>' +
                        '<th style="width:25px">No</th>' +
                        '<th>Ekstrakurikuler</th>' +
                        '</tr></thead><tbody>';


                    for (var i = 0; i < eskul.length; i++) { // Ubah "<=" menjadi "<"
                        ekstrakurikuler = eskul[i];
                        tableHtmlSekbid += '<tr class="eskul-list">' +
                            '<td>' + no++ + '</td>' +
                            '<td>' + ekstrakurikuler.nama + '</td>' +
                            '</tr>'; // Tambahkan penutup tag </tr>
                    }

                    tableHtmlSekbid += '</tbody></table>';


                    modalBody.html(
                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">ID</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.id + '</div>' +
                        '</div>' +
                        '</div>' +
                        
                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Sekbid</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.tingkat + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<p><strong>Ekstrakurikuler:</strong></p>' + (eskul.length != 0 ?
                            tableHtmlSekbid :
                            'Tidak memiliki Ekstrakurikuler')
                    );

                    loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                }
            });

        });
    </script>
@endpush
