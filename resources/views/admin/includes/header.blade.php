<style>
    .extra-menu {
        min-width: 500px
    }

    @media (min-width:320px) and (max-width:767px) {
        .extra-menu {
            min-width: auto
        }
    }

    .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
    }
</style>
<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand wmin-0 mr-5">

        @can("dashboard_view")
        <a href="{{ route('admin.dashboard') }}" class="d-inline-block">
            <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/images/dashboard-logo.png"
                alt="Dashboard">
        </a>
        @else
        @role("Store Owner")
        @else
        <a href="{{ route('admin.manager') }}" class="d-inline-block">
            <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/images/dashboard-logo.png"
                alt="Dashboard">
        </a>
        @endrole
        @endcan

        @role("Store Owner")
        <a href="{{ route('restaurant.dashboard') }}" class="d-inline-block">
            <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/images/dashboard-logo.png"
                alt="Dashboard">
        </a>
        @endrole
    </div>
    <div class="d-md-none">
        <button class="navbar-toggler dropdown-toggle" type="button" data-toggle="collapse"
            data-target="#navbar-mobile">
            <span>{{ Auth::user()->name }}</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" id="navbar-mobile">
            @role("Store Owner")
            <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">
                <span><i class="icon-earth"></i></span>
            </a>
            <div class="dropdown-menu">
                @foreach($translationLangs as $lang)
                <a href="{{ url('locale', $lang) }}"
                    class="dropdown-item @if(app()->getLocale() === $lang) active @endif"
                    style="text-transform: uppercase;"> {{ $lang }}</a>
                @endforeach
            </div>
            <a href="{{ route('restaurant.zenMode', "true") }}" class="dropdown-item"><i
                    class="icon-power3"></i>{{ __('storeDashboard.zenMode') }}</a>
            @endrole
            <a href="{{ route('logout') }}" class="dropdown-item"><i class="icon-switch2"></i>
                {{ __('storeDashboard.navLogout') }}</a>
        </div>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            @role("Store Owner")
            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                    <span><i class="icon-earth mx-2"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach($translationLangs as $lang)
                    <a href="{{ url('locale', $lang) }}"
                        class="dropdown-item @if(app()->getLocale() === $lang) active @endif"
                        style="text-transform: uppercase;"> {{ $lang }}</a>
                    @endforeach
                </div>
            </li>
            @endrole

            @role('Admin')
            @if(isset($navZones) && count($navZones) > 0)
            @if(!Request::is('admin/delivery-ratings/*') && !Request::is('admin/store-ratings/*'))
            <li class="nav-item nav-zone-selection">
                <select name="nav_select_zone" class="nav-select-zone">
                    <option value="0" @if(session('selectedZone')=="0" ) selected @endif> All Zones </option>
                    @foreach($navZones as $zone)
                    <option value="{{ $zone->id }}" @if(session()->has('selectedZone') &&
                        session('selectedZone') == $zone->id) selected @endif>{{ $zone->name }}</option>
                    @endforeach
                </select>
            </li>
            <script>
                $('.nav-select-zone').select2();
                $('select[name="nav_select_zone"]').on('change',(event) => {
                    let url = "{{ url('change-zone-scope/') }}/"+event.target.value;
                    //delete datatable filters
                    var savedDatatables = findLocalItems("DataTables_");
                    if (savedDatatables.length > 0) {
                        console.log("Cleaning keys");
                        $.each(savedDatatables, function (indexInArray, valueOfElement) { 
                            localStorage.removeItem(valueOfElement.key);
                        });
                    }
                    setTimeout(() => {
                        window.location.href = url;
                    }, 500);
                });
            </script>
            @endif
            @endif
            @endrole

            @if(Auth::user())
            @if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Store Owner'))
            @if(Auth::user()->zone_id != null)
            <button class="manager-nav-role">{{ Auth::user()->zone->name }}</button>
            @endif
            @endif
            @endif


            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                    <span>{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @role("Store Owner")
                    <a href="{{ route('restaurant.zenMode', "true") }}" class="dropdown-item"><i
                            class="icon-power3"></i>{{ __('storeDashboard.zenMode') }}</a>
                    @endrole

                    <a href="{{ route('logout') }}" class="dropdown-item"><i class="icon-switch2"></i>
                        {{ __('storeDashboard.navLogout') }}</a>
                </div>
            </li>

            @role("Store Owner")
            @impersonating
            <li class="nav-item">
                <a class="navbar-nav-link active" href="{{ route('impersonate.leave') }}"><i
                        class="icon-arrow-left15 mr-1"></i>Go back to Admin</a>
            </li>
            @endImpersonating
            @endrole


        </ul>
    </div>
</div>
<div class="navbar navbar-expand-md navbar-light navbar-sticky">
    <div class="container">
        <div class="text-center d-md-none w-100">
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                data-target="#navbar-navigation">
                <i class="icon-unfold mr-2"></i>
                Navigation
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-navigation">
            <ul class="navbar-nav">

                @can("stores_view")
                <li class="nav-item">
                    <a href="{{ route("admin.restaurants") }}"
                        class="navbar-nav-link {{ Request::is('admin/stores') ? 'active' : '' }}">
                        <i class="icon-store2 mr-2"></i>
                        Stores
                    </a>
                </li>
                @endcan

                @canany(['addon_categories_view', 'addons_view', 'menu_categories_view', 'items_view'])
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)"
                        class="navbar-nav-link dropdown-toggle {{ Request::is('admin/items')  || Request::is('admin/addoncategories') || Request::is('admin/addons') || Request::is('admin/itemcategories') ? 'active' : '' }}"
                        data-toggle="dropdown">
                        <i class="icon-stack-star mr-2"></i>
                        Items & Menu
                    </a>
                    <div class="dropdown-menu">
                        @can("addon_categories_view")
                        <a href="{{ route("admin.addonCategories") }}"
                            class="dropdown-item {{ Request::is('admin/addoncategories') ? 'active' : '' }}">
                            <i class="icon-tree6 mr-2"></i>
                            Addon Categories
                        </a>
                        @endcan

                        @can("addons_view")
                        <a href="{{ route("admin.addons") }}"
                            class="dropdown-item {{ Request::is('admin/addons') ? 'active' : '' }}">
                            <i class="icon-list2 mr-2"></i>
                            Addons
                        </a>
                        @endcan

                        @can("menu_categories_view")
                        <a href="{{ route("admin.itemcategories") }}"
                            class="dropdown-item {{ Request::is('admin/itemcategories') ? 'active' : '' }}">
                            <i class="icon-grid52 mr-2"></i>
                            Menu Categories
                        </a>
                        @endcan

                        @can("items_view")
                        <a href="{{ route("admin.items") }}"
                            class="dropdown-item {{ Request::is('admin/items') ? 'active' : '' }}">
                            <i class="icon-grid mr-2"></i>
                            Items
                        </a>
                        @endcan
                    </div>
                </li>
                @endcanany

                @canany(['all_users_view', 'delivery_guys_view', 'store_owners_view'])
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)"
                        class="navbar-nav-link dropdown-toggle  {{ Request::is('admin/users') || Request::is('admin/manage-delivery-guys') || Request::is('admin/staffs') || Request::is('admin/customers') || Request::is('admin/usemanage-store-owners') ? 'active' : '' }}"
                        data-toggle="dropdown">
                        <i class="icon-users2 mr-2"></i>
                        Users
                    </a>

                    <div class="dropdown-menu">
                        @can('all_users_view')
                        <a href="{{ route("admin.users") }}"
                            class="dropdown-item {{ Request::is('admin/users') ? 'active' : ''}}"> <i
                                class="icon-users4 mr-2"></i> All Users</a>

                        <a href="{{ route("admin.customers") }}"
                            class="dropdown-item {{ Request::is('admin/customers') ? 'active' : ''}}"> <i
                                class="icon-user mr-2"></i> Customers</a>
                        @endcan

                        @can('store_owners_view')
                        <a href="{{ route('admin.manageRestaurantOwners') }}"
                            class="dropdown-item {{ Request::is('admin/manage-store-owners') ? 'active' : ''}}"> <i
                                class="icon-user-tie mr-2"></i> Store Owners</a>
                        @endcan

                        @can('delivery_guys_view')
                        <a href="{{ route('admin.manageDeliveryGuys') }}"
                            class="dropdown-item {{ Request::is('admin/manage-delivery-guys') ? 'active' : ''}}"> <i
                                class="icon-truck mr-2"></i> Delivery Guys</a>
                        @endcan

                        @role('Admin')
                        <a href="{{ route("admin.staffs") }}"
                            class="dropdown-item {{ Request::is('admin/staffs') ? 'active' : ''}}"> <i
                                class="icon-collaboration mr-2"></i> Staff</a>
                        @endrole
                    </div>
                </li>
                @endcanany

                @can('order_view')
                <li class="nav-item">
                    <a href="{{ route("admin.orders") }}"
                        class="navbar-nav-link {{ Request::is('admin/orders') ? 'active' : '' }}">
                        <i class="icon-basket mr-2"></i>
                        Orders
                    </a>
                </li>
                @endcan

                @canany(['promo_sliders_manage', 'store_category_sliders_manage', 'coupons_manage', 'pages_manage',
                'send_notification_manage'])
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)"
                        class="navbar-nav-link dropdown-toggle  {{ Request::is('admin/sliders') || Request::is('admin/coupons') || Request::is('admin/notifications') || Request::is('admin/store-category-slider') || Request::is('admin/pages') ? 'active' : '' }}"
                        data-toggle="dropdown">
                        <i class="icon-percent mr-2"></i>
                        Promotions
                    </a>
                    <div class="dropdown-menu">
                        @can('promo_sliders_manage')
                        <a href="{{ route('admin.sliders') }}"
                            class="dropdown-item {{ Request::is('admin/sliders') ? 'active' : '' }}">
                            <i class="icon-image2 mr-2"></i>
                            Promo Sliders
                        </a>
                        @endcan
                        @can('store_category_sliders_manage')
                        <a href="{{ route("admin.restaurantCategorySlider") }}"
                            class="dropdown-item {{ Request::is('admin/store-category-slider') ? 'active' : '' }}">
                            <i class="icon-grid52 mr-2"></i>
                            Store Category Slider
                        </a>
                        @endcan
                        @can('coupons_manage')
                        <a href="{{ route('admin.coupons') }}"
                            class="dropdown-item {{ Request::is('admin/coupons') ? 'active' : '' }}">
                            <i class="icon-price-tags2 mr-2"></i>
                            Coupons
                        </a>
                        @endcan
                        @can('pages_manage')
                        <a href="{{ route('admin.pages') }}"
                            class="dropdown-item {{ Request::is('admin/pages') ? 'active' : '' }}">
                            <i class="icon-files-empty mr-2"></i>
                            Pages
                        </a>
                        @endcan

                        @can('send_notification_manage')
                        <a href="{{ route('admin.notifications') }}"
                            class="dropdown-item {{ Request::is('admin/notifications') ? 'active' : '' }}">
                            <i class="icon-bubble-dots4 mr-2"></i>
                            Send Push Notifications
                        </a>
                        @endcan
                    </div>
                </li>
                @endcanany

                @canany(['store_payouts_manage',
                'delivery_collection_manage', 'delivery_collection_logs_view', 'wallet_transactions_view',
                'reports_view'])
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)"
                        class="navbar-nav-link dropdown-toggle  {{ Request::is('admin/delivery-collection-logs') || Request::is('admin/delivery-collection') || Request::is('admin/store-payouts') || Request::is('admin/wallet/transactions') || Request::is('admin/reports/top-items') ? 'active' : '' }}"
                        data-toggle="dropdown">
                        <i class="icon-books mr-2"></i>
                        Transactions
                    </a>
                    <div class="dropdown-menu">
                        @can('store_payouts_manage')
                        <a href="{{ route('admin.restaurantpayouts') }}"
                            class="dropdown-item {{ Request::is('admin/store-payouts') ? 'active' : '' }}">
                            <i class="icon-piggy-bank mr-2"></i>
                            Store Payouts
                        </a>
                        @endcan
                        @can('delivery_collection_manage')
                        <a href="{{ route("admin.deliveryCollections") }}"
                            class="dropdown-item {{ Request::is('admin/delivery-collections') ? 'active' : '' }}">
                            <i class="icon-cash3 mr-2"></i>
                            Delivery Collections
                        </a>
                        @endcan
                        @can('delivery_collection_logs_view')
                        <a href="{{ route("admin.deliveryCollectionLogs") }}"
                            class="dropdown-item {{ Request::is('admin/delivery-collection-logs') ? 'active' : '' }}">
                            <i class="icon-database-time2 mr-2"></i>
                            Delivery Collection Logs
                        </a>
                        @endcan
                        @can('wallet_transactions_view')
                        <a href="{{ route("admin.walletTransactions") }}"
                            class="dropdown-item {{ Request::is('admin/wallet/transactions') ? 'active' : '' }}">
                            <i class="icon-transmission mr-2"></i>
                            Wallet Transactions
                        </a>
                        @endcan
                        @can('reports_view')
                        <a href="{{ route("admin.viewTopItems") }}"
                            class="dropdown-item {{ Request::is('admin/reports/top-items') ? 'active' : '' }}">
                            <i class="icon-graph mr-2"></i>
                            Reports
                        </a>
                        @endcan
                    </div>
                </li>
                @endcanany

                @role('Admin')
                <li class="nav-item">
                    <a href="{{ route("admin.modules") }}"
                        class="navbar-nav-link {{ Request::is('admin/modules') ? 'active' : '' }}">
                        <i class="icon-stars mr-2"></i>
                        Modules
                    </a>
                </li>
                @endrole

                @can('settings_manage')

                <li class="nav-item dropdown">
                    <a href="javascript:void(0)"
                        class="navbar-nav-link dropdown-toggle  {{ Request::is('admin/settings') || Request::is('admin/popular-geo-locations') || Request::is('admin/zones') ? 'active' : '' }}"
                        data-toggle="dropdown">
                        <i class="icon-cog3 mr-2"></i>
                        Settings
                    </a>
                    <div class="dropdown-menu">
                        @role('Admin')
                        <a href="{{ route("admin.zones") }}"
                            class="dropdown-item {{ Request::is('admin/zones') ? 'active' : '' }}">
                            <i class="icon-location4 mr-2"></i>
                            Zones <span
                                class="badge badge-flat border-grey-800 text-danger text-capitalize ml-1 float-right">NEW</span>
                        </a>
                        @endrole
                        @can('popular_location_manage')
                        <a href="{{ route("admin.popularGeoLocations") }}"
                            class="dropdown-item {{ Request::is('admin/popular-geo-locations') ? 'active' : '' }}">
                            <i class="icon-location3 mr-2"></i>
                            Popular Geo Locations
                        </a>
                        @endcan
                        <hr class="my-2">
                        <a href="{{ route("admin.settings", '#generalSettings') }}"
                            class="dropdown-item {{ Request::is('admin/settings') ? 'active' : '' }}">
                            <i class="icon-gear mr-2"></i>
                            All Settings
                        </a>
                    </div>
                </li>
                @endcan

                @role("Store Owner")
                <li class="nav-item">
                    <a href="{{ route("restaurant.dashboard") }}"
                        class="navbar-nav-link {{ Request::is('/dashboard') ? 'active' : '' }}">
                        <i class="icon-meter-fast mr-2"></i>
                        {{__('storeDashboard.navDashboard')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("restaurant.restaurants") }}"
                        class="navbar-nav-link {{ Request::is('restaurant-owner/restaurants') ? 'active' : '' }}">
                        <i class="icon-store2 mr-2"></i>
                        {{__('storeDashboard.navStores')}}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)"
                        class="navbar-nav-link dropdown-toggle {{ Request::is('restaurant-owner/items')  || Request::is('restaurant-owner/addons') ? 'active' : '' }}"
                        data-toggle="dropdown">
                        <i class="icon-stack-star mr-2"></i>
                        {{__('storeDashboard.navItemsMenu')}}
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route("restaurant.addonCategories") }}"
                            class="dropdown-item {{ Request::is('restaurant-owner/addoncategories') ? 'active' : '' }}">
                            <i class="icon-tree6 mr-2"></i>
                            {{__('storeDashboard.navSubAddonCat')}}
                        </a>
                        <a href="{{ route("restaurant.addons") }}"
                            class="dropdown-item {{ Request::is('restaurant-owner/addons') ? 'active' : '' }}">
                            <i class="icon-list2 mr-2"></i>
                            {{__('storeDashboard.navSubAddon')}}
                        </a>
                        <a href="{{ route("restaurant.itemcategories") }}"
                            class="dropdown-item {{ Request::is('restaurant-owner/itemcategories') ? 'active' : '' }}">
                            <i class="icon-grid52 mr-2"></i>
                            {{__('storeDashboard.navSubMenuCat')}}
                        </a>
                        <a href="{{ route("restaurant.items") }}"
                            class="dropdown-item {{ Request::is('restaurant-owner/items') ? 'active' : '' }}">
                            <i class="icon-grid mr-2"></i>
                            {{__('storeDashboard.navSubItems')}}
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route("restaurant.orders") }}"
                        class="navbar-nav-link {{ Request::is('restaurant-owner/orders') ? 'active' : '' }}">
                        <i class="icon-basket mr-2"></i>
                        {{__('storeDashboard.navOrders')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("restaurant.earnings") }}"
                        class="navbar-nav-link {{ Request::is('restaurant-owner/earnings/*') ? 'active' : '' }}">
                        <i class="icon-coin-dollar mr-2"></i>
                        {{__('storeDashboard.navEarnings')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("restaurant.ratings") }}"
                        class="navbar-nav-link {{ Request::is('restaurant-owner/ratings/*') ? 'active' : '' }}">
                        <i class="icon-star-full2 mr-2"></i>
                        {{__('storeDashboard.navRatings')}}
                    </a>
                </li>
                @if(\Nwidart\Modules\Facades\Module::find('CallAndOrder') &&
                \Nwidart\Modules\Facades\Module::find('CallAndOrder')->isEnabled())
                @can("login_as_customer")
                <li class="nav-item">
                    <a href="{{ route("cao.usersPage") }}"
                        class="navbar-nav-link {{ Request::is('callandorder/users') ? 'active' : '' }}">
                        <i class="icon-phone2 mr-2"></i>
                        {{__('callAndOrderLang.callAndOrderNavMenuLabel')}}
                    </a>
                </li>
                @endcan
                @endif
                @if(\Nwidart\Modules\Facades\Module::find('ThermalPrinter') &&
                \Nwidart\Modules\Facades\Module::find('ThermalPrinter')->isEnabled())
                <li class="nav-item">
                    <a href="{{ route("thermalprinter.settings") }}"
                        class="navbar-nav-link {{ Request::is('thermalprinter/settings') ? 'active' : '' }}">
                        <i class="icon-printer2 mr-2"></i>
                        {{__('thermalPrinterLang.printerSettingsNav')}}
                    </a>
                </li>
                @endif
                @endrole
            </ul>
        </div>
    </div>
</div>