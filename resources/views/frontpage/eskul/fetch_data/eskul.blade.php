<div class="row y-gap-30">
    @foreach ($data as $row)
        <div class="col-xl-3 col-lg-4 col-md-6 col-6">
            <a class="" href="{{route('web.ekstrakurikuler.showBySlug',$row->slug)}}">
                <div class="infoCard -type-1">
                    <div class="infoCard__image">
                        <img style="width: 100px; height: 99px;" src="{{img_src($row->eskul_detail->logo_url,'eskul')}}" alt="{{$row->nama}}">
                    </div>
                    <h5 class="infoCard__title text-17 lh-15 mt-10">{{$row->nama}}</h5>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row">
    {{$data->links('frontpage.layouts.pagination.index')}}
</div>