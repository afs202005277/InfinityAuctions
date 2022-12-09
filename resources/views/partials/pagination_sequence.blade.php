

<div class="pagination p1">
      <ul>
        @if($paginator->currentPage() != 1)
        <a href="{{url($paginator->previousPageUrl())}}"><li><</li></a>
        @endif
        <a class="is-active" href="#"><li>{{$paginator->currentPage()}}</li></a>
        <a href="{{url($paginator->url($paginator->currentPage()+1))}}"><li>{{$paginator->currentPage()+1}}</li></a>
        <a href="{{url($paginator->url($paginator->currentPage()+2))}}"><li>{{$paginator->currentPage()+2}}</li></a>
        <a href="{{url($paginator->url($paginator->currentPage()+3))}}"><li>{{$paginator->currentPage()+3}}</li></a>
        <a href="{{url($paginator->url($paginator->currentPage()+4))}}"><li>{{$paginator->currentPage()+4}}</li></a>
        <a href="{{url($paginator->url($paginator->currentPage()+5))}}"><li>{{$paginator->currentPage()+5}}</li></a>
        <a href="{{url($paginator->nextPageUrl())}}"><li>></li></a>
      </ul>
    </div>