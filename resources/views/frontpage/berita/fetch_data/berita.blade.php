<div class="tabs -pills js-tabs">

    <div class="tabs__content pt-40 js-tabs-content">

        <div class="tabs__pane -tab-item-1 is-active">
            <div class="row y-gap-30">

                @foreach ($data as $row)
                    <div class="col-lg-4 col-md-6 col-6">
                        <a href="{{ route('web.berita.showByEskulAndSlug', ['eskul' => $row->eskul->slug, 'slug' => $row->slug]) }}"
                            class="blogCard -type-1 texttt">
                            <div class="blogCard__image">
                                <img class="w-1/1 rounded-8" src="{{ img_src($row->img_url, 'berita') }}"
                                    alt="{{ $row->judul }}">
                            </div>
                            <div class="blogCard__content mt-20">
                                <h4 class="blogCard__title text-20 lh-15 fw-500 mt-5">
                                    {{ \Illuminate\Support\Str::limit($row->judul, 50) }}</h4>
                                <p class="blogCard__subtitle text-16">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($row->content), 100) }}
                                </p> <!-- Tambahkan kode untuk menampilkan sub judul -->
                                <div class="blogCard__author text-14">
                                    <img class="rounded-8" width="20px"
                                        src="{{ img_src($row->eskul->eskul_detail->logo_url, 'eskul') }}"
                                        alt="">
                                    {{ $row->eskul->nama }}
                                </div>
                                <div class="blogCard__date text-14 mt-2">
                                    {{ \Carbon\Carbon::parse($row->created_at)->format('F d, Y') }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach

                <div class="row">
                    {{ $data->links('frontpage.layouts.pagination.index') }}
                </div>
            </div>

        </div>
    </div>
</div>