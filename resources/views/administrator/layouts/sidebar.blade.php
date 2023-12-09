<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">{{ array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : '' }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">
                <?php
                $namaText = array_key_exists('nama_app_admin', $settings) ? $settings['nama_app_admin'] : '';
                $twoInitialChars = strtoupper(substr($namaText, 0, 2));
                echo $twoInitialChars;
                ?>
            </a>
        </div>
        @php
            $permissions = getPermissionModuleGroup();
        @endphp
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Route::is('admin.dashboard*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i
                        class="fas fa-columns"></i><span>Dashboard</span></a></li>

            <li class="menu-header">Menu</li>

            @if (showModule('jadwal', $permissions) ||
                    showModule('sekbid', $permissions) ||
                    showModule('kelas', $permissions) ||
                    showModule('jurusan', $permissions))
                <li
                    class="dropdown {{ Route::is('admin.jadwal*', 'admin.sekbid*', 'admin.kelas*', 'admin.jurusan*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-database"></i>
                        <span>Data Master</span></a>
                    <ul class="dropdown-menu">
                        @if (showModule('jadwal', $permissions))
                            <li class="{{ Route::is('admin.jadwal*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.jadwal') }}">Jadwal</a></li>
                        @endif
                        @if (showModule('sekbid', $permissions))
                            <li class="{{ Route::is('admin.sekbid*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.sekbid') }}">Sekbid</a></li>
                        @endif
                        @if (showModule('kelas', $permissions))
                            <li class="{{ Route::is('admin.kelas*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.kelas') }}">Kelas</a></li>
                        @endif
                        @if (showModule('jurusan', $permissions))
                            <li class="{{ Route::is('admin.jurusan*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.jurusan') }}">Jurusan</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (showModule('eskul', $permissions))
                <li class="{{ Route::is('admin.eskul*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('admin.eskul') }}"><i class="fas fa-flag"></i> <span>Ekstrakurikuler</span></a>
                </li>
            @endif

            @if (showModule('anggota', $permissions))
                <li class="{{ Route::is('admin.anggota*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('admin.anggota') }}"><i class="fas fa-users"></i> <span>Anggota</span></a></li>
            @endif

            @if (showModule('pendaftaran', $permissions))
                <li class="{{ Route::is('admin.pendaftaran*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('admin.pendaftaran') }}"><i class="fas fa-file-contract"></i>
                        <span>Pendaftaran</span></a></li>
            @endif

            @if (showModule('dokumentasi', $permissions))
                <li class="{{ Route::is('admin.dokumentasi*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('admin.dokumentasi') }}"><i class="far fa-images"></i>
                        <span>Dokumentasi</span></a>
                </li>
            @endif

            @if (showModule('berita', $permissions))
                <li class="{{ Route::is('admin.berita*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('admin.berita') }}"><i class="far fa-newspaper"></i> <span>Berita</span></a>
                </li>
            @endif

            @if (showModule('user_group', $permissions) || showModule('user', $permissions))
                <li class="dropdown {{ Route::is('admin.users*', 'admin.user_groups*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-users-cog"></i>
                        <span>User Management</span></a>
                    <ul class="dropdown-menu">
                        @if (showModule('user_group', $permissions))
                            <li class="{{ Route::is('admin.user_groups*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.user_groups') }}">User Group</a></li>
                        @endif
                        @if (showModule('user', $permissions))
                            <li class="{{ Route::is('admin.users*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.users') }}">User</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (showModule('log_system', $permissions))
                <li class="dropdown {{ Route::is('admin.logSystems*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-bezier-curve"></i>
                        <span>Systems</span></a>
                    <ul class="dropdown-menu">
                        @if (showModule('log_system', $permissions))
                            <li class="{{ Route::is('admin.logSystems*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.logSystems') }}">Logs</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (showModule('profile', $permissions))
                <li class="{{ Route::is('admin.profile*') ? 'active' : '' }}"><a class="nav-link"
                        href="{{ route('admin.profile', auth()->user()->kode) }}"><i class="fas fa-solid fa-user"></i>
                        <span>Profile</span></a></li>
            @endif

            @if (showModule('setting', $permissions) ||
                    showModule('setting_kepala_sekolah', $permissions) ||
                    showModule('setting_wakil_kepala_sekolah', $permissions) ||
                    showModule('setting_pendaftaran', $permissions) ||
                    showModule('module_management', $permissions))
                <li
                    class="dropdown {{ Route::is('admin.settings*', 'admin.module*', 'admin.kepala_sekolah*', 'admin.wakil_kepala_sekolah*', 'admin.settingPendaftaran*') ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-cogs"></i>
                        <span>Settings</span></a>
                    <ul class="dropdown-menu">
                        @if (showModule('setting', $permissions))
                            <li class="{{ Route::is('admin.settings*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.settings') }}">Setting General</a></li>
                        @endif
                        @if (showModule('setting_kepala_sekolah', $permissions))
                            <li class="{{ Route::is('admin.kepala_sekolah*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.kepala_sekolah') }}">Setting KepSek</a></li>
                        @endif
                        @if (showModule('setting_wakil_kepala_sekolah', $permissions))
                            <li class="{{ Route::is('admin.wakil_kepala_sekolah*') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('admin.wakil_kepala_sekolah') }}">Setting
                                    WaKaSek</a></li>
                        @endif
                        @if (showModule('setting_pendaftaran', $permissions))
                            <li class="{{ Route::is('admin.settingPendaftaran*') ? 'active' : '' }}"><a
                                    class="nav-link" href="{{ route('admin.settingPendaftaran') }}">Setting
                                    Pendaftaran</a></li>
                        @endif
                        @if (showModule('module_management', $permissions) && (auth()->user()->kode == 'dev_daysf'))
                            <li class="{{ Route::is('admin.module*') ? 'active' : '' }}"><a class="nav-link"
                                    href="{{ route('admin.module') }}">Module Management</a></li>
                        @endif
                    </ul>
                </li>
            @endif

        </ul>
    </aside>
</div>
