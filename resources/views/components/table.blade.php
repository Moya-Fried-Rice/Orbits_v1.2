@props(['action'])

<div class="overflow-x-auto w-full px-5">
    <table class="table table-bordered font-TT w-full table-auto">
        <thead>
            <tr class="uppercase font-normal bg-[#F8F8F8] text-black">
                {{ $header }}
                
                @if($action)
                    <th class="border border-[#DDD] text-left py-2 px-4 whitespace-nowrap font-light hover:bg-blue-50 transition-colors duration-100">
                        <div style="user-select: none;">
                            Actions
                        </div>
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            {{ $body }}
        </tbody>
    </table>
</div>
