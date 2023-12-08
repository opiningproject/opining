@extends('layouts.user-app')
@section('content')
<div class="main">
  <div class="main-view">
    <div class="container-fluid bd-gutter bd-layout">
      @include('layouts.user.side_nav_bar')
      <main class="bd-main order-1">
        <div class="main-content">
          <div class="section-page-title main-page-title row justify-content-between">
            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
              <h1 class="page-title">Dashboard</h1>
            </div>
            <div class="form-group mb-0 has-search position-relative searcheatbox col-xxl-4 col-xl-4 col-lg-7 col-md-6 col-sm-12 col-12 text-end">
              <span class="form-control-feedback">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                  <path d="M23.5119 23.1552L19.281 18.9243C20.1552 17.6068 20.6668 16.0293 20.6668 14.3334C20.6668 9.73837 16.9285 6 12.3334 6C7.73837 6 4 9.73837 4 14.3334C4 18.9285 7.73837 22.6668 12.3334 22.6668C14.0293 22.6668 15.6068 22.1552 16.9243 21.281L21.1552 25.5119C21.8052 26.1627 22.8619 26.1627 23.5119 25.5119C24.1627 24.861 24.1627 23.806 23.5119 23.1552ZM6.50003 14.3334C6.50003 11.1167 9.11672 8.50003 12.3334 8.50003C15.5501 8.50003 18.1668 11.1167 18.1668 14.3334C18.1668 17.5501 15.5501 20.1668 12.3334 20.1668C9.11672 20.1668 6.50003 17.5501 6.50003 14.3334Z" fill="#FFC00B" />
                </svg>
              </span>
              <input type="text" class="form-control text-transform-none" placeholder="What do you want eat today..." />
            </div>
          </div>
          <div class="offer-card-banner offercard-slider">
            <div class="card position-relative">
              <div class="bg-offercard-circle-1">
                <svg width="175" height="102" viewBox="0 0 175 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.25" d="M175 142.5C175 221.201 111.201 285 32.5 285C-46.2006 285 -110 221.201 -110 142.5C-110 63.7994 -46.2006 0 32.5 0C111.201 0 175 63.7994 175 142.5ZM-61.1995 142.5C-61.1995 194.249 -19.2488 236.2 32.5 236.2C84.2488 236.2 126.2 194.249 126.2 142.5C126.2 90.7512 84.2488 48.8005 32.5 48.8005C-19.2488 48.8005 -61.1995 90.7512 -61.1995 142.5Z" fill="white" />
                </svg>
              </div>
              <div class="bg-offercard-circle-2">
                <svg width="285" height="114" viewBox="0 0 285 114" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.25" d="M285 -28.5C285 50.2006 221.201 114 142.5 114C63.7994 114 0 50.2006 0 -28.5C0 -107.201 63.7994 -171 142.5 -171C221.201 -171 285 -107.201 285 -28.5ZM48.8005 -28.5C48.8005 23.2488 90.7512 65.1995 142.5 65.1995C194.249 65.1995 236.2 23.2488 236.2 -28.5C236.2 -80.2488 194.249 -122.2 142.5 -122.2C90.7512 -122.2 48.8005 -80.2488 48.8005 -28.5Z" fill="white" />
                </svg>
              </div>
              <div class="bg-offercard-circle-3">
                <svg width="175" height="144" viewBox="0 0 175 144" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.25" d="M285 142.5C285 221.201 221.201 285 142.5 285C63.7994 285 0 221.201 0 142.5C0 63.7994 63.7994 0 142.5 0C221.201 0 285 63.7994 285 142.5ZM48.8005 142.5C48.8005 194.249 90.7512 236.2 142.5 236.2C194.249 236.2 236.2 194.249 236.2 142.5C236.2 90.7512 194.249 48.8005 142.5 48.8005C90.7512 48.8005 48.8005 90.7512 48.8005 142.5Z" fill="white" />
                </svg>
              </div>
              <div class="card-body">
                <h2>Get Discount Voucher Up To 20%</h2>
                <p class="mb-0"> Every 5th order you will get a 20% discount voucher! </p>
              </div>
            </div>
          </div>
          <!-- start category section -->
          <section class="custom-section category-section pb-0">
            <div class="section-page-title">
              <h1 class="section-title">Category</h1>
              <div class="category-slider-navigation">
                <!-- Add Arrows -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
              </div>
            </div>
            <div class="swiper-container">
              <div class="swiper category-swiper-slider">
                <div class="category-slider swiper-wrapper">
                  @foreach ($categories as $category)
                  <div class="category-element swiper-slide">
                    <div class="card">
                      <span class="dish-item-icon">
                        <img src="{{ $category->image }}" class="img-fluid" alt="bakery" width="56" height="56" />
                      </span>
                      <p class="mb-0">{{ $category->name }}</p>
                      <a href="#" class="stretched-link"></a>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </section>
          <!-- end category section -->
          <!-- start category list section -->
          <section class="custom-section category-list-section pb-0">
            <div class="section-page-title">
              <h1 class="section-title">Burgers</h1>
              <a href="{{ route('user.dashboard') }}?all=1" type="button" class="viewall-btn">View all <span>
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="chevron-down">
                      <path id="Vector" d="M15.0002 11.9998C15.0009 12.1314 14.9757 12.2619 14.926 12.3837C14.8762 12.5056 14.8029 12.6164 14.7102 12.7098L10.7102 16.7098C10.5219 16.8981 10.2665 17.0039 10.0002 17.0039C9.73388 17.0039 9.47849 16.8981 9.29018 16.7098C9.10188 16.5215 8.99609 16.2661 8.99609 15.9998C8.99609 15.7335 9.10188 15.4781 9.29018 15.2898L12.5902 11.9998L9.30018 8.70982C9.13636 8.51851 9.05075 8.27244 9.06047 8.02076C9.07019 7.76909 9.17453 7.53035 9.35262 7.35225C9.53072 7.17416 9.76945 7.06983 10.0211 7.06011C10.2728 7.05038 10.5189 7.13599 10.7102 7.29982L14.7102 11.2998C14.8949 11.4861 14.9991 11.7375 15.0002 11.9998Z" fill="#292929" />
                    </g>
                  </svg>
                </span>
              </a>
            </div>
            <div class="category-list-item-grid">
              @foreach ($dishes as $dish)
              <div class="card food-detail-card">
                <p class="mb-0 offer-percantage">{{ $dish->percentage_off }}%</p>

                <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? 'd-none':'' }}" onclick="favorite({{ $dish->id }})" id="unfavorite-icon-{{ $dish->id }}">
                  <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.7905 1.82308L11.7902 1.8233C11.5031 2.05799 11.2207 2.30746 10.9468 2.54978C8.64995 -0.0915376 4.6793 -0.20716 2.25237 2.35955L2.25232 2.35959C0.4442 4.27233 -0.0130138 7.3889 1.10781 9.86143L1.10788 9.86158C1.75297 11.2834 2.69966 12.4819 3.81607 13.5044L3.81627 13.5045C5.15565 14.7299 6.52448 15.9275 7.88859 17.121C8.46281 17.6234 9.03619 18.1251 9.60618 18.6278L9.60621 18.6278C10.03 19.0015 10.4726 19.2846 10.9878 19.2843C11.5014 19.284 11.9445 19.0018 12.3688 18.6335L12.3688 18.6335C12.837 18.2271 13.3173 17.8162 13.7991 17.404C14.3708 16.9149 14.9449 16.4238 15.5039 15.9358L15.5039 15.9358C15.6168 15.8372 15.7302 15.7385 15.8439 15.6395C17.2162 14.445 18.6353 13.2097 19.7761 11.691C21.4889 9.41137 22.0466 6.87673 20.8837 4.13274L20.4233 4.32784L20.8837 4.13273C19.3398 0.49 14.8253 -0.654354 11.7905 1.82308Z" stroke="#AFAFAF" />
                  </svg>
                </p>

                <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? '':'d-none' }}" onclick="unFavorite({{ $dish->id }})" id="favorite-icon-{{ $dish->id }}">
                  <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9.9369 18.2528C10.7426 18.9633 11.2314 18.9586 12.0411 18.2559C12.5184 17.8416 12.9987 17.4307 13.479 17.0198C14.0459 16.5349 14.6129 16.0499 15.175 15.5591C15.2862 15.462 15.3976 15.3651 15.5089 15.2681C16.8886 14.0669 18.2688 12.8652 19.3763 11.3906L9.9369 18.2528ZM9.9369 18.2528C9.36367 17.7472 8.78845 17.244 8.21325 16.7407M9.9369 18.2528L8.21325 16.7407M8.21325 16.7407C6.85099 15.5488 5.48887 14.3571 4.15378 13.1356L8.21325 16.7407ZM10.9468 2.54978C8.64995 -0.0915376 4.6793 -0.20716 2.25237 2.35955L2.25232 2.35959C0.4442 4.27233 -0.0130138 7.3889 1.10781 9.86143L1.10788 9.86158C1.75297 11.2834 2.69966 12.4819 3.81607 13.5044L3.81627 13.5045C5.15565 14.7299 6.5245 15.9276 7.88861 17.121C8.46282 17.6234 9.03619 18.1251 9.60618 18.6278L9.60621 18.6278C10.03 19.0015 10.4726 19.2846 10.9878 19.2843C11.5014 19.284 11.9445 19.0018 12.3688 18.6335L12.3688 18.6335C12.837 18.2271 13.3173 17.8162 13.7991 17.404C14.3709 16.9148 14.9449 16.4238 15.5039 15.9358L15.5039 15.9358C15.6168 15.8372 15.7302 15.7385 15.8439 15.6395C17.2162 14.445 18.6353 13.2097 19.7761 11.691C21.4889 9.41137 22.0466 6.87673 20.8837 4.13274L20.4233 4.32784L20.8837 4.13273C19.3398 0.49 14.8253 -0.654354 11.7905 1.82308L11.7902 1.8233C11.5031 2.05799 11.2207 2.30746 10.9468 2.54978ZM11.2663 2.93477C11.2147 2.87335 11.1658 2.81481 11.1175 2.75462L12.1066 2.21041C11.8224 2.4428 11.5475 2.68604 11.2726 2.92925C11.2705 2.93109 11.2684 2.93293 11.2663 2.93477Z" fill="#FFC00B"></path>
                  </svg>
                </p>
                <div class="food-image">
                  <img src="{{ $dish->image }}" alt="burger imag" class="img-fluid" width="100" height="100" />
                </div>
                <h4 class="food-name-text">{{ $dish->name }}</h4>
                <p class="food-price">€{{ $dish->price }}</p>
                <a class="btn btn-xs-sm btn-custom-yellow">Add <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                    <path d="M4.77344 0.167969L4.77344 8.16797" stroke="#292929" stroke-width="2" />
                    <line x1="8.88281" y1="4.16797" x2="0.664631" y2="4.16797" stroke="#292929" stroke-width="2" />
                  </svg>
                </a>
                <a href="javascript:void(0);" class="customize-foodlink" data-bs-toggle="modal" data-bs-target="#customisableModal">Customize</a>
              </div>
               @endforeach
            </div>
          </section>
          <!-- end category list section -->
        </div>
        <aside class="cart-sidebar position-relative">
          <div class="offcanvas-lg offcanvas-end h-100" tabindex="-1" id="bdSidebarCart" aria-labelledby="bdSidebarCartOffcanvasLabel">
            <div class="offcanvas-header p-0" style="display: block"></div>
            <div class="offcanvas-body h-100">
              <div class="navbar navbar-expand-lg pt-0 h-100">
                <div class="cart-sidebar-content position-relative h-100">
                  <div class="navbar-collapse cartbox-collapse">
                    <!-- start emptry card section -->
                    <div class="empty-card-div w-100">
                      <p class="empty-card-text text-muted-1"> Your cart is empty </p>
                      <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="132" height="128" viewBox="0 0 132 128" fill="none">
                          <g opacity="0.2">
                            <path d="M123.175 70.94C120.515 88.3409 117.854 105.742 115.146 123.458C119.352 123.458 123.377 123.458 127.407 123.458C128.269 123.458 129.272 123.215 129.949 123.571C130.806 124.026 131.964 124.997 131.948 125.721C131.933 126.459 130.734 127.312 129.881 127.834C129.375 128.144 128.538 127.927 127.851 127.927C86.6169 127.927 45.3829 127.927 4.14886 127.922C2.3819 127.922 0.0208014 128.299 0.000135318 125.71C-0.0205308 123.106 2.33024 123.473 4.10236 123.463C8.14258 123.437 12.1828 123.453 16.4607 123.277C8.44224 119.939 8.18391 113.29 8.85039 105.83H11.2528C23.3063 105.83 35.3547 105.783 47.4082 105.897C48.6791 105.907 50.1929 106.594 51.1642 107.457C53.7992 109.797 56.2378 112.36 58.6867 114.902C60.2263 116.504 61.7246 117.857 64.0185 115.486C64.5145 118.369 64.9279 120.802 65.3618 123.323H69.7276C67.0565 105.793 64.3957 88.3615 61.7349 70.9245C65.4445 70.3717 67.7643 71.467 69.1437 74.8252C74.1346 86.9769 87.9551 92.9029 102.096 88.0205C108.456 85.8248 112.796 81.3454 115.539 75.2334C117.218 71.4928 119.342 70.3097 123.17 70.9297L123.175 70.94ZM91.3908 94.8972C84.6382 94.8869 79.2443 100.301 79.296 107.049C79.3476 113.657 84.7311 119.04 91.3185 119.066C97.9884 119.092 103.48 113.554 103.418 106.863C103.356 100.219 98.0246 94.9075 91.3908 94.8972Z" fill="#804537" />
                            <path d="M83.6825 45.3508C78.6555 41.0006 72.3058 39.5436 65.3465 39.6728C56.2431 39.8381 47.1345 39.7141 37.7469 39.7141C36.972 33.132 36.2176 26.6997 35.4375 20.0762H94.3566C93.5971 26.6842 92.8583 33.1423 92.1143 39.6005C92.0575 40.112 91.8921 40.6286 91.9283 41.1349C92.1143 43.6097 90.9983 44.3743 88.5752 44.24C87.1544 44.1625 85.6923 44.8652 83.6877 45.3508H83.6825Z" fill="#4482C3" />
                            <path d="M61.5908 66.0055H9.03174C7.19246 57.4962 13.7798 47.5197 23.002 44.9674C24.9653 44.4249 27.0681 44.1976 29.114 44.1872C41.9322 44.1201 54.7503 44.1407 67.5633 44.1562C72.022 44.1614 76.1604 45.1896 79.5341 47.8555C77.4624 48.6408 74.7138 48.8681 73.5771 50.3406C72.3527 51.9319 72.642 54.6856 72.208 57.3412C70.5031 57.3412 68.5604 57.3206 66.6178 57.3412C62.9806 57.3826 61.6683 58.6897 61.596 62.3321C61.5701 63.5101 61.596 64.688 61.596 66.0055H61.5908ZM30.2042 55.6621C31.098 54.7735 32.6273 53.9675 32.7461 52.9858C32.9889 50.9606 31.1858 50.7229 29.5583 50.7229C27.9981 50.7229 26.4274 51.0174 26.4171 52.8877C26.4068 54.9078 28.0291 55.2229 30.2042 55.6569V55.6621ZM55.2876 55.6466C57.4214 55.1661 59.1677 55.1661 59.2607 53.022C59.3485 51.0432 57.7934 50.7436 56.2176 50.7332C54.5902 50.7229 52.7664 50.8779 52.9782 52.9962C53.0764 53.9468 54.4765 54.7683 55.2825 55.6518L55.2876 55.6466ZM41.989 60.0071C44.0866 59.5215 45.8742 59.6403 46.0396 57.491C46.1739 55.7551 44.9133 55.1558 43.322 55.1661C41.6687 55.1764 39.6692 55.0008 39.7622 57.3257C39.7984 58.2454 41.2089 59.1133 41.9942 60.0071H41.989Z" fill="#FFC00B" />
                            <path d="M30.9348 15.2817C30.8728 14.8529 30.7901 14.5274 30.7798 14.2019C30.5524 9.11802 30.8418 8.81836 35.9825 8.81836C55.1503 8.81836 74.3181 8.81836 93.4859 8.81836C99.1691 8.81836 99.5049 9.21102 98.8797 15.2817H30.9348Z" fill="#D1D4D1" />
                            <path d="M15.4062 77.2214V70.7891H57.1776C57.4979 72.7472 57.8389 74.8035 58.2367 77.2214C56.8728 77.2214 55.7671 77.3454 54.6977 77.2007C51.0191 76.6892 48.3067 78.0997 45.9094 80.8638C43.3262 83.8397 40.3967 86.516 37.3588 89.5849C34.2331 86.4333 31.1073 83.5245 28.2709 80.3575C26.1371 77.9705 23.745 76.8597 20.5624 77.1956C18.9608 77.366 17.3282 77.2265 15.4062 77.2265V77.2214Z" fill="#F0C419" />
                            <path d="M15.457 101.457V94.9941H60.9483C61.6664 99.7318 62.4466 104.459 63.0304 109.207C63.1182 109.9 62.2761 110.711 61.6871 111.796C58.8352 108.882 56.2571 106.361 53.8081 103.71C52.2892 102.067 50.5377 101.416 48.3213 101.426C38.4274 101.488 28.5335 101.452 18.6448 101.452C17.6321 101.452 16.6143 101.452 15.4622 101.452L15.457 101.457Z" fill="#14A085" />
                            <path d="M92.1194 4.35351H37.7727C36.9151 1.07793 37.6642 0.0136306 40.9502 0.0136306C56.9561 -0.00186894 72.9568 -0.00703547 88.9627 0.0136306C92.0884 0.0136306 92.7239 0.922939 92.1194 4.35351Z" fill="#E6E7E8" />
                            <path d="M88.0886 48.6621H94.4899V85.0758C92.8056 85.0758 91.1162 85.1894 89.4577 85.0086C88.9566 84.9518 88.1454 84.0941 88.1403 83.6033C88.0679 72.0251 88.0834 60.4418 88.0834 48.6673L88.0886 48.6621Z" fill="#F0C419" />
                            <path d="M99.2031 53.1094H105.713V60.6267C105.713 66.1238 105.713 71.6159 105.713 77.113C105.713 81.6544 104.075 83.411 99.2031 84.0207V53.1094Z" fill="#F3D55B" />
                            <path d="M83.4774 83.2414C78.5589 81.7896 76.9883 79.7953 76.9883 75.1299C76.9883 68.7699 76.9883 62.4099 76.9883 56.0499C76.9883 55.1251 76.9883 54.2055 76.9883 53.1309H83.4774V83.2414Z" fill="#F3D55B" />
                            <path d="M31.3004 90.3192C25.0644 90.3192 18.8232 90.4226 12.5924 90.2624C10.3398 90.2056 8.6555 87.9685 8.71233 85.8399C8.764 83.7578 10.3605 81.8151 12.5769 81.686C15.8318 81.4948 19.1074 81.5827 22.3726 81.6137C22.8376 81.6137 23.4008 81.8565 23.7366 82.1768C26.4025 84.6774 29.0271 87.2193 31.6672 89.7509C31.5432 89.9421 31.4192 90.1281 31.3004 90.3192Z" fill="#804537" />
                            <path d="M58.8461 81.4477C59.3163 84.4753 59.7503 87.2445 60.2101 90.2153H42.8867C45.8781 87.2342 48.2496 84.0826 51.3598 82.078C53.1578 80.9207 56.1492 81.6027 58.8461 81.4477Z" fill="#804537" />
                            <path d="M110.18 74.7204V59.7168H116.684C116.684 62.0469 116.695 64.3202 116.674 66.5986C116.674 66.9138 116.586 67.3064 116.39 67.5338C114.292 69.993 112.164 72.4316 110.18 74.7152V74.7204Z" fill="#F0C419" />
                            <path d="M72.5334 61.9349V70.6714C70.5701 69.385 68.3278 68.393 66.8089 66.7397C65.8892 65.7374 66.0752 63.7173 65.7188 61.9297H72.5334V61.9349Z" fill="#F0C419" />
                            <path d="M91.2415 99.2374C95.4264 99.1651 98.9862 102.632 99.0482 106.837C99.1102 111.069 95.7054 114.572 91.4689 114.629C87.2323 114.685 83.7088 111.281 83.6416 107.065C83.5744 102.88 87.036 99.3098 91.2364 99.2374H91.2415Z" fill="white" />
                          </g>
                        </svg>
                      </span>
                    </div>
                    <!--end emptry card section -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </aside>
      </main>
    </div>
  </div>
    <!-- start footer -->
    @include('layouts.user.footer_design')
    <!-- end footer -->
