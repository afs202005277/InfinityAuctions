@php
    $starsFilled = round($ratingDetails['rate']);
    $starsNotFilled = 5 - $starsFilled;
    $offset = 1 - ($ratingDetails['rate'] - $starsFilled);
@endphp

<div class="in_stars">
    @for ($i = 0; $i < $starsFilled; $i++)
        <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="gold" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
        </svg>
    @endfor
    <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="grey" viewBox="0 0 20 20"
         xmlns="http://www.w3.org/2000/svg">
        <defs>
            <filter class="fillpartial" primitiveUnits="objectBoundingBox" x="0%" y="0%" width="100%"
                    height="100%">
                <feFlood x="0%" y="0%" width="100%" height="100%" flood-color="gold"></feFlood>
                <feOffset dx="-{{$offset}}">
                </feOffset>
                <feComposite operator="in" in2="SourceGraphic"></feComposite>
                <feComposite operator="over" in2="SourceGraphic"></feComposite>
            </filter>
        </defs>
        <path filter="url(.fillpartial)"
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
    </svg>
    @for ($i = 0; $i < $starsNotFilled-1; $i++)
        <svg aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="grey" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
        </svg>
    @endfor
</div>
