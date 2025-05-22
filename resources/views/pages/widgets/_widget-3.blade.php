{{-- Stats Widget 7 --}}

<div class="card card-custom {{ @$class }}">
    {{-- Body --}}
    <div class="card-body d-flex flex-column p-0">
        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
            <div class="d-flex flex-column mr-2">
                <a href="#" class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">Member stats</a>
                <span class="text-muted font-weight-bold mt-2">Your Monthly Members count Chart</span>
            </div>
            <div class="d-flex flex-column text-right">
                <span class="text-dark-75 font-weight-bolder font-size-h3">{{ $dashboard_data['membercount'] }}</span>
                <span class="text-muted font-weight-bold mt-2">Voter count</span>
            </div>
        </div>
        <div id="brij_membercount" class="card-rounded-bottom"  style="height: 150px"></div>
    </div>
</div>
