<div class="pagination p1">
  <p hidden id="pageNumberUsers">{{$paginator->currentPage()}}</p>
  <ul>
    <li>&lt;</li>
    @for ($i = 1; $i < $paginator->lastItem(); $i++)
      <a href="{{url($paginator->url($i))}}"><li>{{$i}}</li></a>
    @endfor
    <li>&gt;</li>
  </ul>
</div>
