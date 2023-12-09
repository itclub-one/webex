<!-- Modal Detail Berita -->
<div class="modal fade" tabindex="-1" role="dialog" id="detailBerita" data-backdrop="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailBeritaLabel">Detail Berita</h5>
                <button type="button" class="close" id="buttonCloseModuleModal" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailBeritaBody">

            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('#detailBerita').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            var modalBody = $('#detailBeritaBody');
            modalBody.html('<div id="loadingSpinner" style="display: none;">' +
                '<i class="fas fa-spinner fa-spin"></i> Sedang memuat...' +
                '</div>');
            var loadingSpinner = $('#loadingSpinner');

            loadingSpinner.show(); // Tampilkan elemen animasi

            $.ajax({
                url: '{{ route('admin.berita.getDetail', ':id') }}'.replace(':id', id),
                method: 'GET',
                success: function(response) {
                    var data = response.data;
                    // Mendapatkan URL logo menggunakan JavaScript
                    var imgUrl = "{{ asset_berita('') }}/" + data.img_url;

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
                        '<div class="title">Judul</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.judul + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Author</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.author + '</div>' +
                        '</div>' +
                        '</div>' +

                        '<div class="row">' +
                        '<div class="col-5">' +
                        '<div class="title">Ekstrakurikuler</div>' +
                        '</div>' +
                        '<div class="col-7">' +
                        '<div class="data">: ' + data.eskul.nama + '</div>' +
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

                        '<div class="row mt-4">' +
                        '<div class="col-12">' +
                        '<div class="title"><strong>Content</strong> :</div>' +
                        '</div>' +
                        '<div class="col-12">' + data.content + '</div>' +
                        '</div>' +

                        '<div class="row mt-4">' +
                        '<div class="col-12">' +
                        '<div class="title">Image :</div>' +
                        '</div>' +

                        '<div class="col-12 text-center"></br><img src="' + imgUrl +
                        '" alt="Masukan Image" width="200">' + '</div>' +
                        '</div>'


                    );


                    loadingSpinner.hide(); // Sembunyikan elemen animasi setelah data dimuat
                }
            });
        });
    </script>
@endpush
