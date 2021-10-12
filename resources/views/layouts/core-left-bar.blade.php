<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul>
                <!-- Dashboard -->
                <li class="{{ \App\Helpers\MenuHelper::checkRoutePermissions(['dashboards']) }}">
                    <a href="{{ route('dashboards.index') }}" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span> Dashboard </span></a>
                </li>

                <!-- Master Data -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi  mdi-database"></i><span> Master Data</span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('banks.index') }}">Bank</a></li>
                        <li><a href="{{ route('holidays.index') }}">Hari Libur</a></li>
                        <li><a href="{{ route('contacts.index') }}">Kontak</a></li>
                        <li><a href="{{ route('provinces.index') }}">Provinsi</a></li>
                        <li><a href="{{ route('regencies.index') }}">Kabupaten / Kota</a></li>
                        <li><a href="{{ route('districts.index') }}">Kecamatan</a></li>
                        <li><a href="{{ route('villages.index') }}">Kelurahan</a></li>
                        <li><a href="{{ route('industries.index') }}">Jenis Industri</a></li>
                        <li><a href="{{ route('annual_types.index') }}">Jenis Cuti</a></li>
                        <li><a href="{{ route('identity_types.index') }}">Jenis Identitas</a></li>
                        <li><a href="{{ route('jobs.index') }}">Jenis Profesi</a></li>
                        <li><a href="{{ route('specializations.index') }}">Jenis Keahlian</a></li>
                        <li><a href="{{ route('attachment_types.index') }}">Jenis Lampiran</a></li>
                        <li><a href="{{ route('allowance_types.index') }}">Jenis Tunjangan</a></li>
                        <li><a href="{{ route('loss_types.index') }}">Jenis Potongan</a></li>
                        <li><a href="{{ route('employee_types.index') }}">Jenis Pegawai</a></li>
                        <li><a href="{{ route('marital_status.index') }}">Status Pernikahan</a></li>
                    </ul>
                </li>

                <!-- Kepegawaian -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple"></i><span> Kepegawaian</span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('workers.index') }}">Data Pegawai</a></li>
                        <li><a href="{{ route('employee_allowances.index') }}">Data Tunjangan</a></li>
                        <li><a href="{{ route('employee_cuts.index') }}">Data Potongan</a></li>
                        <li><a href="{{ route('employee_mutations.index') }}">Data Mutasi</a></li>
                        <li><a href="{{ route('employee_promotions.index') }}">Data Promosi</a></li>
                        <li><a href="{{ route('employee_retireds.index') }}">Data Pensiun</a></li>
                    </ul>
                </li>

                <!-- Organisasi -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class=" mdi mdi-sitemap"></i><span> Organisasi</span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('divisions.index') }}">Divisi</a></li>
                        <li><a href="{{ route('positions.index') }}">Posisi</a></li>
                    </ul>
                </li>

                <!-- Permohonan -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-calendar-multiple-check"></i><span> Permohonan</span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('employee_absences.current', ['month'=>(int) date('m'), 'year'=> (int) date('Y')]) }}"> Absensi</a></li>
                        <li><a href="{{ route('employee_annuals.index') }}">Cuti</a></li>
                        <li><a href="{{ route('employee_travels.index') }}"> Dinas</a></li>
                        <li><a href="{{ route('employee_over_times.index') }}"> Lembur</a></li>
                        <li><a href="{{ route('employee_loans.index') }}">Pinjaman</a></li>
                    </ul>
                </li>

                <!-- Perekrutan -->
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-star"></i><span> Perekrutan</span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('vacancies.index') }}">Lowongan</a></li>
                        <li><a href="{{ route('candidates.index') }}">Kandidat</a></li>
                        <li><a href="{{ route('acceptances.index') }}">Penerimaan</a></li>
                    </ul>
                </li>

                <!-- Penggajian -->
                <li class="">
                    <a href="{{ route('payrolls.current', ['month'=>(int) date('m'), 'year'=> (int) date('Y')]) }}" class="waves-effect"><i class="mdi mdi-cash-multiple"></i><span> Penggajian </span></a>
                </li>

                <!-- Laporan -->
                <li class="">
                    <a href="{{ route('reports.index') }}" class="waves-effect"><i class="mdi mdi-chart-bar"></i><span> Laporan </span></a>
                </li>


                <!-- Pengaturan -->
                <li class="has_sub {{ \App\Helpers\MenuHelper::checkRoutePermissions(['audits','roles','users','companies']) }}">
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-settings"></i><span> Pengaturan</span> <span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('accounts.index') }}">Akun Pengguna</a></li>
                        <li class="{{ \App\Helpers\MenuHelper::checkRoutePermissions(['audits']) }}"><a href="{{ route('audits.index') }}">Audit Trail</a></li>
                        <li class="{{ \App\Helpers\MenuHelper::checkRoutePermissions(['roles']) }}"><a href="{{ route('roles.index') }}">Manajemen Akses</a></li>
                        <li class="{{ \App\Helpers\MenuHelper::checkRoutePermissions(['users']) }}"><a href="{{ route('users.index') }}">Manajemen Pengguna</a></li>
                        <li><a href="{{ route('notifications.index') }}">Pemberitahuan</a></li>
                        <li><a href="{{ route('profiles.index') }}">Profil Pengguna</a></li>
                        <li class="{{ \App\Helpers\MenuHelper::checkRoutePermissions(['companies']) }}"><a href="{{ route('companies.index') }}">Profil Perusahaan</a></li>
                    </ul>
                </li>

                <li class="">
                    <a href="{{ route('logout') }}" class="waves-effect btn-logout"><i class="mdi mdi-exit-to-app"></i><span> Log Out </span></a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
       

    </div>
    <!-- Sidebar -left -->

</div>