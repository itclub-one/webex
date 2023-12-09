<div class="row y-gap-30">
    @foreach ($dokumentasiByEskul as $row)
        <div class="col-xl-3 col-lg-4 col-md-6 col-6">
            <a href="/dokumentasi/{{ $row->slug }}" class="coursesCard -type-1 texttt">
                <div class="relative">
                    <div class="coursesCard__image overflow-hidden rounded-8">
                        <img class="w-1/1"
                            src="{{ img_src($row->img_url,'dokumentasi') }}"
                            alt="{{ $row->nama_kegiatan }}">
                        <div class="coursesCard__image_overlay rounded-8"></div>
                    </div>
                    <div class="d-flex justify-between py-10 px-10 absolute-full-center z-3">
                    </div>
                </div>
                <div class="h-100 pt-15">
                    <div class="text-17 lh-15 fw-500 text-dark-1 mt-10">{{ $row->nama_kegiatan }}</div>
                    <div class="d-flex x-gap-10 items-center pt-10">
                        <div class="d-flex items-center">
                            <div class="text-14 lh-1">{{ Str::limit(strip_tags($row->caption), 100) }}</div>
                        </div>
                    </div>
                    <div class="coursesCard-footer">
                        <div class="coursesCard-footer__author">
                            <img src="{{ img_src($row->eskul->eskul_detail->logo_url,'eskul') }}" alt="">
                            <div>{{ $row->eskul->nama }}</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach

</div>

<div class="row">
    {{$dokumentasiByEskul->links('frontpage.layouts.pagination.index')}}
</div>