</div>

@if(!Auth::user())
  @include('user.modals.signin')
  @include('user.modals.signup')
  @include('user.modals.forgot-password')
@endif

@endsection

@section('script')
<script type="text/javascript">

function favorite(dish_id) 
{
    $.ajax({
        url: baseURL+'/favorite',
        type: 'POST',
        data: {
            dish_id
        },
        success: function (response) {
            console.log('success')
            if(response.status == 2)
            {
               $('#signInModal').modal('show');
               return false;
            }

            $("#unfavorite-icon-"+dish_id).addClass('d-none');
            $("#favorite-icon-"+dish_id).removeClass('d-none');

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function unFavorite(dish_id) 
{
    $.ajax({
        url: baseURL+'/unFavorite',
        type: 'POST',
        data: {
            dish_id
        },
        success: function (response) {
            console.log('unFavorite')
            console.log(response)

            $("#unfavorite-icon-"+dish_id).removeClass('d-none');
            $("#favorite-icon-"+dish_id).addClass('d-none');

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

$(window).on("load", function() {
  $("#signInModal").modal("show");
});

$(document).ready(function() {
        var swiper = new Swiper(".category-swiper-slider", {
          slidesPerView: 1,
          spaceBetween: 6,
          loop: true,
          autoplay: {
            delay: 1000,
            disableOnInteraction: false,
          },
          autoplay: false,
          pagination: false,
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
          breakpoints: {
            375: {
              slidesPerView: 2,
              spaceBetween: 20,
              autoplay: false,
            },
            425: {
              slidesPerView: 2,
              spaceBetween: 20,
              autoplay: false,
            },
            567: {
              slidesPerView: 2,
              spaceBetween: 20,
              autoplay: false,
            },
            640: {
              slidesPerView: 3,
              spaceBetween: 20,
              autoplay: false,
            },
            700: {
              slidesPerView: 3,
              spaceBetween: 20,
              autoplay: false,
            },
            758: {
              slidesPerView: 4,
              spaceBetween: 40,
              autoplay: false,
            },
            768: {
              slidesPerView: 4,
              spaceBetween: 40,
              autoplay: false,
            },
            800: {
              slidesPerView: 4,
              spaceBetween: 40,
              autoplay: false,
            },
            988: {
              slidesPerView: 3,
              spaceBetween: 10,
            },
            1024: {
              slidesPerView: 3,
              spaceBetween: 10,
            },
            1100: {
              slidesPerView: 3,
              spaceBetween: 20,
            },
            1200: {
              slidesPerView: 3,
              spaceBetween: 20,
            },
            1300: {
              slidesPerView: 3,
              spaceBetween: 20,
            },
            1400: {
              slidesPerView: 3,
              spaceBetween: 20,
            },
            1700: {
              slidesPerView: 6,
              spaceBetween: 30,
            },
            1800: {
              slidesPerView: 6,
              spaceBetween: 30,
            },
            1920: {
              slidesPerView: 6,
              spaceBetween: 30,
            },
            2560: {
              slidesPerView: 6,
              spaceBetween: 30,
            },
          },
        });
      });
</script>
@endsection


