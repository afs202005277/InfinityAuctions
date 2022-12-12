

<div class="pagination p1">
  <p hidden id="pageNumberUsers"> {{$paginator->currentPage()}} </p>
  <ul>
    @if($paginator->currentPage() != 1 )
    <li><</li>
    @endif
    <a  href="#"><li class="is-active">1</li></a>
    @for ($i = 2; $i < 6; $i++)
      <a href="{{url($paginator->url($i))}}"><li>{{$i}}</li></a>
    @endfor
    @for ($i = 6; $i < 11; $i++)
      <a hidden href="{{url($paginator->url($i))}}"><li>{{$i}}</li></a>
    @endfor
    <li>></li>
  </ul>
</div>