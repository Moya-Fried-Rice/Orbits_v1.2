@props(['label', 'rating', 'totalN'])

<div class="flex flex-col items-center m-5 p-2 text-center flex">

    {{-- Rating Role --}}
    <span class="text-md font-semibold ">{{ $label }} Rating</span>

    <!-- Large Rating Number -->
    <div class="text-5xl font-bold font-TT text-[#2A2723]">
        {{ $rating }}
    </div>

    @php
        $fillPercentage = ($rating / 5) * 100; // Convert rating to percentage
    @endphp

    <!-- Star Rating (Single SVG with Fill Percentage) -->
    <div class="mt-2">
        <svg width="150" height="30" viewBox="0 0 100 20" class="block">
            <!-- Full Star Shape -->
            <defs>
                <path id="starShape" d="M10 15l-5.09 2.67 1.38-5.9L2 7.24l6.18-.53L10 1.5l1.82 5.21 6.18.53-4.29 4.53 1.38 5.9z"></path>
            </defs>

            <!-- Empty Stars (Gray) -->
            <g fill="#DDD">
                <use href="#starShape"/>
                <use href="#starShape" x="20"/>
                <use href="#starShape" x="40"/>
                <use href="#starShape" x="60"/>
                <use href="#starShape" x="80"/>
            </g>

            <!-- Filled Stars (Red) -->
            <g fill="#923534" clip-path="url(#clipPath)">
                <rect width="{{ $fillPercentage }}%" height="20" fill="#923534"/>
            </g>

            <!-- Clipping Path for Partial Fill -->
            <clipPath id="clipPath">
                <use href="#starShape"/>
                <use href="#starShape" x="20"/>
                <use href="#starShape" x="40"/>
                <use href="#starShape" x="60"/>
                <use href="#starShape" x="80"/>
            </clipPath>
        </svg>
    </div>

    {{-- Based on N --}}
    <span class="text-sm text-gray-600">Based on {{ $totalN }} reviews</span>

    {{-- Rating summary --}}
    @php
        $ratingMessage = '';
        $textColorClass = '';

        // Apply text color and message based on overall average rating
        if ($rating >= 4.5) {
            $textColorClass = 'text-green-100'; // Outstanding
            $ratingMessage = 'Outstanding. Exceeds expectations in all areas.';
        } elseif ($rating >= 3.5) {
            $textColorClass = 'text-green-50'; // Exceeds Standard
            $ratingMessage = 'Exceeds Standard. Meets and often exceeds expectations.';
        } elseif ($rating >= 2.5) {
            $textColorClass = 'text-yellow-100'; // Meets Standard
            $ratingMessage = 'Meets Standard. Meets expectations adequately.';
        } elseif ($rating >= 1.5) {
            $textColorClass = 'text-red-50'; // Partially Meets Standard
            $ratingMessage = 'Partially Meets Standard. Falls short of expectations in some areas.';
        } else {
            $textColorClass = 'text-red-100'; // Does not Meet Standard
            $ratingMessage = 'Does not Meet Standard. Does not meet expectations.';
        }
    @endphp

    @if ($ratingMessage)
        <div class="m-2 text-sm text-gray-600 w-48">
            <span>{{ $ratingMessage }}</span>
        </div>
    @endif
</div>