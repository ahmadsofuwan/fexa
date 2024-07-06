<div>
    <strong class="mb-5 font-black">Minting Detail</strong>
    <table class="table-auto w-full text-xs mt-5">
        <thead>
            <tr>
                <th>Mint</th>
                <th>Hours</th>
                <th>Token/Hours</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody class="">
            @foreach ($userPackage as $item)
                <tr>
                    <td>{{ $item->package->price }} DOGE</td>
                    <td>{{ number_format($item->claimed).'/'. number_format($item->max_claim) }}</td>
                    <td class="text-green-500">{{ number_format($item->profit_per_hours,2) }}</td>
                    <td class="text-yellow-500">{{ date('Y/m/d', strtotime($item->claim_time)) }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>
</div>