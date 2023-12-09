<header data-anim="{{--fade--}}" data-add-bg="" class="header -type-4 -shadow bg-white border-bottom-light js-header">

    <div class="header__container py-10">
        <div class="row justify-between items-center">

            <div class="col-auto">
                <div class="header-left d-flex items-center">

                    <div class="header__logo">
                        <a>
                            <img style="width: 50px;" src="{{ array_key_exists('logo_app_admin', $settings) ? img_src($settings['logo_app_admin'], 'settings') : '' }}" alt="logo">
                        </a>
                    </div>

                    <div class="header__explore px-30 xl:px-20 -before-border -after-border xl:d-none">
                        <a href="#" class="d-flex  items-center" data-el-toggle=".js-explore-toggle">
                            <i class="icon icon-explore mr-15"></i>
                            Jelajahi
                        </a>

                        <div class="explore-content py-25 rounded-8 bg-white toggle-element js-explore-toggle">

                            @include('frontpage.layouts.header_explore')

                        </div>
                    </div>

                    <div class="header-menu js-mobile-menu-toggle pl-30 xl:pl-20">
                        <div class="header-menu__content">
                            <div class="mobile-bg js-mobile-bg"></div>

                            <div class="menu js-navList">
                                <ul class="menu__nav text-dark-1 -is-active">
                                    <li class="{{ Route::is('web') ? 'active' : '' }}">
                                        <a data-barba class="" href="{{route('web')}}">Home</a>
                                    </li>

                                    <li
                                        class="menu-item-has-children dropdown {{ Route::is('web.kepalaSekolah*' || 'web.wakilKepalaSekolah*') ? 'active' : '' }}">
                                        <a data-barba href="#">Sambutan <i
                                                class="icon-chevron-right dropdown-toggle text-13 ml-10"></i></a>
                                        <ul class="subnav dropdown-menu martoppp">

                                            <li class="{{ Route::is('web.kepalaSekolah*') ? 'active' : '' }}"><a
                                                    class=" dropdown-item" href="{{route('web.kepalaSekolah')}}">Sambutan Kepala
                                                    Sekolah</a></li>

                                            <li class="{{ Route::is('web.wakilKepalaSekolah*') ? 'active' : '' }}"><a
                                                    class=" dropdown-item" href="{{route('web.wakilKepalaSekolah')}}">Sambutan Wakasek
                                                    Bidang Kesiswaan</a></li>

                                        </ul>
                                    </li>

                                    <li class="{{ Route::is('web.sejarahVisiMisi*') ? 'active' : '' }}"><a
                                            class=" dropdown-item" href="{{route('web.sejarahVisiMisi')}}">Sejarah, Visi, dan Misi</a>
                                    </li>

                                    <li class="{{ Route::is('web.dokumentasi*') ? 'active' : '' }}">
                                        <a class="" data-barba href="{{route('web.dokumentasi')}}">Dokumentasi</a>
                                    </li>

                                    <li class="{{ Route::is('web.berita*') ? 'active' : '' }}">
                                        <a class="" data-barba href="{{route('web.berita')}}">Berita</a>
                                    </li>

                                    <li class="{{ Route::is('web.tentangWeb*') ? 'active' : '' }}"><a
                                            class=" dropdown-item" href="{{route('web.tentangWeb')}}">Tentang Web</a></li>

                                    <li class="{{ Route::is('web.pendaftaran*') ? 'active' : '' }}"><a
                                            class=" dropdown-item" href="{{route('web.pendaftaran')}}">Pendaftaran</a></li>

                                    <li class="{{ Route::is('admin.login*') ? 'active' : '' }}"><a class=" dropdown-item"
                                            href="{{route('admin.login')}}">Login</a></li>
                                </ul>
                            </div>

                            <div class="mobile-footer px-20 py-20 border-top-light js-mobile-footer">
                                <div class="mobile-footer__number">
                                    <div class="text-17 fw-500 text-dark-1">Hubungi Kami</div>
                                    <div class="text-17 fw-500 text-purple-1">(0262) 233316</div>
                                </div>

                                <div class="lh-2 mt-10">
                                    <div>JALAN CIMANUK NO 309 A,<br> Kecamatan Tarogong Kidul <br> Kabupaten Garut <br>
                                        Provinsi
                                        Jawa Barat.</div>
                                    <div>smknegeri1garut@ymail.com</div>
                                </div>

                                <div class="mobile-socials mt-10">

                                    <a href="https://www.facebook.com/SmkNegeri1Garut"
                                        class="d-flex items-center justify-center rounded-full size-40">
                                        <i class="fa fa-facebook"></i>
                                    </a>

                                    <a href="https://twitter.com/smkn1garut"
                                        class="d-flex items-center justify-center rounded-full size-40">
                                        <i class="fa fa-twitter"></i>
                                    </a>

                                    <a href="https://www.instagram.com/official_smkn1garut/?igshid=ezu05n0c45lv"
                                        class="d-flex items-center justify-center rounded-full size-40">
                                        <i class="fa fa-instagram"></i>
                                    </a>

                                    <a href="https://www.linkedin.com/company/smk-negeri-1-garut"
                                        class="d-flex items-center justify-center rounded-full size-40">
                                        <i class="fa fa-linkedin"></i>
                                    </a>

                                </div>
                            </div>
                        </div>

                        <div class="header-menu-close" data-el-toggle=".js-mobile-menu-toggle">
                            <div class="size-40 d-flex items-center justify-center rounded-full bg-white">
                                <div class="icon-close text-dark-1 text-16"></div>
                            </div>
                        </div>

                        <div class="header-menu-bg"></div>
                    </div>

                </div>
            </div>

            <div class="col-auto">
                <div class="header-right d-flex items-center">
                    <div class="header-right__icons text-white d-flex items-center ">

                        <div class="relative -before-border px-20 sm:px-15">

                            <div class="xl:d-block -before-border pl-20 sm:pl-15">
                                <button class="text-dark-1 items-center" data-el-toggle=".js-mobile-menu-toggle">
                                    <i class="text-11 icon icon-mobile-menu"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
