@extends('layouts.user-app')
@section('content')

    <?php

    $zipcode = session('zipcode');
    $house_no = session('house_no');

    $showModal = 0;

    if (!session('showLoginModal')) {
        $showModal = 1;
        Session::put('showLoginModal', '1', '1440');
    }

    $cartValue = 0;

    ?>
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout"> @include('layouts.user.side_nav_bar')
                <main class="bd-main">
                    <div class="main-content">
                        <div class="section-page-title main-page-title row justify-content-between">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">Dashboard</h1>
                            </div>
                            <div
                                class="d-flex align-items-center form-group mb-0 has-search position-relative searcheatbox col-xxl-4 col-xl-4 col-lg-7 col-md-6 col-sm-12 col-12 text-end">
              <span class="form-control-feedback">
                <img class="svg" src="{{ asset('images/search.svg') }}" alt="" height="32" width="32">
              </span>
                                <input type="text" class="form-control text-transform-none form-control-icon ps-5"
                                       placeholder="What do you want eat today..." id="search-dish"/>

                                <button
                                    class="navbar-toggler bag-count d-flex  dashboard-cart-navbar-toggler cart-navbar-toggler ms-2  p-0 d-none"
                                    type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebarCart"
                                    aria-controls="bdSidebarCart" aria-label="Toggle docs navigation">

                                     <span
                                         class="count cart-item-count">{{ isset(Auth::user()->cart) ? Auth::user()->cart->dishDetails->count() : 0 }}</span>

                                    <svg width="22px" height="22px" viewBox="-4 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                            <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-572.000000, -723.000000)"
                                               fill="#FFC00B">
                                                <path
                                                    d="M594,747 L574,747 L574,731 C574,729.896 574.896,729 576,729 L578,729 L578,735 L580,735 L580,729 L588,729 L588,735 L590,735 L590,729 L592,729 C593.104,729 594,729.896 594,731 L594,747 L594,747 Z M594,751 C594,752.104 593.104,753 592,753 L576,753 C574.896,753 574,752.104 574,751 L574,749 L594,749 L594,751 L594,751 Z M584,725 C586.209,725 588,725.619 588,727 L580,727 C580,725.619 581.791,725 584,725 L584,725 Z M592,727 L590,727 C590,724.791 587.313,723 584,723 C580.687,723 578,724.791 578,727 L576,727 C573.791,727 572,728.791 572,731 L572,751 C572,753.209 573.791,755 576,755 L592,755 C594.209,755 596,753.209 596,751 L596,731 C596,728.791 594.209,727 592,727 L592,727 Z"
                                                    id="bag" sketch:type="MSShapeGroup"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </button>


