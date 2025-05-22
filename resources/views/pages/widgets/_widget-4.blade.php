{{-- Stats Widget 12 --}}

<div class="card card-custom {{ @$class }}">
    {{-- Body --}}
    <div class="card-body d-flex flex-column p-0">
        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
            <span class="symbol symbol-50 symbol-light-primary mr-2">
                <span class="symbol-label">
                    {{ Metronic::getSVG("media/svg/icons/Communication/Group.svg", "svg-icon-xl svg-icon-primary") }}
                </span>
            </span>
            <div class="d-flex flex-column text-right">
                <span class="text-dark-75 font-weight-bolder font-size-h3">{{ $dashboard_data['votercount'] }}</span>
                <span class="text-muted font-weight-bold mt-2">Voter count</span>
            </div>
        </div>
        <div id="brij_votercount" class="card-rounded-bottom"  style="height: 150px" data-color='themeCustom'></div>
    </div>
</div>
