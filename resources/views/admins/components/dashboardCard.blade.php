<div>
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{__('Total Earning (Store - Exact)')}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ {{$cleanEarning / app('deduct')}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/ziynmnyj.json" state="in-reveal" trigger="loop" delay="2000"
                                colors="primary:#ffffff,secondary:#30c9e8" style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{__('Total Earning (Store - Calculated)')}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ {{$cleanEarning}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/ziynmnyj.json" trigger="loop" delay="2000"
                                colors="primary:#ffffff,secondary:#30c9e8" style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{__('Total Earning (non-Profit)')}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ {{$cleanEarning}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/wyqtxzeh.json" trigger="loop" delay="2000"
                                colors="primary:#ffffff,secondary:#08a88a" style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Artist Earning (Artist * Profit)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ {{$artistProfitEarnings}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/wyqtxzeh.json" trigger="loop" state="loop-spin"
                                delay="3000" colors="primary:#ffffff,secondary:#08a88a" style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total MET Earning (MET / Profit)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ {{$metProfitEarnings}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/wyqtxzeh.json" trigger="loop" state="in-reveal"
                                delay="1500" colors="primary:#ffffff,secondary:#08a88a" style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total MET Earning (Total Profit)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ {{$metTotlaEarnings}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/nkfxhqqr.json" trigger="loop"
                                state="morph-destroyed" delay="2000" colors="primary:#ffffff,secondary:#b4b4b4"
                                style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                TAX QUANTITY (Automatic)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                {{$qtyTaxes}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/ghhwiltn.json" trigger="loop" state="in-reveal"
                                delay="2000" colors="primary:#e8e230,secondary:#ffffff" style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                TOTAL TAX
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ {{$totalTaxes}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/ghhwiltn.json" trigger="loop" delay="2000"
                                colors="primary:#e8e230,secondary:#ffffff" style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                TOTAL TAX (PROFIT)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ +{{$totalProfitTaxes}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/ghhwiltn.json" trigger="loop" state="in-reveal"
                                delay="2000" colors="primary:#e8e230,secondary:#ffffff" style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                TOTAL TAX (PAID)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ -{{$totalPayedTaxes}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon src="https://cdn.lordicon.com/ghhwiltn.json" trigger="loop" delay="2000"
                                colors="primary:#e8e230,secondary:#ffffff" style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                ARTIST COUNT
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                {{$artistCount}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon
                                src="https://cdn.lordicon.com/xzalkbkz.json"
                                trigger="loop"
                                delay="2000"
                                state="hover-wave"
                                colors="primary:#ffffff,secondary:#c71f16"
                                style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                SONGS COUNT
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                {{$songCount}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon
                                src="https://cdn.lordicon.com/zxnjhqao.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#ffffff,secondary:#c71f16"
                                style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Reciept (Life Time)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ -{{$recipt}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon
                                src="https://cdn.lordicon.com/kxockqqi.json"
                                trigger="loop"
                                delay="1000"
                                colors="primary:#ffffff,secondary:#4e73df"
                                style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                WALLET
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gary-200">
                                $ {{$wallet}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <lord-icon
                                src="https://cdn.lordicon.com/khheayfj.json"
                                trigger="loop"
                                delay="2000"
                                colors="primary:#ffffff,secondary:#30c9e8"
                                style="width:64px;height:64px">
                            </lord-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- **** -->

    </div>
</div>
