<ul class="nav nav-{{$type}} {{$direction}}">
    <?php $class = "active"; ?>
    @foreach ($tabs as $tab)

        @if (!isset($tab['subtabs']))
              @include('tabs::menu-tab')
        @else
             @include('tabs::menu-subtabs')
        @endif
    <?php $class = ""; ?>
    @endforeach
</ul>

<?php $class = $fade?"active in":"active";  ?>
<div class="tab-content">
    @foreach ($tabs as $tab)
    @if (!isset($tab['subtabs']))
        @include('tabs::tab-content',['tab'=>$tab['tab']])
    @else
    @foreach ($tab['subtabs'] as $subtab)
        @include('tabs::tab-content',['tab'=>$subtab])
    @endforeach
    @endif
    <?php $class = ""; ?>
    @endforeach
</div>