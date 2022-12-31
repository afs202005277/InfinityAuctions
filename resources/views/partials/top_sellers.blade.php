<h2>Top Sellers </h2>
<div class="topsellers">
    
    @php($stack = array())
    @foreach($topSellers as $user)
        @php($details = App\Models\User::find($user->id)->getRatingDetails())
        @if($details['rate'] > 4)
            @php(array_push($stack, $user))
        @endif
    @endforeach

    @each('partials.user_card', $stack, 'user', 'partials.no_items')
</div>
