<div class="pagination p1">
  <p hidden id="pageNumberUsers">{{$paginator->currentPage()}}</p>
  <ul>
    @for ($i = 1; $i < $paginator->lastItem(); $i++)
      @if(strlen(URL::full())==strlen(URL::current()))
        <a href="{{url(URL::full() . '?page=' . $i)}}"><li>{{$i}}</li></a>
      @else
        <a href="{{url(URL::full() . '&page=' . $i)}}"><li>{{$i}}</li></a>
      @endif
    @endfor
  </ul>
</div>
