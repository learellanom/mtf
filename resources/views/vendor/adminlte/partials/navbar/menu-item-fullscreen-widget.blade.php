{{-- @php $locale = session()->get('locale'); @endphp

<li class="nav-item dropdown user-menu">
    <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" v-pre>

     @switch($locale)
       @case('es')
       <img src="https://flagcdn.com/16x12/ve.png" width="20" alt="Venezuela"> {{ 'Spain' }}
       @break

       @case('en')
       <img src="https://flagcdn.com/16x12/gb.png" width="20" alt="Ingles"> {{ 'English' }}
       @break

       @default
       <img src="https://flagcdn.com/16x12/ve.png" width="20" alt="Venezuela"> {{ 'Spanish' }}
   @endswitch

   </a>
     <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
         <a href="lang/es" class="dropdown-item" data-toggle="dropdown"></a>
         <a href="lang/en" class="dropdown-item" data-toggle="dropdown"></a>
     </div>
</li> --}}


@php $locale = session()->get('locale'); @endphp

@switch($locale)
@case('es')
<h6><li class="nav-item badge badge-light mt-2"><img src="https://flagcdn.com/w40/ve.png" width="32" height="20" alt="Venezuela"></li></h6>
@break

@case('en')
<h6><li class="nav-item badge badge-light mt-2"><img src="https://flagcdn.com/w40/gb.png" width="32" height="20" alt="Ingles"></li></h6>
@break

@case('ar')
<h6><li class="nav-item badge badge-light mt-2"><img src="https://flagcdn.com/w40/lb.png" width="32" height="20" alt="Libano"></li></h6>
@break

@default
<h6><li class="nav-item badge badge-light mt-2"><img src="https://flagcdn.com/w40/ve.png" width="32" height="20" alt="Venezuela"></li></h6>
@endswitch

@php $es = 'es'; $en = 'en'; $ar = 'ar';  @endphp
 <!-- Language Dropdown Menu -->
 <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="fas fa-flag"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right p-0">
      <a href="{{route('lang', $en)}}" class="dropdown-item">
        <img src="https://flagcdn.com/16x12/gb.png" width="20" alt="English"> English
      </a>
      <a href="{{route('lang', $es)}}" class="dropdown-item">
        <img src="https://flagcdn.com/16x12/ve.png" width="20" alt="Spanish"> Español
      </a>
      <a href="{{route('lang', $ar)}}" class="dropdown-item">
        <img src="https://flagcdn.com/16x12/lb.png" width="20" alt="Arabe"> Lebanese Arabic
      </a>
    </div>
</li>



<li class="nav-item">
    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
    </a>
</li>



