@extends('frontpage.layouts.main')

@section('content')
<section data-anim="fade" class="breadcrumbs ">
    <div class="container">
      <div class="row">
        <div class="col-auto">
          <div class="breadcrumbs__content">

            <div class="breadcrumbs__item ">
              <a href="{{route('web')}}">Home</a>
            </div>

            <div class="breadcrumbs__item ">
              <a href="{{route('web.dokumentasi')}}">Dokumentasi</a>
            </div>

            <div class="breadcrumbs__item ">
              <a style="pointer-events: none; cursor: default;">{{$data_eskul->nama}}</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="page-header -type-1">
    <div class="container">
      <div class="page-header__content">
        <div class="row">
          <div class="col-auto">
            <div data-anim="slide-up delay-1">

              <h1 class="page-header__title">Dokumentasi {{$data_eskul->nama}}</h1>

            </div>

            <div data-anim="slide-up delay-2">

              <p class="page-header__text">Semua dokumentasi dari {{$data_eskul->nama}} ada disini.</p>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="layout-pt-md layout-pb-lg">
    <div class="container" id="dokumentasiData">

      <div class="row y-gap-30">
        @foreach ($data as $row)
            <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                <a href="{{route('web.dokumentasi.showByEskulAndSlug',['eskul'=>$row->eskul->slug,'slug'=>$row->slug])}}" class="coursesCard -type-1 texttt">
                    <div class="relative">
                        <div class="coursesCard__image overflow-hidden rounded-8">
                            <img class="w-1/1" style="width: 300px;"
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
        {{$data->links('frontpage.layouts.pagination.index')}}
    </div>

      
    </div>
  </section>
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page) {
            $.ajax({
                url: "{{ route('web.dokumentasi.fetchData') }}?page=" + page,
                success: function(data) {
                    $('#dokumentasiData').html(data);
                },
            });
        }
    });
</script>
@endpush