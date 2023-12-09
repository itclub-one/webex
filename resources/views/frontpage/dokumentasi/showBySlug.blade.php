@extends('frontpage.layouts.main')

@section('content')
<section data-anim="fade" class="breadcrumbs">
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
              <a href="{{route('web.dokumentasi.showByEskul',$data->eskul->slug)}}">{{$data->eskul->nama}}</a>
            </div>

            <div class="breadcrumbs__item ">
              <a style="pointer-events: none; cursor: default;">{{$data->nama_kegiatan}}</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="layout-pt-md layout-pb-lg">
    <div data-anim="slide-up delay-2" class="container">

      <div class="row y-gap-30">

        <div class="col-xl-12 col-lg-12 col-md-6">
          <a  class="coursesCard -type-1 texttt">
            <div class="relative">
              <div class="coursesCard__image overflow-hidden rounded-8">
                <img class="w-1/1" src="{{img_src($data->img_url, 'dokumentasi')}}" alt="{{$data->nama_kegiatan}}">
                {{-- <div class="coursesCard__image_overlay rounded-8"></div> --}}
              </div>
              <div class="d-flex justify-between py-10 px-10 absolute-full-center z-3">
              </div>
            </div>
            <div class="h-100 pt-15">
              <div class="text-20 lh-15 fw-600 text-dark-1 mt-10">{{$data->nama_kegiatan}}</div>
              <div class="d-flex x-gap-10 items-center pt-10">
                <div class="d-flex items-center">
                  <div class="text-14 lh-1">{!! $data->caption !!}</div>
                </div>
              </div>
              <div class="coursesCard-footer">
                <div class="coursesCard-footer__author">
                  <img src="{{img_src($data->eskul->eskul_detail->logo,'eskul')}}" alt="{{$data->eskul->nama}}">
                  <div>{{$data->eskul->nama}}</div>
                </div>
              </div>
            </div>
          </a>
        </div>

        
      </div>

      

      
    </div>
  </section>
@endsection