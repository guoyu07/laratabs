<li class="dropdown">

    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$tab['tab']->toName()}}<i class="fa fa-angle-down"></i>
    </a>
      <ul class="dropdown-menu" role="menu">
        @foreach ($tab['subtabs'] as $subtab)
        <li>
            <a href="#{{$subtab}}" tabindex="-1" data-toggle="tab">{{$subtab->toName()}}</a>
        </li>
        @endforeach
    </ul>
</li>