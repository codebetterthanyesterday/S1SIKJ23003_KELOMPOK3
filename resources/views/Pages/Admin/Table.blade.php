@extends('layout.app3')

@section('title', 'Admin Table')

@section('content')
    <div class="bg-[#fbfbfb] w-full p-7 rounded-lg shadow-md border-[1px] border-[#eeeeee] mt-10">
        <div class="w-full flex justify-end">
            <form class="max-w-[250px] mb-3">
                <label for="underline_select" class="sr-only">Underline select</label>
                <select id="underline_select"
                    class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected>Choose a country</option>
                    <option value="US">United States</option>
                    <option value="CA">Canada</option>
                    <option value="FR">France</option>
                    <option value="DE">Germany</option>
                </select>
            </form>
        </div>
        <table id="export-table">
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            Name
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th data-type="date" data-format="YYYY/DD/MM">
                        <span class="flex items-center">
                            Release Date
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            NPM Downloads
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Growth
                            <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-50 cursor-pointer">
                    <td class="font-medium text-gray-900 whitespace-nowrap">Flowbite</td>
                    <td>2021/25/09</td>
                    <td>269000</td>
                    <td>49%</td>
                </tr>
                <tr class="hover:bg-gray-50 cursor-pointer">
                    <td class="font-medium text-gray-900 whitespace-nowrap">React</td>
                    <td>2013/24/05</td>
                    <td>4500000</td>
                    <td>24%</td>
                </tr>
                <tr class="hover:bg-gray-50 cursor-pointer">
                    <td class="font-medium text-gray-900 whitespace-nowrap">Angular</td>
                    <td>2010/20/09</td>
                    <td>2800000</td>
                    <td>17%</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
