<!-- Sidebar Header -->
<div class="flex flex-col gap-2.5" id="sidebar_header">
    <div class="flex items-center gap-2.5 px-3.5 h-[70px]">
        <img class="size-[34px]" src="{{ versioned_assets(config('theme.logo')) }}"/>

        <div class="menu menu-default grow" data-menu="true">
            <div class="menu-item grow" data-menu-item-offset="0, 15px" data-menu-item-placement="bottom-start" data-menu-item-toggle="dropdown" data-menu-item-trigger="hover">
                <div class="menu-label cursor-pointer text-gray-900 font-medium grow justify-between">
                  <span class="text-lg font-medium text-inverse grow">
                   {{ config('theme.title') }}
                  </span>
                   <div class="flex flex-col text-gray-900 font-medium">
                       <span class="menu-arrow">
                            <i class="ki-filled ki-up">
                            </i>
                       </span>
                       <span class="menu-arrow">
                            <i class="ki-filled ki-down"></i>
                       </span>
                   </div>
                </div>
                <div class="menu-dropdown w-48 py-2">
                    <div class="menu-item">
                        <a class="menu-link" href="html/demo10/public-profile/profiles/default.html" tabindex="0">
                            <span class="menu-icon">
                                 <i class="ki-filled ki-profile-circle"></i>
                            </span>
                            <span class="menu-title">
                             Public Profile
                            </span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="html/demo10.html" tabindex="0">
                        <span class="menu-icon">
                         <i class="ki-filled ki-setting-2"></i>
                        </span>
                            <span class="menu-title">
                                Account
                            </span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="html/demo10/network/get-started.html" tabindex="0">
                            <span class="menu-icon">
                             <i class="ki-filled ki-users"></i>
                            </span>
                            <span class="menu-title">
                                 Network
                            </span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="html/demo10/authentication/get-started.html" tabindex="0">
                            <span class="menu-icon">
                             <i class="ki-filled ki-security-user"></i>
                            </span>
                            <span class="menu-title">
                                Authentication
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="flex items-center gap-2.5 px-3.5">
        <!-- Input -->
        <a class="btn btn-dark btn-sm justify-center min-w-[198px]" href="html/demo10/public-profile/projects/3-columns.html">
            <i class="ki-filled ki-plus">
            </i>
            Add New
        </a>
        <!-- End of Input -->
        <button class="btn btn-icon btn-dark btn-icon-lg size-8 hover:text-primary" data-modal-toggle="#search_modal">
            <i class="ki-filled ki-magnifier">
            </i>
        </button>
    </div>--}}
</div>
<!-- End of Sidebar Header -->
