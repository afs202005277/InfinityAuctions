

<div class="pagination p1">
  <p hidden id="pageNumberUsers">{{$paginator->currentPage()}}</p>
  <ul>
    <li><</li>
    @for ($i = 1; $i < $paginator->lastItem(); $i++)
      <a href="{{url($paginator->url($i))}}"><li >{{$i}}</li></a>
    @endfor
    <li>></li>
  </ul>
</div>