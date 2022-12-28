@extends('layouts.app')

@section('content')

    <div class="flex-center position-ref full-height">
        <div class="left-side">
            <p>{{ number_format((float) $balance, 2, '.', '') }}<span class="hello">€</span></p>
            <p>{{ number_format((float) $heldBalance, 2, '.', '') }}<span class="hello">€</span></p>
        </div>
        <div class="right-side">

            <form method="GET" class="deposit" action="{{route('deposit')}}">
                <label for="deposit">Deposit: </label><input id="deposit" placeholder="Deposit Amount €" type="number"
                                                             name="deposit" required>
                <button type="submit">Deposit</button>
                @if ($errors->has('deposit'))
                    <span class="error">
                {{ $errors->first('deposit') }}
            </span>
                @endif
            </form>

            <form method="GET" class="withdraw" action="{{route('withdraw')}}">
                <label for="withdraw">Withdraw: </label><input id="withdraw" placeholder="Withdraw Amount €"
                                                               type="number" name="withdraw" required>
                <button type="submit">Withdraw</button>
                @if ($errors->has('withdraw'))
                    <span class="error">
                {{ $errors->first('withdraw') }}
            </span>
                @endif
            </form>

            @if (!empty($succ))
                <p>{{ $succ }}</p>
            @endif

            @if (!empty($fail))
                <p>{{ $fail }}</p>
            @endif

            @if (!empty($cancel))
                <p>{{ $cancel }}</p>
            @endif

        </div>
    </div>
@endsection
