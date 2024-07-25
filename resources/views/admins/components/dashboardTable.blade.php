<div>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-sm table-dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Clean Earning</th>
                    <th>Artist Earning</th>
                    <th>MET Earning</th>
                    <th>Tax Count</th>
                    <th>Tax Payed</th>
                    <th>Tax Profit</th>
                    <th>Receipt</th>
                    <th>Wallet</th>
                    <th>Songs Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($artistData as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data['name'] }}</td>
                        <td class="text-success"><b>{{ $data['cleanEarning'] }}</b></td>
                        <td class="text-success"><b>$ {{ $data['artistEarning'] }}</b></td>
                        <td class="text-success"><b>$ {{ $data['metEarning'] }}</b></td>
                        <td class="text-warning"><b>{{ $data['taxCount'] }}</b></td>
                        <td class="text-warning"><b>$ {{ $data['taxPayed'] }}</b></td>
                        <td class="text-warning"><b>$ {{ $data['taxProfit'] }}</b></td>
                        <td class="text-info"><b>$ {{ $data['receipt'] }}</b></td>
                        <td class="text-info"><b>$ {{ $data['wallet'] }}</b></td>
                        <td class="text-danger"><b>{{ $data['songsCount'] }}</b></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11">{{__('No Record Found')}}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="dark:bg-gray-800 dark:text-white">
        {{ $artists->links() }}
    </div>
</div>
