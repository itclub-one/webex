
        @foreach ($sekbid as $row)
            @if ($row->tingkat == 0)
                <div class="explore__item">
                    @foreach ($row->eskul as $eskul)
                        <a class="text-dark-1"
                            href="{{ route('web.ekstrakurikuler.showBySlug', $eskul->slug) }}">{{ $eskul->nama }}</a>
                    @endforeach
                </div>
            @endif  
        @endforeach

        @foreach ($sekbid as $row)
            @if ($row->tingkat != 0)
                <div class="explore__item">
                    <a href="#" class="d-flex items-center justify-between text-dark-1">
                        Sekbid {{ $row->tingkat }}<div class="icon-chevron-right text-11"></div>
                    </a>
                    <div class="explore__subnav rounded-8">
                        @foreach ($row->eskul as $eskul)
                            <a class="text-dark-1"
                                href="{{ route('web.ekstrakurikuler.showBySlug', $eskul->slug) }}">{{ $eskul->nama }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
