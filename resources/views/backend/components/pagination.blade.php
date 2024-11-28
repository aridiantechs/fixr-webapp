<nav class="blog__pagination">
    @if ($data->lastPage() > 1)
     <ul class="pagination">
         <li class="{{ ($data->currentPage() == 1) ? ' disabled' : '' }}">
             <a href="{{ $data->url(1) }}">First</a>
          </li>
         @for ($i = 1; $i <= $data->lastPage(); $i++)
             <?php
             $half_total_links = floor(5 / 2);
             $from = $data->currentPage() - $half_total_links;
             $to = $data->currentPage() + $half_total_links;
             if ($data->currentPage() < $half_total_links) {
                $to += $half_total_links - $data->currentPage();
             }
             if ($data->lastPage() - $data->currentPage() < $half_total_links) {
                 $from -= $half_total_links - ($data->lastPage() - $data->currentPage()) - 1;
             }
             ?>
             @if ($from < $i && $i < $to)
                 <li class="{{ ($data->currentPage() == $i) ? ' active' : '' }}">
                     <a href="{{ $data->url($i) }}">{{ $i }}</a>
                 </li>
             @endif
         @endfor
         <li class="{{ ($data->currentPage() == $data->lastPage()) ? ' disabled' : '' }}">
             <a href="{{ $data->url($data->lastPage()) }}">Last</a>
         </li>
     </ul>
     @endif
</nav>