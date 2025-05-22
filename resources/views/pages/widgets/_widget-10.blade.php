{{-- Advance Table Widget 2 --}}

<div class="card card-custom {{ @$class }}">
    {{-- Header --}}
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">New Voters</span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm">More than {{ $dashboard_data['votercount'] }}+ new voters</span>
        </h3>
        <div class="card-toolbar">
        </div>
    </div>

    {{-- Body --}}
    <div class="card-body pt-3 pb-0">
        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-borderless table-vertical-center">
                <thead>
                    <tr>
                        <th class="p-0" style="width: 200px">Name</th>
                        <th class="p-0 text-center" style="width: 200px">City</th>
                        <th class="p-0 text-center" style="min-width: 200px">Region</th>
                        <th class="p-0 text-center" style="min-width: 100px">State</th>
                        <th class="p-0 text-center" style="min-width: 125px">Ethnicity</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($dashboard_data['voterData'] == 'No Data available')
                    <tr>
                        <td class="pl-0 py-4 text-center" colspan="4">
                            Sorry, No data available
                        </td>
                    </tr>
                    @else
                        @foreach ($dashboard_data['voterData'] as $voterData)
                            <tr>
                                <td class="pl-0">
                                    <span class="text-dark-75 font-weight-bolder mb-1 font-size-lg">{!! $voterData['voterName'] !!}</span>
                                    <div>
                                        <a class="text-muted font-weight-bold text-hover-primary" href="mailto:{!! $voterData['voterEmail'] !!}">{!! $voterData['voterEmail'] !!}</a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                        {!! $voterData['voterCity'] !!}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted font-weight-500">
                                        {!! $voterData['voterRegion'] !!}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted font-weight-500">
                                        {!! $voterData['voterState'] !!}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="text-muted  font-weight-bolder">
                                        {!! $voterData['voterEthnic'] !!}
                                    </span>
                                </td>
                                {{-- <td class="text-right pr-0">
                                    <a href="#" class="btn btn-icon btn-light btn-sm">
                                        {{ Metronic::getSVG("media/svg/icons/General/Settings-1.svg", "svg-icon-md svg-icon-primary") }}
                                    </a>
                                    <a href="#" class="btn btn-icon btn-light btn-sm mx-3">
                                        {{ Metronic::getSVG("media/svg/icons/Communication/Write.svg", "svg-icon-md svg-icon-primary") }}
                                    </a>
                                    <a href="#" class="btn btn-icon btn-light btn-sm">
                                        {{ Metronic::getSVG("media/svg/icons/General/Trash.svg", "svg-icon-md svg-icon-primary") }}
                                    </a>
                                </td> --}}
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
