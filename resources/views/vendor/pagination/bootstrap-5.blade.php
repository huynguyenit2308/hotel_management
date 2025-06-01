@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center my-4">
        <ul class="pagination d-flex gap-2">
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link p-2 rounded-circle border-0" style="background-color: #d2691e; width: 14px; height: 14px; display: inline-block;"></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link p-2 rounded-circle border-0" href="{{ $url }}" style="background-color: #f6e1d3; width: 14px; height: 14px; display: inline-block;"></a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif
