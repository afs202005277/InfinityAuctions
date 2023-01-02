<form>
    <input type="number" hidden name="amount" placeholder="Bid Amount"
           value="{{number_format((float)$baseValue*$increase, 2, '.', '')}}">
    <button
        type="submit" {{$disabled}}>{{number_format((float)$baseValue*$increase, 2, '.', '')}}
        €
    </button>
</form>
