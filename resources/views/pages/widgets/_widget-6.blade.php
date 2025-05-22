{{-- Advance Table Widget 2 --}}

<div class="card card-custom {{ @$class }}">
    {{-- Header --}}
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">New Members</span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm">More than {{ $dashboard_data['membercount'] }}+ new members</span>
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
                        <th class="p-0" style="width: 50px">Profile</th>
                        <th class="p-0" style="min-width: 200px">Name</th>
                        <th class="p-0" style="min-width: 125px">Country</th>
                        <th class="p-0 text-center" style="min-width: 110px">Status</th>
                        <th class="p-0 text-center" style="min-width: 150px">Payment Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dashboard_data['userData'] as $userData)
                        <tr>
                            <td class="pl-0 py-4">
                                <div class="symbol symbol-50 symbol-light mr-1">
                                    <span class="symbol-label">
                                        {!! $userData['profileImage'] !!}
                                    </span>
                                </div>
                            </td>
                            <td class="pl-0">
                                <span class="text-dark-75 font-weight-bolder mb-1 font-size-lg">{!! $userData['userName'] !!}</span>
                                <div>
                                    <span class="font-weight-bolder">Email:</span>
                                    <a class="text-muted font-weight-bold text-hover-primary" href="mailto:{!! $userData['userEmail'] !!}">{!! $userData['userEmail'] !!}</a>
                                </div>
                            </td>
                            <td class="text-right">
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                    {!! $userData['userCountry'] !!}
                                </span>
                                <span class="text-muted font-weight-bold">
                                    {!! $userData['userState'] !!}
                                </span>
                            </td>
                            <td class="text-right">
                                @if ($userData['userStatus'] === 1)
                                    <span class="label label-lg label-light-primary label-inline">Active</span>
                                @elseif ($userData['userStatus'] === 2)
                                    <span class="label label-lg label-light-danger label-inline">In-active</span>
                                @elseif ($userData['userStatus'] === 3)
                                    <span class="label label-lg label-light-info label-inline">Suspended</span>
                                @elseif ($userData['userStatus'] === 4)
                                    <span class="label label-lg label-light-info label-inline">Terminated</span>
                                @elseif ($userData['userStatus'] === 5)
                                    <span class="label label-lg label-light-danger label-inline">Membership Expired</span>
                                @else
                                    <span class="label label-lg label-light-warning label-inline">Death</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($userData['userType'] === 1)
                                    <span class="label label-lg label-light-success label-inline">Manual</span>
                                @elseif ($userData['userStatus'] === 2)
                                    <span class="label label-lg label-light-primary label-inline">Paypal</span>
                                @else
                                    <span class="label label-lg label-light-success label-inline">Direct</span>
                                @endif
                            </td>
                            {{--<td class="text-right pr-0">
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
                </tbody>
            </table>
        </div>
    </div>
</div>