{{--                                <button--}}
{{--                                    class="navbar-toggler  dashboard-cart-navbar-toggler cart-navbar-toggler ms-2  p-2 d-none"--}}
{{--                                    type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebarCart"--}}
{{--                                    aria-controls="bdSidebarCart" aria-label="Toggle docs navigation">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 22" fill="none"--}}
{{--                                         class="svg inlined-svg" width="18" height="22" role="presentation"--}}
{{--                                         aria-hidden="true">--}}
{{--                                        <path--}}
{{--                                            d="M16.9551 17.9753C17.1325 19.5552 15.9495 20.6608 14.6868 20.9187C14.4719 20.9625 14.2493 20.9945 14.0305 20.9953C10.6596 21 7.28882 21.0023 3.918 20.9968C2.56154 20.9945 1.35589 20.1451 1.06913 18.9395M16.9551 17.9753L17.1539 17.953M16.9551 17.9753C16.8355 16.9081 16.7483 15.8374 16.6611 14.7667C16.6184 14.2428 16.5758 13.719 16.5293 13.1956L17.1539 17.953M16.9551 17.9753L17.1539 17.953C17.1539 17.953 17.1539 17.953 17.1539 17.953M17.1539 17.953C17.3458 19.6623 16.0625 20.8419 14.7268 21.1147L14.7267 21.1147C14.505 21.1598 14.2681 21.1944 14.0312 21.1953L14.0308 21.1953C10.6598 21.2 7.28879 21.2023 3.91765 21.1968C2.48532 21.1944 1.18634 20.2966 0.874554 18.9858L0.874533 18.9857C0.767044 18.5329 0.797287 18.0422 0.833078 17.608L0.8331 17.6077C0.994391 15.6833 1.1669 13.7595 1.33935 11.8362C1.39921 11.1686 1.45907 10.5011 1.51845 9.83369L1.71766 9.85139M17.1539 17.953C17.0346 16.8887 16.9478 15.8233 16.8608 14.7544C16.818 14.2299 16.7752 13.7045 16.7285 13.178L16.7285 13.1779C16.6453 12.2437 16.5613 11.3098 16.4774 10.376C16.3343 8.78414 16.1912 7.19262 16.0519 5.60049L16.0519 5.60045C16.0269 5.31629 15.9719 5.06644 15.795 4.90048C15.617 4.73353 15.3628 4.69518 15.0687 4.69438L15.0686 4.69438C14.6044 4.69335 14.1397 4.69369 13.6658 4.69403C13.486 4.69416 13.305 4.69429 13.1221 4.69435C13.0262 3.64985 12.6434 2.7409 11.8888 2.00188C11.0833 1.21267 10.1061 0.80578 8.97603 0.800044L8.9759 0.800043C8.04351 0.795939 7.19783 1.08423 6.46117 1.6519L6.46101 1.65202C5.46577 2.42054 4.94149 3.44769 4.82711 4.69432C4.65576 4.6942 4.48704 4.69394 4.32033 4.69369C3.78797 4.69289 3.27614 4.69211 2.76479 4.69595L17.1539 17.953ZM1.71766 9.85139C1.65826 10.5192 1.59838 11.1869 1.53851 11.8546C1.36607 13.7776 1.19364 15.7006 1.0324 17.6244C0.996459 18.0605 0.969892 18.5215 1.06913 18.9395M1.71766 9.85139L1.51845 9.83367M1.71766 9.85139C1.84659 8.40039 1.97551 6.94938 2.10678 5.49916C2.14429 5.08269 2.34198 4.89907 2.76626 4.89595L1.51845 9.83367M1.06913 18.9395H1.06912H1.06913ZM1.51845 9.83367L1.51845 9.83364C1.64737 8.38271 1.77631 6.93159 1.90759 5.48123L1.51845 9.83367ZM12.2951 8.20426C11.9481 8.15113 11.8239 7.90812 11.82 7.59011C11.8156 7.22932 11.8166 6.86852 11.8176 6.50057C11.8178 6.40663 11.8181 6.31221 11.8182 6.21721H11.6182M12.2951 8.20426L6.12536 6.21721H6.32536M12.2951 8.20426L12.2648 8.40196C12.2647 8.40195 12.2646 8.40193 12.2646 8.40192M12.2951 8.20426L12.2644 8.4019C12.2644 8.40191 12.2645 8.40191 12.2646 8.40192M11.6182 6.21721C11.6183 6.15077 11.6184 6.08411 11.6184 6.01721H6.32536V6.01815V6.01909V6.02003V6.02096V6.0219V6.02283V6.02377V6.0247V6.02564V6.02657V6.02751V6.02844V6.02937V6.03031V6.03124V6.03217V6.0331V6.03403V6.03496V6.03589V6.03682V6.03775V6.03868V6.03961V6.04053V6.04146V6.04239V6.04331V6.04424V6.04516V6.04609V6.04701V6.04794V6.04886V6.04978V6.0507V6.05163V6.05255V6.05347V6.05439V6.05531V6.05623V6.05715V6.05807V6.05899V6.05991V6.06083V6.06174V6.06266V6.06358V6.06449V6.06541V6.06632V6.06724V6.06815V6.06907V6.06998V6.07089V6.07181V6.07272V6.07363V6.07454V6.07545V6.07636V6.07728V6.07819V6.07909V6.08V6.08091V6.08182V6.08273V6.08364V6.08454V6.08545V6.08636V6.08726V6.08817V6.08907V6.08998V6.09088V6.09179V6.09269V6.09359V6.0945V6.0954V6.0963V6.0972V6.0981V6.099V6.0999V6.1008V6.1017V6.1026V6.1035V6.1044V6.1053V6.1062V6.10709V6.10799V6.10889V6.10978V6.11068V6.11158V6.11247V6.11337V6.11426V6.11515V6.11605V6.11694V6.11783V6.11873V6.11962V6.12051V6.1214V6.12229V6.12318V6.12407V6.12496V6.12585V6.12674V6.12763V6.12852V6.12941V6.1303V6.13118V6.13207V6.13296V6.13384V6.13473V6.13561V6.1365V6.13738V6.13827V6.13915V6.14004V6.14092V6.1418V6.14269V6.14357V6.14445V6.14533V6.14622V6.1471V6.14798V6.14886V6.14974V6.15062V6.1515V6.15238V6.15326V6.15413V6.15501V6.15589V6.15677V6.15764V6.15852V6.1594V6.16027V6.16115V6.16202V6.1629V6.16377V6.16465V6.16552V6.1664V6.16727V6.16814V6.16902V6.16989V6.17076V6.17163V6.17251V6.17338V6.17425V6.17512V6.17599V6.17686V6.17773V6.1786V6.17947V6.18034V6.18121V6.18207V6.18294V6.18381V6.18468V6.18554V6.18641V6.18728V6.18814V6.18901V6.18987V6.19074V6.1916V6.19247V6.19333V6.1942V6.19506V6.19592V6.19679V6.19765V6.19851V6.19938V6.20024V6.2011V6.20196V6.20282V6.20368V6.20454V6.2054V6.20626V6.20712V6.20798V6.20884V6.2097V6.21056V6.21142V6.21228V6.21313V6.21399V6.21485V6.21571V6.21656V6.21721M11.6182 6.21721H6.32536M11.6182 6.21721C11.6181 6.31134 11.6178 6.40504 11.6176 6.49839C11.6166 6.86703 11.6156 7.23021 11.62 7.59252L11.62 7.59256C11.6222 7.77373 11.6585 7.95888 11.765 8.11112C11.8758 8.26967 12.0458 8.36837 12.2646 8.40192M6.32536 6.21721V6.21742V6.21828V6.21913V6.21999V6.22084V6.2217V6.22255V6.22341V6.22426V6.22511V6.22597V6.22682V6.22768V6.22853V6.22938V6.23023V6.23109V6.23194V6.23279V6.23364V6.23449V6.23534V6.23619V6.23704V6.23789V6.23874V6.23959V6.24044V6.24129V6.24214V6.24299V6.24384V6.24469V6.24554V6.24638V6.24723V6.24808V6.24893V6.24977V6.25062V6.25146V6.25231V6.25316V6.254V6.25485V6.25569V6.25654V6.25738V6.25823V6.25907V6.25992V6.26076V6.2616V6.26245V6.26329V6.26413V6.26498V6.26582V6.26666V6.2675V6.26834V6.26919V6.27003V6.27087V6.27171V6.27255V6.27339V6.27423V6.27507V6.27591V6.27675V6.27759V6.27843V6.27927V6.28011V6.28095V6.28178V6.28262V6.28346V6.2843V6.28514V6.28597V6.28681V6.28765V6.28848V6.28932V6.29016V6.29099V6.29183V6.29267V6.2935V6.29434V6.29517V6.29601V6.29684V6.29768V6.29851V6.29935V6.30018V6.30101V6.30185V6.30268V6.30352V6.30435V6.30518V6.30602V6.30685V6.30768V6.30851V6.30934V6.31018V6.31101V6.31184V6.31267V6.3135V6.31433V6.31517V6.316V6.31683V6.31766V6.31849V6.31932V6.32015V6.32098V6.32181V6.32264V6.32347V6.3243V6.32512V6.32595V6.32678V6.32761V6.32844V6.32927V6.3301V6.33092V6.33175V6.33258V6.33341V6.33423V6.33506V6.33589V6.33672V6.33754V6.33837V6.3392V6.34002V6.34085V6.34167V6.3425V6.34333V6.34415V6.34498V6.3458V6.34663V6.34745V6.34828V6.3491V6.34993V6.35075V6.35158V6.3524V6.35322V6.35405V6.35487V6.3557V6.35652V6.35734V6.35817V6.35899V6.35981V6.36064V6.36146V6.36228V6.36311V6.36393V6.36475V6.36557V6.36639V6.36722V6.36804V6.36886V6.36968V6.3705V6.37133V6.37215V6.37297V6.37379V6.37461V6.37543V6.37625V6.37707V6.3779V6.37872V6.37954V6.38036V6.38118V6.382V6.38282V6.38364V6.38446V6.38528V6.3861V6.38692V6.38774V6.38856V6.38938V6.39019V6.39101V6.39183V6.39265V6.39347V6.39429V6.39511V6.39593V6.39675V6.39756V6.39838V6.3992V6.40002V6.40084V6.40166V6.40247V6.40329V6.40411V6.40493V6.40575V6.40656V6.40738V6.4082V6.40902V6.40983V6.41065V6.41147V6.41228V6.4131V6.41392V6.41474V6.41555V6.41637V6.41719V6.418V6.41882V6.41964V6.42045V6.42127V6.42209V6.4229V6.42372V6.42454V6.42535V6.42617V6.42698V6.4278V6.42862V6.42943V6.43025V6.43106V6.43188V6.4327V6.43351V6.43433V6.43514V6.43596V6.43678V6.43759V6.43841V6.43922V6.44004V6.44085V6.44167V6.44248V6.4433V6.44411V6.44493V6.44574V6.44656V6.44738V6.44819V6.44901V6.44982V6.45064V6.45145V6.45227V6.45308V6.4539V6.45471V6.45553V6.45634V6.45711C6.32493 6.56817 6.3253 6.6805 6.32566 6.79362C6.32661 7.08508 6.32757 7.38185 6.31503 7.67598M6.31503 7.67598L14.1124 19.6897C14.6799 19.6378 15.0772 19.4442 15.3229 19.1506C15.5686 18.8571 15.6881 18.4333 15.6378 17.8688L15.6378 17.8688C15.5597 16.991 15.4816 16.1132 15.4035 15.2354C15.1693 12.6009 14.935 9.96652 14.6994 7.3321C14.673 7.0388 14.6414 6.7472 14.6098 6.45555C14.6012 6.37664 14.5927 6.29773 14.5842 6.21877H13.1308C13.1311 6.31455 13.1317 6.41006 13.1323 6.50531C13.1347 6.87291 13.1369 7.23681 13.1271 7.59867L13.1271 7.59907C13.1198 7.85028 13.0396 8.07294 12.8806 8.22498C12.7183 8.38019 12.4982 8.43813 12.2646 8.40192M6.31503 7.67598L6.11521 7.66746L6.31503 7.67589C6.31503 7.67592 6.31503 7.67595 6.31503 7.67598ZM2.15623 4.89522C1.99779 5.04066 1.92865 5.24753 1.9076 5.48113L2.76476 4.69595C2.52738 4.69771 2.31454 4.74989 2.15623 4.89522ZM4.81014 7.29193C4.80844 7.41763 4.80654 7.55901 4.82083 7.69231L14.1123 19.6897C14.0004 19.6999 13.8862 19.6998 13.761 19.6998L13.7406 19.6998H13.7405C13.1293 19.6999 12.518 19.7002 11.9067 19.7005C9.34075 19.7018 6.77494 19.703 4.20957 19.6935C3.87907 19.6921 3.53969 19.6493 3.24204 19.546L3.24195 19.5459C2.88746 19.4231 2.64287 19.2384 2.49216 19.0067C2.34143 18.7749 2.27181 18.4764 2.30297 18.1029L2.30298 18.1027C2.42835 16.5886 2.56461 15.0758 2.70093 13.5623C2.7642 12.8599 2.82748 12.1573 2.88969 11.4544L2.69047 11.4368L2.88969 11.4544C2.96078 10.6509 3.03148 9.84744 3.10218 9.04401L3.10223 9.0434C3.17294 8.2398 3.24365 7.43625 3.31474 6.6327C3.32619 6.50422 3.33962 6.37679 3.35417 6.23886C3.35528 6.22832 3.3564 6.21772 3.35752 6.20705H4.81107C4.81104 6.27013 4.811 6.3331 4.81096 6.39597C4.81078 6.6533 4.81061 6.9091 4.81113 7.16467L4.81113 7.16519C4.81132 7.20476 4.81074 7.24735 4.81014 7.29193ZM11.5944 4.67407H6.35851C6.43061 3.84816 6.81715 3.21925 7.49684 2.76501L7.49687 2.76499C8.39242 2.16625 9.33411 2.12232 10.2735 2.65473L10.2735 2.65476C11.052 3.09572 11.4924 3.75716 11.5944 4.67407Z"--}}
{{--                                            fill="#FFC00B" stroke="#FFC00B" stroke-width="0.4"></path>--}}
{{--                                    </svg>--}}
{{--                                </button>--}}
                            </div>


                        </div>
                        <div class="offer-card-banner offercard-slider">
                            <div class="card position-relative">
                                <div class="bg-offercard-circle-1">
                                    <img class="svg" src="{{ asset('images/ban-grade1.svg') }}" alt="" width="175"
                                         height="102">

                                </div>
                                <div class="bg-offercard-circle-2">
                                    <img class="svg" src="{{ asset('images/ban-grade2.svg') }}" alt="" width="285"
                                         height="114">

                                </div>
                                <div class="bg-offercard-circle-3">
                                    <img class="svg" src="{{ asset('images/ban-grade3.svg') }}" alt="" width="175"
                                         height="144">

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

                            </div>
                            <div class="swiper-container">
                                <div class="category-slider-navigation">
                                    <!-- Add Arrows -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                                <div class="swiper category-swiper-slider">
                                    <div class="category-slider swiper-wrapper"> @foreach ($categories as $cat)
                                            <div class="category-element swiper-slide">
                                                <div
                                                    class="card {{ (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat->id) ? 'active':'' }}">
                      <span class="dish-item-icon">
                        <img src="{{ $cat->image }}" class="img-fluid" alt="bakery" width="56" height="56"/>
                      </span>
                                                    <p class="mb-0 text-truncate text-muted"
                                                       title="{{ $cat->name }}">{{ $cat->name }}</p>
                                                    <a href="{{ route('user.dashboard',['cat_id'=>$cat->id]) }}"
                                                       class="stretched-link"></a>
                                                </div>
                                            </div>
                                        @endforeach </div>
                                </div>
                            </div>
                        </section>
                        <!-- end category section -->
                        <!-- start category list section -->
                        <section class="custom-section category-list-section pb-0">
                            <div class="section-page-title">
                                <h1 class="section-title">{{ $category ? $category->name : ''}}</h1>
                                <a href="{{ route('user.dashboard') }}?all=1" type="button" class="viewall-btn">View all
                                    <span>
                  <img src="{{ asset('images/view.svg') }}" alt="" class="svg" height="24" width="24">
                </span>
                                </a>
                            </div>

                            <div class="dish-details-div">
                                <div class="category-list-item-grid">
                                    @if(count($dishes) > 0 )
                                        @foreach ($dishes as $dish)
                                                <?php
                                                $disableBtn = '';
                                                $customizeBtn = false;
                                                if ($dish->qty == 0 || $dish->out_of_stock == '1') {
                                                    $disableBtn = 'disabled';
                                                    $customizeBtn = true;
                                                } else if ($dish->cart) {
                                                    $disableBtn = 'disabled';
                                                }
                                                ?>
                                            <div class="card food-detail-card">
                                                <p class="mb-0 offer-percantage">{{ $dish->percentage_off }}%</p>
                                                <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? 'd-none':'' }}"
                                                   onclick="favorite({{ $dish->id }})"
                                                   id="unfavorite-icon-{{ $dish->id }}">
                                                    <img src="{{ asset('images/favorite-before-icon.svg') }}" alt=""
                                                         class="svg" height="20" width="22">
                                                </p>
                                                <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? '':'d-none' }}"
                                                   onclick="unFavorite({{ $dish->id }})"
                                                   id="favorite-icon-{{ $dish->id }}">
                                                    <img src="{{ asset('images/favorite-after-icon.svg') }}" alt=""
                                                         class="svg" height="20" width="22">

                                                </p>
                                                <div class="food-image">
                                                    <img src="{{ $dish->image }}" alt="burger imag" class="img-fluid"
                                                         width="100" height="100"/>
                                                </div>
                                                <h4 class="food-name-text">{{ $dish->name }}</h4>
                                                <p class="food-price">€{{ $dish->price }}</p>
                                                <button type="button" class="btn btn-xs-sm btn-custom-yellow"
                                                        onclick="addToCart({{ $dish->id }})"
                                                        id="dish-cart-lbl-{{ $dish->id }}" {{ $disableBtn }}>
                                                    @if($dish->qty == 0 || $dish->out_of_stock == '1')
                                                        Out of stock
                                                    @else
                                                        @if($dish->cart)
                                                            Added to cart
                                                        @else
                                                            Add
                                                            <img src="{{ asset('images/plus.svg') }}" alt="" class="svg"
                                                                 height="9" width="9">
                                                        @endif
                                                    @endif
                                                </button>
                                                @if(!$customizeBtn)
                                                    <a href="javascript:void(0);" class="customize-foodlink"
                                                       onclick="customizeDish({{ $dish->id }});">Customize</a>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        No Dish Found
                                    @endif
                                </div>
                            </div>
                        </section>
                        <!-- end category list section -->
                    </div>
                </main>
                <aside class="cart-sidebar sticky-top h-lg-100vh">
                    <div class="offcanvas-xxl offcanvas-end h-100 overflow-auto" tabindex="-1" id="bdSidebarCart"
                         aria-labelledby="bdSidebarCartOffcanvasLabel">
                        <div class="offcanvas-header p-0" style="display: block"></div>
                        <div class="offcanvas-body position-relative space-for-close">

                            <button type="button"
                                    class="btn-close d-block position-absolute d-xxl-none top-0 mt-2 end-0 me-2"
                                    data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdSidebarCart">
                            </button>

                            <div class="navbar navbar-expand-lg pt-0 h-lg-100">
                                <div class="cart-sidebar-content position-relative h-100">
                                    <div class="navbar-collapse cartbox-collapse h-100">
                                        <div class="cart-custom-tab cart-tab custom-tabs d-flex flex-column h-100">
                                            <ul class="nav nav-fill" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button
                                                        class="nav-link {{ $zipcode ? 'active' : ''}} pills-delivery-tab"
                                                        id="pills-home-tab" data-bs-toggle="pill"
                                                        data-type="{{ \App\Enums\OrderType::Delivery }}"
                                                        data-bs-target="#pills-home" type="button" role="tab"
                                                        aria-controls="pills-home" aria-selected="true">
                                                        <img src="{{ asset('images/scoter1.svg') }}" alt="" class="svg"
                                                             height="23" width="26">
                                                        Delivery
                                                    </button>
                                                    <input type="hidden" value="{{ $house_no }}" id="del-house-no">
                                                    <input type="hidden" value="{{ $zipcode }}" id="del-zipcode">
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button
                                                        class="nav-link {{ !$zipcode ? 'active' : ''}} pills-delivery-tab"
                                                        id="pills-profile-tab" data-bs-toggle="pill"
                                                        data-type="{{ \App\Enums\OrderType::TakeAway }}"
                                                        data-bs-target="#pills-profile" type="button" role="tab"
                                                        aria-controls="pills-profile" aria-selected="false">
                                                        <img src="{{ asset('images/takeaway-icon.svg') }}" alt=""
                                                             class="svg" height="23" width="23">
                                                        Take Away
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="d-flex flex-column flex-fill tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade {{ $zipcode ? 'show active' : ''}}"
                                                     id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                                                     tabindex="0">
                                                    <div class="form-group">
                                                        <label class="form-label">Delivery Address</label>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div
                                                                class="d-flex align-items-center delivery-address-span">
                                                                <img src="{{ asset('images/delivery-address.svg') }}"
                                                                     alt="" class="svg" height="23" width="32">

                                                                <p class="mb-0 d-inline-block ms-2 text-bold-1"> <?= $house_no ? $house_no . ', ' . $zipcode : ''; ?> </p>
                                                            </div>
                                                            @if($user && $user->id)
                                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                   data-bs-target="#addressChangeModal"
                                                                   class="btn btn-xs-sm btn-custom-yellow text-capitalize address-change-btn">Change</a>
                                                            @else
                                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                   data-bs-target="#signInModal"
                                                                   class="btn btn-xs-sm btn-custom-yellow text-capitalize address-change-btn">Change</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade {{ !$zipcode ? 'show active' : ''}}"
                                                     id="pills-profile" role="tabpanel"
                                                     aria-labelledby="pills-profile-tab" tabindex="0">
                                                    <div class="form-group">
                                                        <label class="form-label">Restaurants Address</label>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('images/rest-address.svg') }}" alt=""
                                                                     class="svg" height="29" width="29">

                                                                <p class="mb-0 d-inline-block ms-2 text-bold-1">{{ getRestaurantDetail()->rest_address }} </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($user && $user->id)
                                                    <!-- End address section & start cart section -->
                                                    <div class="cart-section">
                                                        <h6 class="cart-title">Your Cart</h6>
                                                        <div class="cart-items">
                                                            @if(count($cart) > 0)
                                                                @foreach($cart as $key => $dish)
                                                                        <?php
                                                                        $cartValue += ($dish->qty * $dish->dish->price);
                                                                        $paidIngredient = isset($dish->orderDishPaidIngredients) ? $dish->orderDishPaidIngredients()->select(\Illuminate\Support\Facades\DB::raw('sum(quantity * price) as total'))->get()->sum('total') : 0;
                                                                        $cartValue += $paidIngredient;
                                                                        $outOfStock = '';
                                                                        $outOfStockDisplay = 'd-none';
                                                                        if ($dish->dish->qty == 0 || $dish->dish->out_of_stock == '1') {
                                                                            $outOfStock = 'nostock-card';
                                                                            $outOfStockDisplay = '';
                                                                        }
                                                                        ?>
                                                                    <div class="row stock-card {{ $outOfStock }}"
                                                                         id="cart-{{ $dish->dish->id }}">

                                                                        <div
                                                                            class="col-12 text-end d-flex align-items-center gap-2 mb-3 justify-content-end outof-stock-text {{ $outOfStockDisplay }}">
                                                                            <strong>Out of stock</strong> <a
                                                                                class="remove-cart-dish"
                                                                                data-id="{{ $dish->id }}"
                                                                                data-dish-id="{{ $dish->dish->id }}"
                                                                                href="javascript:void(0)">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                     fill="#ff0000" viewBox="0 0 24 24"
                                                                                     width="20px" height="20px">
                                                                                    <path
                                                                                        d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z"/>
                                                                                </svg>
                                                                            </a>
                                                                        </div>

                                                                        <div
                                                                            class="col-xx-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4 cart-custom-w-col-img">
                                                                            <img src="{{ $dish->dish->image }}"
                                                                                 alt="burger image" class="img-fluid"
                                                                                 width="86" height="74px"/>
                                                                            <div class="foodqty">
                                  <span class="minus">
                                    <i class="fas fa-minus align-middle"
                                       onclick="updateDishQty('-',{{ $dish->dish->qty }},{{ $dish->dish->id }})"></i>
                                  </span>
                                                                                <input type="number" readonly
                                                                                       class="count cart-amt"
                                                                                       id="qty-{{ $dish->dish->id }}"
                                                                                       name="qty-{{ $dish->dish->id }}"
                                                                                       value="{{ $dish->qty }}"
                                                                                       data-ing="{{ $paidIngredient }}"
                                                                                       data-id="{{ $dish->dish->id }}"/>
                                                                                <input type="hidden"
                                                                                       id="dish-price-{{ $dish->dish->id }}"
                                                                                       value="{{ $dish->dish->price }}"/>
                                                                                <span class="plus">
                                    <i class="fas fa-plus align-middle"
                                       onclick="updateDishQty('+',{{ $dish->dish->qty }},{{ $dish->dish->id }})"></i>
                                  </span>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="col-xx-9 col-xl-9 col-lg-9 col-md-8 col-sm-12 col-8 cart-custom-w-col-detail">
                                                                            <div class="cart-item-detail">
                                                                                <div
                                                                                    class="d-flex align-items-center justify-content-between">
                                                                                    <p class="d-inline-block item-name mb-0"> {{ $dish->dish->name }} </p>
                                                                                    <span
                                                                                        class="cart-item-price"
                                                                                        id="cart-item-price{{$dish->dish->id}}">+€{{ $dish->qty * $dish->dish->price }}</span>
                                                                                </div>
                                                                                <div class="d-flex">
                                                                                    <p class="mb-0 item-options mb-0">
                                                                                        {{ $dish->dishOption->name ?? '' }}</p>
                                                                                    <span
                                                                                        class="item-desc">-{{ getOrderDishIngredients($dish) }}</span>
                                                                                    <p class="item-customize mb-0 ms-auto justify-content-end">
                                                                                        customize
                                                                                        <a href="javascript:void(0);"
                                                                                           onclick="customizeDish({{ $dish->dish->id }});">
                                                                                            <img
                                                                                                src="{{ asset('images/custom-dish.svg') }}"
                                                                                                alt="" class="svg"
                                                                                                height="13" width="14">

                                                                                        </a>
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="from-group addnote-from-group mb-0">
                                                                                    <div class="form-group">
                                                                                        <label for="dishnameenglish"
                                                                                               class="form-label">Add
                                                                                            notes</label>
                                                                                        <input type="text"
                                                                                               data-id="{{ $dish->id }}"
                                                                                               maxlength="50"
                                                                                               class="form-control dish-notes"
                                                                                               value="{{ $dish->notes }}"
                                                                                               placeholder="Type here..."/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="cart-amount-cal-data"
                                                             id="cart-amount-cal-data" {{ count($cart) > 0 ? '' : "style=display:none" }}>
                                                            <div
                                                                class="form-group prev-input-group custom-icon-input-group">
                            <span class="input-group-icon">
                              <img src="{{ asset('images/scoter-yellow.svg') }}" alt="" class="svg" height="22"
                                   width="25">

                            </span>
                                                                <input type="text"
                                                                       class="form-control bg-gray custom-control-with-icon ps-5"
                                                                       id="delivery_instruction" maxlength="50"
                                                                       value="{{ $user->cart ? $user->cart->delivery_note : '' }}"
                                                                       placeholder="Add Delivery instruction"/>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div
                                                                    class="form-group prev-input-group position-relative d-flex align-items-center mb-0">
                                <span class="input-group-icon">
                                  <img src="{{ asset('images/coupon-code.svg') }}" alt="" class="svg" height="18"
                                       width="29">

                                </span>
                                                                    <input type="text"
                                                                           class="form-control bg-gray custom-control-with-icon ps-5"
                                                                           style="padding-right: 95px"
                                                                           placeholder="Coupon Code"
                                                                           value="{{ $couponCode }}"
                                                                           {{ !empty($couponCode) ? 'readonly' : '' }} id="coupon_code">
                                                                    <div class="coupon-apply-btn">
                                                                        <button class="btn btn-xs-sm btn-custom-yellow"
                                                                                onclick="applyCoupon()"
                                                                                id="coupon_code_apply_btn" {{ !empty($couponCode) ? 'style=display:none' : '' }}>
                                                                            Apply
                                                                        </button>
                                                                        <button class="btn btn-xs-sm btn-custom-yellow"
                                                                                onclick="removeCoupon()"
                                                                                id="coupon_code_remove_btn" {{ !empty($couponCode) ? '' : 'style=display:none' }}>
                                                                            Remove
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <label id="coupon-code-error"
                                                                       class="error d-none"></label>
                                                            </div>
                                                            <div class="bill-detail-invoice">
                                                                <h6 class="cart-title">Bill Details</h6>
                                                                <div class="table-responsive">
                                                                    <table class="table table-borderless">
                                                                        <tbody></tbody>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-muted-1 bill-count-name">Item Total </span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span class="bill-count"
                                                                                      id="total-cart-bill">€{{ $cartValue }}</span>
                                                                                <input type="hidden"
                                                                                       id="total-cart-bill-amount"
                                                                                       value="{{ $cartValue }}">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-muted-1 bill-count-name">Service</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span
                                                                                    class="bill-count">€{{ $serviceCharge }}</span>
                                                                                <input type="hidden" id="service-charge"
                                                                                       value="{{ $serviceCharge }}">
                                                                            </td>
                                                                        </tr>
                                                                        <!--                                  <tr>
                                                                                                            <td class="text-start">
                                                                                                              <span class="text-muted-1 bill-count-name">Free Delivery (25 mins)</span>
                                                                                                            </td>
                                                                                                            <td class="text-end">
                                                                                                              <span class="bill-count">-€00</span>
                                                                                                            </td>
                                                                                                          </tr>-->
                                                                        <tr class="item-discount"
                                                                            id="item-discount" {{ !empty($couponCode) ? '' : 'style=display:none' }}>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-custom-light-green bill-count-name">Item discount</span>
                                                                                <input type="hidden"
                                                                                       id="coupon-discount"
                                                                                       value="{{ $couponDiscount }}">
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span
                                                                                    class="text-custom-light-green bill-count"
                                                                                    id="coupon-discount-text">-€{{ $cartValue * $couponDiscountPercent }}</span>
                                                                                <input type="hidden"
                                                                                       id="coupon-discount-percent"
                                                                                       value="{{ $couponDiscountPercent }}">
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                        <tfoot>
                                                                        <tr>
                                                                            <td class="text-start">Total</td>
                                                                            <td class="text-end">
                                                                                <span class="bill-total-count"
                                                                                      id="gross-total-bill">€{{ ($cartValue + $serviceCharge) - ($cartValue * $couponDiscountPercent) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                                <a class="btn btn-custom-yellow btn-default d-block"
                                                                   id="checkout-cart"
                                                                   {{--                                                                   href="{{ route('user.checkout') }}">--}}
                                                                   href="javascript:void(0)">
                                                                    <span class="align-middle">Checkout</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="empty-card-div w-100"
                                                         id="empty-cart-div" {{ count($cart) > 0 ? 'style=display:none' : "" }}>
                                                        <p class="empty-card-text text-muted-1"> Your cart is empty </p>
                                                        <span>
                            <img src="{{ asset('images/empty-card.svg') }}" alt="" class="svg" height="128" width="132">

                          </span>
                                                    </div>
                                                    <!-- End cart section -->
                                                @else
                                                    <!-- start empty cart section -->
                                                    <div class="empty-card-div w-100">
                                                        <p class="empty-card-text text-muted-1"> Your cart is empty </p>
                                                        <span>
                            <img src="{{ asset('images/empty-card.svg') }}" alt="" class="svg" height="128" width="132">

                          </span>
                                                    </div>
                                                    <!--end empty cart section -->
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.user.footer_design')
        <!-- end footer -->
    </div>


    @include('user.modals.address')
    @include('user.modals.customize-dish')
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/user/dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endsection

