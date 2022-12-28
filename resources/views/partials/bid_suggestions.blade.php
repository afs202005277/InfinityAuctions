<form>
    <input type="number" hidden name="amount" placeholder="Bid Amount"
           value="{{number_format((float)$baseValue*$increase, 2, '.', '')}}">
    <button
        type="submit" @php if ($state !== "Running") { echo "disabled"; } @endphp>{{number_format((float)$baseValue*$increase, 2, '.', '')}}
        €
    </button>
</form>
