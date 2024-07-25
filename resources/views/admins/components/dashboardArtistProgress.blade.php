<div>
    <div class="row">
        <div class="col-lg-6 mb-1">
            <!-- Store Quantity Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">Store QTY</h6>
                </div>
                <div class="card-body">
                    @foreach ($storeQuantities as $store)
                        <h4 class="small font-weight-bold">
                            {{ $store->store }} <span class="float-right">{{ number_format($store->total_quantity) }} QTY</span>
                        </h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: {{ $storeQuantities->sum('total_quantity') ? ($store->total_quantity / $storeQuantities->sum('total_quantity')) * 100 : 0 }}%"
                                aria-valuenow="{{ $store->total_quantity }}" aria-valuemin="0" aria-valuemax="3"></div>
                        </div>
                    @endforeach
                    {{ $storeQuantities->links() }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-1">
            <!-- Store Profit Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">Store Profit $</h6>
                </div>
                <div class="card-body">
                    @foreach ($storeEarnings as $store)
                        <h4 class="small font-weight-bold">
                            {{ $store->store }} <span class="float-right">$ {{ number_format($store->total_earnings_usd) }}</span>
                        </h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: {{ $storeEarnings->sum('total_earnings_usd') ? ($store->total_earnings_usd / $storeEarnings->sum('total_earnings_usd')) * 100 : 0 }}%"
                                aria-valuenow="{{ $store->total_earnings_usd }}" aria-valuemin="0" aria-valuemax="3"></div>
                        </div>
                    @endforeach
                    {{ $storeEarnings->links() }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <!-- Song Quantity Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">Song QTY</h6>
                </div>
                <div class="card-body">
                    @foreach ($songQuantities as $song)
                        <h4 class="small font-weight-bold">
                            {{ $song->song->song_name }} <span class="float-right">{{ number_format($song->total_quantity) }} QTY</span>
                        </h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: {{ $songQuantities->sum('total_quantity') ? ($song->total_quantity / $songQuantities->sum('total_quantity')) * 100 : 0 }}%"
                                aria-valuenow="{{ $song->total_quantity }}" aria-valuemin="0" aria-valuemax="3"></div>
                        </div>
                    @endforeach
                    {{ $songQuantities->links() }}
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <!-- Song Profit Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">Song Profit $</h6>
                </div>
                <div class="card-body">
                    @foreach ($songEarnings as $song)
                        <h4 class="small font-weight-bold">
                            {{ $song->song->song_name }} <span class="float-right">$ {{ number_format($song->total_earnings_usd) }}</span>
                        </h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: {{ $songEarnings->sum('total_earnings_usd') ? ($song->total_earnings_usd / $songEarnings->sum('total_earnings_usd')) * 100 : 0 }}%"
                                aria-valuenow="{{ $song->total_earnings_usd }}" aria-valuemin="0" aria-valuemax="3"></div>
                        </div>
                    @endforeach
                    {{ $songEarnings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
