@props([
    'title' => null, // judul tabel
    'columns' => [], // array nama kolom (label)
    'fields' => [], // array nama field di model
    'rows' => collect(), // Eloquent Collection atau array data
])

<div class="w-full flex gap-4 items-center flex-wrap my-4">
    @if ($title)
        <h1 class="text-2xl font-semibold text-gray-900" style="flex-grow: 1; flex-basis: 250px;">{{ $title }}</h1>
    @endif
    <div class="w-full relative" style="flex-grow: 1; flex-basis: 250px;">
        <form method="GET" class="w-full" action="">
            <input type="text" name="search" placeholder="Search..."
                class="w-full pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white shadow-sm"
                value="{{ request('search') }}">
            <button type="submit"
                class="absolute text-center justify-center flex gap-1 items-center right-2 top-2 bottom-2 bg-blue-600 text-white px-3 py-2 rounded-lg shadow hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
            </button>
            @foreach (request()->except('search') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>
    </div>
</div>


<div class="relative overflow-x-auto">
    <table class="w-full whitespace-nowrap text-sm text-gray-500 ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                @foreach ($columns as $col)
                    <th scope="col" class="px-6 py-3">
                        {{ $col }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $AInumber = 1;
            @endphp
            @foreach ($rows as $row)
                <tr class="bg-white border-b hover:bg-gray-50 border-gray-200 transition duration-300 ease-in-out">
                    @foreach ($fields as $field)
                        <td class="px-6 py-4">
                            @if ($field === 'Number')
                                {{ $AInumber++ }}
                            @endif
                            {{ $row->{$field} }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($rows->isEmpty())
        <div class="text-center py-8 text-gray-500">
            No records found.
        </div>
    @endif
</div>
