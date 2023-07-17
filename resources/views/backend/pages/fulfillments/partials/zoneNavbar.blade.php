<div class="btn-group flex-wrap" role="group" aria-label="First group">
    @can('shipping_zones')
        <a href="{{ route('admin.logisticZones.index') }}"
            class="btn btn-outline-primary {{ areActiveRoutes(['admin.logisticZones.index']) }}">
            <i data-feather="disc" class="me-1"></i>{{ localize('Zones') }}
        </a>
    @endcan

    @can('shipping_cities')
        <a href="{{ route('admin.cities.index') }}"
            class="btn btn-outline-primary {{ areActiveRoutes(['admin.cities.index']) }}">
            <i data-feather="pocket" class="me-1"></i>{{ localize('Cities') }}
        </a>
    @endcan

    @can('shipping_states')
        <a href="{{ route('admin.states.index') }}"
            class="btn btn-outline-primary {{ areActiveRoutes(['admin.states.index']) }}">
            <i data-feather="pie-chart" class="me-1"></i>{{ localize('States') }}
        </a>
    @endcan

    @can('shipping_countries')
        <a href="{{ route('admin.countries.index') }}"
            class="btn btn-outline-primary {{ areActiveRoutes(['admin.countries.index']) }}">
            <i data-feather="globe" class="me-1"></i>{{ localize('Countries') }}
        </a>
    @endcan
</div>
