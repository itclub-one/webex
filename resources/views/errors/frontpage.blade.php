@extends('frontpage.layouts.main')

@section('content')
    <section class="page-header -type-1">
        <div class="container">
            <div class="page-header__content">
                <div class="row justify-center text-center">
                    <div class="col-auto">

                        <div id="error">

                            <div class="error-page container">
                                <div class="col-md-8 col-12 offset-md-2">
                                    <div class="text-center">
                                        <img class="img-error" width="50%"
                                            src="{{ asset('images/default/error-500.svg') }}"
                                            alt="Not Found">
                                        <h1 class="error-title mt-5">@yield('code') @yield('title')</h1>
                                        <p class="fs-5 text-gray-600 mt-2">@yield('message').</p>
                                        <a href="{{ route('admin.users') }}"
                                            class="btn btn-lg btn-outline-primary mt-3 d-none">Go
                                            Home</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
