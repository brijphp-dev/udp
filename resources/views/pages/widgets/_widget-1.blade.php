{{-- Mixed Widget 1 --}}

<div class="card card-custom bg-gray-100 {{ @$class }}">
    {{-- Header --}}
    <div class="card-header border-0 bg-success py-5">
        <h3 class="card-title font-weight-bolder text-white">Member stats</h3>
    </div>
    {{-- Body --}}
    <div class="card-body p-0 position-relative overflow-hidden">
        {{-- Chart --}}
        <div id="kt_chart_lineBrij1" class="card-rounded-bottom" style="height: 200px; background-color: #CCBD5AE3;"></div>

        {{-- Stats --}}
        <div class="card-spacer mt-n25">
            {{-- Row --}}
            <div class="row m-0">
                <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
                    {{ Metronic::getSVG("media/svg/icons/Communication/Urgent-mail.svg", "svg-icon-3x svg-icon-success d-block my-2") }}
                    <span class="text-warning font-weight-bold font-size-h6 mr-7">
                        Total Members
                    </span>
                    <span class="text-warning font-weight-bold font-size-h6">
                        {{ $dashboard_data['membercount'] }}
                    </span>
                </div>
                <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                    {{ Metronic::getSVG("media/svg/icons/Communication/Add-user.svg", "svg-icon-3x svg-icon-primary d-block my-2") }}
                    <span class="text-primary font-weight-bold font-size-h6 mt-2 mr-7">
                        Total Voters 
                    </span>
                    <span class="text-primary font-weight-bold font-size-h6 mt-2">
                        {{ $dashboard_data['votercount'] }}
                    </span>
                </div>
            </div>
            {{-- Row 
            <div class="row m-0">
                <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7">
                    {{ Metronic::getSVG("media/svg/icons/Design/Layers.svg", "svg-icon-3x svg-icon-danger d-block my-2") }}
                    <span class="text-danger font-weight-bold font-size-h6 mt-2 mr-7">
                        Not Paid
                    </span>
                    <span class="text-danger font-weight-bold font-size-h6 mt-2">
                        325
                    </span>
                </div>
                <div class="col bg-light-success px-6 py-8 rounded-xl">
                    {{ Metronic::getSVG("media/svg/icons/Media/Equalizer.svg", "svg-icon-3x svg-icon-warning d-block my-2") }}
                    <span class="text-success font-weight-bold font-size-h6 mt-2 mr-7">
                        Item Stat#1
                    </span>
                    <span class="text-success font-weight-bold font-size-h6 mt-2">
                        $2,540,000
                    </span>
                </div>
            </div>--}}
        </div>
    </div>
</div>