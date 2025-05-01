<!--begin::Header-->
<div id="kt_app_header" class="app-header">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::sidebar mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <!--end::sidebar mobile toggle-->

        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="/" class="d-lg-none">
                <img alt="Logo" src="/assets/media/logos/default-small.svg" class="h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->

        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <!--begin::Menu wrapper-->
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
            </div>
            <!--end::Menu wrapper-->

            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="click"
                        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <div class="symbol-label fs-3 bg-light-primary text-primary">
                            <?php echo isset($_SESSION['email']) ? strtoupper(substr($_SESSION['email'], 0, 1)) : 'G'; ?>
                        </div>
                    </div>

                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-semibold py-4 fs-6 w-275px"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <div class="symbol symbol-50px me-5">
                                    <div class="symbol-label fs-3 bg-light-primary text-primary">
                                        <?php echo isset($_SESSION['email']) ? strtoupper(substr($_SESSION['email'], 0, 1)) : 'G'; ?>
                                    </div>
                                </div>

                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Misafir'; ?>
                                    </div>
                                    <span class="badge badge-light-success fw-bold fs-8 py-1 mt-2">Online</span>
                                </div>
                            </div>
                        </div>

                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="/profile" class="menu-link px-5">
                                <span class="menu-icon me-2">
                                    <i class="ki-duotone ki-profile-circle fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Profilim</span>
                            </a>
                        </div>
                        <!--end::Menu item-->

                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <form action="/auth/signout" method="POST" id="logout-form">
                                <button type="submit" class="menu-link px-5 w-100"
                                    style="border:none; background: none;">
                                    <span class="menu-icon me-2">
                                        <i class="ki-duotone ki-logout fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <span class="menu-title">Çıkış Yap</span>
                                </button>
                            </form>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::User account menu-->
                </div>
                <!--end::User menu-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
<!--end::Header-->