@extends('layouts.user-app')

@section('content')
 <div class="main">
   <div class="main-view">
     <div class="container-fluid bd-gutter bd-layout">
       @include('layouts.user.side_nav_bar')
       <main class="bd-main order-1">
         <div class="main-content">
           <div class="section-page-title main-page-title mb-0">
             <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
               <h1 class="page-title">Favorite</h1>
             </div>
           </div>
           <!-- start category list section -->
           <section class="custom-section category-list-section">
             <div class="favorite-item-grid">
               @if(!empty($dishes))
               @foreach($dishes as $key => $dish)
               <div class="card food-detail-card" id="dish-box-{{ $dish->id }}">
                 <a href="#" class="mb-0 food-favorite-icon" onclick="unFavorite({{ $dish->id }})">
                   <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                     <path d="M9.9369 18.2528C10.7426 18.9633 11.2314 18.9586 12.0411 18.2559C12.5184 17.8416 12.9987 17.4307 13.479 17.0198C14.0459 16.5349 14.6129 16.0499 15.175 15.5591C15.2862 15.462 15.3976 15.3651 15.5089 15.2681C16.8886 14.0669 18.2688 12.8652 19.3763 11.3906L9.9369 18.2528ZM9.9369 18.2528C9.36367 17.7472 8.78845 17.244 8.21325 16.7407M9.9369 18.2528L8.21325 16.7407M8.21325 16.7407C6.85099 15.5488 5.48887 14.3571 4.15378 13.1356L8.21325 16.7407ZM10.9468 2.54978C8.64995 -0.0915376 4.6793 -0.20716 2.25237 2.35955L2.25232 2.35959C0.4442 4.27233 -0.0130138 7.3889 1.10781 9.86143L1.10788 9.86158C1.75297 11.2834 2.69966 12.4819 3.81607 13.5044L3.81627 13.5045C5.15565 14.7299 6.5245 15.9276 7.88861 17.121C8.46282 17.6234 9.03619 18.1251 9.60618 18.6278L9.60621 18.6278C10.03 19.0015 10.4726 19.2846 10.9878 19.2843C11.5014 19.284 11.9445 19.0018 12.3688 18.6335L12.3688 18.6335C12.837 18.2271 13.3173 17.8162 13.7991 17.404C14.3709 16.9148 14.9449 16.4238 15.5039 15.9358L15.5039 15.9358C15.6168 15.8372 15.7302 15.7385 15.8439 15.6395C17.2162 14.445 18.6353 13.2097 19.7761 11.691C21.4889 9.41137 22.0466 6.87673 20.8837 4.13274L20.4233 4.32784L20.8837 4.13273C19.3398 0.49 14.8253 -0.654354 11.7905 1.82308L11.7902 1.8233C11.5031 2.05799 11.2207 2.30746 10.9468 2.54978ZM11.2663 2.93477C11.2147 2.87335 11.1658 2.81481 11.1175 2.75462L12.1066 2.21041C11.8224 2.4428 11.5475 2.68604 11.2726 2.92925C11.2705 2.93109 11.2684 2.93293 11.2663 2.93477Z" fill="#FFC00B" />
                   </svg>
                 </a>
                 <div class="food-image">
                   <img src="{{ $dish->dish->price }}" class="img-fluid" width="100" height="100" />
                 </div>
                 <h4 class="food-name-text">{{ $dish->dish->name_en }}</h4>
                 <p class="food-price">€ {{ $dish->dish->price }}</p>

                 <button type="button" class="btn btn-xs-sm btn-custom-yellow" onclick="addToCart({{ $dish->dish->id }})" id="dish-cart-lbl-{{ $dish->dish->id }}" {{ $dish->dish->cart ? 'disabled':''}}>
                    @if($dish->dish->cart)
                      Added to cart
                    @else
                      Add  
                      <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                       <path d="M4.77344 0.167969L4.77344 8.16797" stroke="#292929" stroke-width="2" />
                       <line x1="8.88281" y1="4.16797" x2="0.664631" y2="4.16797" stroke="#292929" stroke-width="2" />
                      </svg>
                    @endif
                 </button>

                 <a href="javascript:void(0);" class="customize-foodlink" data-bs-toggle="modal" data-bs-target="#customisableModal">Customisable</a>
               </div>
               @endforeach
               @endif
             </div>
           </section>
           <!-- end category list section -->
         </div>
       </main>
     </div>
   </div>
     <!-- start footer -->
     @include('layouts.user.footer_design')
     <!-- end footer -->
 </div>

@include('user.modals.change-password')
@include('user.modals.customize-dish')

@endsection

