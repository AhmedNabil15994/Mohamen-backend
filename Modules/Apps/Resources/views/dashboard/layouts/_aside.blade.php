<div class="page-sidebar-wrapper">
  <div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu page-header-fixed"
      data-keep-expanded="false"
      data-auto-scroll="true"
      data-slide-speed="200"
      style="padding-top: 20px">

      <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
          <span></span>
        </div>
      </li>
      <li class="nav-item {{ active_menu('home') }}">
        <a href="{{ url(route('dashboard.home')) }}"
          class="nav-link nav-toggle">
          <i class="icon-home"></i>
          <span class="title">{{ __('apps::dashboard.index.title') }}</span>
          <span class="selected"></span>
        </a>
      </li>

      <li class="heading">
        <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.control') }}</h3>
      </li>



      @canany(['show_users', 'show_admins'])
      <li class="nav-item {{ active_slide_menu(['users', 'admins']) }}">
        <a href="javascript:;"
          class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.users') }}</span>
          <span class="arrow {{ active_slide_menu(['users', 'admins', 'lawyers']) }}"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu">
          @can('show_users')
          <li class="nav-item {{ active_menu('users') }}">
            <a href="{{ url(route('dashboard.users.index')) }}"
              class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.users') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_admins')
          <li class="nav-item {{ active_menu('admins') }}">
            <a href="{{ url(route('dashboard.admins.index')) }}"
              class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.admins') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcanAny
      @canany(['show_lawyers','show_reservations'])
      <li class="nav-item active open">
        <a href="javascript:;"
          class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside._tabs.lawyers_and_reservations') }}</span>
          <span class="arrow {{ active_slide_menu(['lawyers']) }}"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu">
          @can('show_lawyers')
          <li class="nav-item {{ active_menu('lawyers') }}">
            <a href="{{ url(route('dashboard.lawyers.index')) }}"
              class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.lawyers') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_reservations')
          <li class="nav-item {{ active_menu('reservations') }}">
            <a href="{{ url(route('dashboard.reservations.index')) }}"
              class="nav-link nav-toggle">
              <i class="icon-layers"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.reservations') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_reservations')
          <li class="nav-item {{ active_menu('reservations_calendar') }}">
            <a href="{{ url(route('dashboard.reservations_calendar.index')) }}"
              class="nav-link nav-toggle">
              <i class="icon-layers"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.reservations_calendar') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('sales_report_by_lawyer')
          <li class="nav-item {{ active_menu('sales') }}">
            <a href="{{ route('dashboard.reports.sales') }}"
              class="nav-link nav-toggle">
              <i class="icon-settings"></i>
              <span class="title">@lang('apps::dashboard._layout.aside.sales_report_by_lawyer') </span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcanAny
      @can('show_categories')
      <li class="nav-item {{ active_menu('categories') }}">
        <a href="{{ url(route('dashboard.categories.index')) }}"
          class="nav-link nav-toggle">
          <i class="icon-layers"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.categories') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      @canany($coursesPermissions = ['show_courses', 'show_lessons', 'show_lessoncontents','show_orders'])
      <li class="nav-item active open">
        <a href="javascript:;"
          class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.courses') }}</span>
          <span class="arrow {{ active_slide_menu(['courses', 'lessons', 'lessoncontents','orders']) }}"></span>

          <span class="selected"></span>
        </a>
        <ul class="sub-menu">
          <li class="nav-item {{ active_menu('courses') }}">
            <a href="{{ route('dashboard.courses.index') }}"
              class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.courses') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          <li class="nav-item {{ active_menu('lessons') }}">
            <a href="{{ route('dashboard.lessons.index') }}"
              class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.lesson_contents') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          <li class="nav-item {{ active_menu('orders') == 'active' && !request('status_id') ? 'active' : ''  }}">
            <a href="{{ url(route('dashboard.orders.index')) }}"
              class="nav-link nav-toggle">
              <i class="icon-settings"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.orders') }}</span>
            </a>
          </li>
          <li class="nav-item {{ active_menu('orders') == 'active' && request('status_id') ? 'active' : '' }}">
            <a href="{{ url(route('dashboard.orders.index' , ['status_id'=>'2'])) }}"
              class="nav-link nav-toggle">
              <i class="icon-settings"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.success_orders') }}</span>
            </a>
          </li>
        </ul>
      </li>
      @endcan


      @canany(['show_coupons', 'show_notifications'])
      <li class="nav-item {{ active_slide_menu(['show_coupons', 'show_notifications']) }}">
        <a href="javascript:;"
          class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside._tabs.marketing') }}</span>
          <span class="arrow {{ active_slide_menu(['coupons', 'notifications']) }}"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu">
          @can('show_coupons')
          <li class="nav-item {{ active_menu('coupons') }}">
            <a href="{{ url(route('dashboard.coupons.index')) }}"
              class="nav-link nav-toggle">
              <i class="icon-layers"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.coupons') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_notifications')
          <li class="nav-item {{ active_menu('notifications') }}">
            <a href="{{ url(route('dashboard.notifications.index')) }}"
              class="nav-link nav-toggle">
              <i class="icon-settings"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.notifications') }}</span>
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcan

      @can('show_blogs')
      <li class="nav-item {{ active_menu('blogs') }}">
        <a href="{{ url(route('dashboard.blogs.index')) }}"
          class="nav-link nav-toggle">
          <i class="icon-layers"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.blogs') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
      @can('show_services')
      <li class="nav-item {{ active_menu('services') }}">
        <a href="{{ url(route('dashboard.services.index')) }}"
          class="nav-link nav-toggle">
          <i class="icon-layers"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.services') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      @can('show_pages')
      <li class="nav-item {{ active_menu('pages') }}">
        <a href="{{ url(route('dashboard.pages.index')) }}"
          class="nav-link nav-toggle">
          <i class="icon-docs"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.pages') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
      @canany(['show_countries', 'show_areas', 'show_cities', 'show_states'])
      <li class="nav-item {{ active_slide_menu(['countries', 'cities', 'states', 'areas']) }}">
        <a href="javascript:;"
          class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
          <span class="arrow {{ active_slide_menu(['countries', 'governorates', 'cities', 'regions']) }}"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu">

          @can('show_countries')
          <li class="nav-item {{ active_menu('countries') }}">
            <a href="{{ url(route('dashboard.countries.index')) }}"
              class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan

          @can('show_cities')
          <li class="nav-item {{ active_menu('cities') }}">
            <a href="{{ url(route('dashboard.cities.index')) }}"
              class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.cities') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan

          @can('show_states')
          <li class="nav-item {{ active_menu('states') }}">
            <a href="{{ url(route('dashboard.states.index')) }}"
              class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.state') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcanAny



      @canany(['show_logs', 'show_devices'])
      <li class="nav-item {{ active_slide_menu(['logs','devices']) }}">
        <a href="javascript:;"
          class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside._tabs.settings') }}</span>
          <span class="arrow {{ active_slide_menu(['logs', 'devices']) }}"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu">
          @can('edit_settings')
          <li class="nav-item {{ active_menu('setting') }}">
            <a href="{{ url(route('dashboard.setting.index')) }}"
              class="nav-link nav-toggle">
              <i class="icon-settings"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.setting') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_logs')
          <li class="nav-item {{ active_menu('logs') }}">
            <a href="{{ url(route('dashboard.logs.index')) }}"
              class="nav-link nav-toggle">
              <i class="icon-folder"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.logs') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
          @can('show_logs')
          <li class="nav-item {{ active_menu('devices') }}">
            <a href="{{ url(route('dashboard.devices.index')) }}"
              class="nav-link nav-toggle">
              <i class="fa fa-mobile"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.devices') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcanAny

    </ul>
  </div>

</div>
