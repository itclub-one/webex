<!-- Modal Detail Ekstrakurikuler -->
<div class="modal fade" tabindex="-1" role="dialog" id="detailEskul" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailEskulLabel">Detail Ekstrakurikuler</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailEskulBody">

            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#detailEskul').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modalBody = $('#detailEskulBody');
            modalBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.eskul.getDetail', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    var data = response.data;
                    var jadwal_kumpulan = response.jadwal_kumpulan;
                    console.log(jadwal_kumpulan);
                    var sosmed = JSON.parse(data.eskul_detail.sosial_media);
                    // Mendapatkan URL logo menggunakan JavaScript
                    var logoUrl = "{{ asset_eskul('') }}/" + data.eskul_detail.logo_url;


                    var jadwal_html = '';
                    jadwal_html += '</br><div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Jadwal Kumpulan</div>' +
                        '</div>' +
                        '<div class="col-7">';

                    for (let i = 0; i < jadwal_kumpulan.length; i++) {
                        var jadwal = jadwal_kumpulan[i];
                        var jadwal_eskul = '<div class="data">: ' + jadwal.jadwal.hari + '</div>';
                        jadwal_html += jadwal_eskul;
                    }

                    jadwal_html += '</div>' +
                        '</div></br>';




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
                        '<div class="title">Nama</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.nama + '</div>' +
                        '</div>' +
                        '</div>' +

                        jadwal_html +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Sekbid</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.sekbid.tingkat + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Slug</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.slug + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Pembina</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.eskul_detail.pembina + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Ketua</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.eskul_detail.ketua + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Wakil Ketua</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.eskul_detail.wakil_ketua + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Instagram</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + sosmed['instagram'] + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row mt-4">' +
                        '<div class="col-12">' +
                        '<div class="title"><strong>Visi</strong> :</div>' +
                        '</div>' +
                        '<div class="col-12">' + data.eskul_detail.visi + '</div>' +
                        '</div>' +

                        '<div class="row mt-4">' +
                        '<div class="col-12">' +
                        '<div class="title"><strong>Misi</strong> :</div>' +
                        '</div>' +
                        '<div class="col-12">' + data.eskul_detail.misi + '</div>' +
                        '</div>' +

                        '<div class="row mt-4">' +
                        '<div class="col-12">' +
                        '<div class="title"><strong>Program Kerja</strong> :</div>' +
                        '</div>' +
                        '<div class="col-12">' + data.eskul_detail.program_kerja + '</div>' +
                        '</div>' +

                        '<div class="row mt-4">' +
                        '<div class="col-12">' +
                        '<div class="title">Logo :</div>' +
                        '</div>' +

                        '<div class="col-12 text-center"></br><img src="' + logoUrl +
                        '" alt="Masukan Logo" width="200">' + '</div>' +
                        '</div>'


                    );


                    loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                }
            });
        });
    </script>
@endpush
