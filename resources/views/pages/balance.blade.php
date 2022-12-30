@extends('layouts.app')

@section('content')

    <div id="balance">
        <div class="left-side">
            <div class="top-area">
                <div class="chart">
                    <div class="money-title">
                        <h3>BALANCE</h3>
                        <p class="money"><span class="euro">€</span>{{ number_format((float) $balance, 2, '.', '') }}</p>
                    </div>
                    <div id="pie-chart" style="background: conic-gradient(#FF6B00 0.00% {{ (1 - $heldBalance/$balance) * 100}}%, #424242 {{ (1 - $heldBalance/$balance) * 100}}% 100.00%);"><div class="center"></div></div>
                </div>
                <div class="bottom">
                    <div class="money-title">
                        <h3>FREE FUNDS</h3>
                        <p class="money orange"><span class="euro">€</span>{{ number_format((float) $balance - (float) $heldBalance, 2, '.', '') }}</p>
                    </div>
                    <div class="money-title">
                        <h3>BLOCKED FUNDS</h3>
                        <p class="money "><span class="euro">€</span>{{ number_format((float) $heldBalance, 2, '.', '') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-side">

            <form method="GET" class="deposit" action="{{route('deposit')}}">
                <label for="deposit">Deposit</label><br><input id="deposit" placeholder="Deposit Amount €" type="number"
                                                             name="deposit" required>
                <button type="submit">Deposit</button>
                @if ($errors->has('deposit'))
                    <span class="error">
                {{ $errors->first('deposit') }}
            </span>
                @endif
            </form>

            <form method="GET" class="withdraw" action="{{route('withdraw')}}">
                <label for="withdraw">Withdraw</label><br><input id="withdraw" placeholder="Withdraw Amount €"
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
