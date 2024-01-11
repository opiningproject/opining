@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')

                <main class="bd-main order-1 w-100 position-relative">
                    <div class="main-content d-flex flex-column h-100">
                        <div class="section-page-title mb-0 d-flex align-items-center justify-content-between gap-2 foodorder-page-title">
                            <h1 class="page-title">Food Order</h1>
                            <div class="btn-grp d-flex align-items-center flex-wrap">
                                <button class="btn d-flex align-items-center bg-white">
                                    <img src="images/filter-icon.svg" alt="img" class="img-fluid" width="22">
                                    <div class="text">Filter Orders</div>
                                </button>
                            </div>
                        </div>
                        <div class="foodorder-box d-flex">
                            <div class="foodorder-box-list-wrp bg-white">
                                <div class="foodorder-box-list d-flex flex-column">
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                      <g fill="#000">
                                                        <path d="M20.954 20.867c-.028-.066-1.687-14.473-1.759-15.195-.046-.474-.377-.802-.847-.803-.947-.002-1.895-.007-2.842.004a.376.376 0 0 1-.174-.028c-.07-.037-.093-.11-.09-.24.004-.255.001-.51-.013-.765a6.17 6.17 0 0 0-.151-1.08A3.877 3.877 0 0 0 13.954.942L13.95.94c-.56-.495-1.243-.79-2.004-.905a3.401 3.401 0 0 0-1.807.24A3.855 3.855 0 0 0 8.99.99l-.003.003a3.893 3.893 0 0 0-1.158 2.16 8.617 8.617 0 0 0-.061.95l-.011.526c-.003.12-.026.186-.092.218a.34.34 0 0 1-.152.024c-.962-.008-1.925-.002-2.887-.003-.306 0-.561.132-.685.396C3.824 5.517 2.047 20.024 2 20.5c.015-.057-.005.057 0 0-.088.335.03 1.005.257 1.265.208.239.477.23.748.23 1.417 0 16.428-.028 17.21.005.552.022.785-.5.74-1.133ZM11.5 1.491c.037 0 .074.001.11.003 1.106.06 1.985 1.008 1.985 2.169v1.07c-.02.102-.092.132-.215.134h-.03l-3.655-.004c-.23 0-.285 0-.291-.156V3.663c0-1.161.879-2.109 1.985-2.169.036-.002.073-.003.11-.003ZM3.71 20.335C3.716 20.182 5.295 6.7 5.339 6.49h12.332c.044.283 1.618 13.697 1.625 13.845H3.709Z"/>
                                                        <path d="M10.467 12.592c-.131.144-.3.245-.41.412-.153.229-.049.517-.033.77.071 1.117.2 2.241.055 3.359-.026.199-.062.402-.155.572-.094.17-.256.304-.43.295-.296-.015-.466-.392-.536-.723-.246-1.163-.071-2.454.022-3.632 0-.014.13-.47-.276-.903-.324-.345-.582-.696-.678-1.165-.06-.298 0-.63.015-.946.006-.128.041-.254.055-.382.035-.328.057-.657.102-.983.026-.187.164-.257.312-.266.14-.008.274.151.265.317-.019.345-.054.69-.076 1.034-.014.223-.022.447-.025.671-.002.106.01.23.087.302.085.082.23.083.324.022.103-.067.146-.19.15-.32.01-.535.01-1.07.017-1.606.004-.263.094-.375.293-.375.186-.002.287.106.289.324.005.55-.004 1.1.02 1.649.005.115.07.237.147.309.082.076.199.1.287.027a.416.416 0 0 0 .098-.132c.032-.064.017-.141.013-.212a43.248 43.248 0 0 0-.012-.258l-.027-.515c-.016-.324-.044-.648-.04-.972a.256.256 0 0 1 .266-.26c.137.002.287.065.3.25.048.69.093 1.38.113 2.071.016.519-.218.921-.532 1.266Zm3.532 1.628a.632.632 0 0 1-.05.308c-.055.1-.152.115-.244.122-.133.01-.26.008-.39-.005-.097-.01-.121.078-.118.177.021.764.119 1.583.024 2.343-.052.418-.266.924-.687.822a.41.41 0 0 1-.225-.144.811.811 0 0 1-.12-.25c-.22-.665-.2-1.41-.171-2.114.03-.75.106-1.497.119-2.248.023-1.302-.03-2.604-.003-3.905 0-.051-.005-.103.002-.153.02-.142.138-.216.235-.147.455.322.881.686 1.19 1.212.274.465.435.973.438 1.553.005.824-.015 1.605 0 2.43Z"/>
                                                      </g>
                                                    </svg>
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/hand-money-icon.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-yellow.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">ASAP</div>
                                        </div>
                                    </div>
                                    <div class="active foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-black.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">ASAP</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/fork-knife-icon.png" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/hand-money-icon.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-yellow.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">ASAP</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/fork-knife-icon.png" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/hand-money-icon.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-yellow.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">ASAP</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-gray.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-gray.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-gray.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-gray.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-gray.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-gray.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-gray.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-gray.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/scoter.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="images/clock-gray.svg" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="foodorder-box-details bg-white w-100 d-flex flex-column">
                                <div class="footer-box-details-header d-flex align-items-center justify-content-between gap-lg-3 flex-wrap">
                                    <ul class="list-inline text-grp mb-0 p-0 d-flex align-items-center flex-fill">
                                        <li class="list-inline-item d-flex align-items-center">Order #1022</li>
                                        <li class="list-inline-item d-flex align-items-center">June 1, 2020, 08:22 AM</li>
                                    </ul>
                                    <ul class="d-inline-flex flex-wrap gap-3 contact-list mb-0 p-0 justify-content-end">
                                        <li class="list-inline-item">
                                            <a href="#" class="d-flex align-items-center gap-2">
                                                <img src="images/user-yellow.svg" alt="user" class="img-fluid" width="18">
                                                Serdar Orman
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="d-flex align-items-center gap-2">
                                                <img src="images/call-yellow.svg" alt="call" class="img-fluid" width="18">
                                                +31614522453
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="footer-box-main">
                                    <div class="footer-box-main-orderdetails d-flex justify-content-between   ">
                                        <div class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
                                            <img src="images/location-icon.svg" alt="" class="img-fluid" width="16" style="margin-top: 1px;">
                                            <div class="text-grp">
                                                <div class="title mb-2">Naaldwijkstraat 29, 3061PG Rotterdam</div>
                                                <div class="text">
                                                    <span>Delivery Instruction:</span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
                                            <div class="text-grp">
                                                <div class="text">
                                                    <span>Delivery Mode:</span>
                                                    As Soon As Posible
                                                </div>
                                                <div class="text">
                                                    <span>Payment Method:</span>
                                                    Cash On Delivery
                                                </div>
                                                <div class="text">
                                                    <span>Order Type:</span>
                                                    Take-Away
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer-box-main-progressbar position-relative d-flex align-items-center justify-content-between gap-1">
                                        <div class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                            <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                <svg width="18" height="18" viewBox="0 0 19 19" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.995 9.476c.005-.087.01-.149.01-.21v-3.48c0-.118.06-.177.18-.177h5.144c.18 0 .18 0 .18.177v3.94c0 .066-.01.131-.014.192-2.228-.752-4.216-.39-5.77 1.391-1.622 1.86-1.676 3.95-.527 6.115-.048.005-.1.016-.15.016-3.298 0-6.596 0-9.893.003-.118 0-.155-.035-.155-.155.003-3.844.003-7.69 0-11.534 0-.113.035-.148.147-.148 1.736.003 3.473.004 5.21 0 .124 0 .15.045.15.159a819.003 819.003 0 0 0-.002 3.505c0 .062.007.123.012.218.199-.13.373-.244.546-.36.292-.195.586-.387.873-.59.105-.074.185-.069.289.004.306.214.62.416.928.628.076.052.13.052.205 0 .304-.21.617-.406.918-.62.12-.086.205-.078.322.004.433.3.874.588 1.313.88.017.012.037.019.084.041Zm-3.92 3.62c0-.861-.003-1.721.003-2.582.002-.14-.04-.174-.176-.174-1.718.005-3.437.005-5.156 0-.137 0-.174.039-.174.175.004 1.726.004 3.45 0 5.176 0 .138.039.176.175.175 1.719-.005 3.437-.004 5.156 0 .137 0 .176-.038.175-.176-.006-.865-.003-1.73-.003-2.595Z" fill="#292929"/>
                                                    <path d="M19.007 14.65A4.363 4.363 0 0 1 14.64 19a4.364 4.364 0 0 1-4.355-4.376 4.366 4.366 0 0 1 4.374-4.345 4.364 4.364 0 0 1 4.348 4.37Zm-2.519-.921c-.03-.038-.052-.072-.08-.1a23.986 23.986 0 0 0-.318-.32c-.137-.137-.141-.137-.28.002-.612.611-1.224 1.221-1.833 1.835-.092.094-.156.094-.247 0-.217-.227-.446-.443-.664-.669-.084-.086-.148-.102-.235-.005-.107.118-.22.231-.338.338-.09.082-.08.143.002.224.421.416.839.835 1.255 1.256.073.073.127.08.203.004l2.46-2.463c.028-.028.047-.064.075-.102ZM0 4.65c.167-.233.318-.444.47-.653l2.074-2.86c.248-.341.496-.683.742-1.026A.24.24 0 0 1 3.502 0C4.572.003 5.64.001 6.71.002c.155 0 .162.018.123.164-.102.38-.196.76-.295 1.14-.094.362-.192.724-.286 1.086-.091.354-.18.709-.27 1.064l-.27 1.063c-.027.111-.086.153-.212.153-1.767-.003-3.534-.002-5.3-.003C.14 4.67.084 4.66 0 4.65Zm16.515-.002c-.071.01-.122.022-.173.022-1.714.001-3.428 0-5.141.003-.122 0-.165-.035-.183-.162-.057-.393-.133-.782-.198-1.174-.063-.382-.121-.766-.185-1.148-.064-.387-.132-.774-.198-1.16a50.517 50.517 0 0 1-.152-.938c-.003-.024.032-.065.06-.08.028-.014.07-.008.105-.008.885 0 1.771.002 2.657-.003.106 0 .173.036.232.12.928 1.322 1.857 2.642 2.786 3.963.127.181.251.364.39.565Zm-8.101.024H6.697c-.163 0-.174-.006-.138-.155.09-.377.188-.753.283-1.129l.268-1.05.295-1.153c.089-.35.18-.7.261-1.051.021-.09.055-.133.15-.133h1.567c.076 0 .115.026.128.103.07.41.144.818.215 1.227l.21 1.226.174 1.016.158.924c.028.166.02.176-.151.176H8.414Zm1.848 3.197c-.156-.101-.284-.183-.41-.266a.536.536 0 0 0-.64.001c-.225.149-.452.292-.67.447-.098.07-.17.059-.264-.004-.295-.203-.597-.396-.893-.597-.068-.046-.117-.046-.184 0-.168.117-.34.227-.512.338-.035.022-.071.041-.126.072-.008-.065-.018-.11-.018-.154 0-.652.002-1.303-.003-1.955 0-.113.036-.144.147-.144 1.149.004 2.297.003 3.446 0 .099 0 .146.02.145.134-.005.66-.002 1.32-.003 1.98 0 .037-.007.074-.015.147Zm-5.736 7.083c-.617 0-1.234-.003-1.85.003-.137.001-.186-.028-.185-.163.006-1.14.005-2.28.001-3.42 0-.112.028-.156.162-.155 1.239.004 2.478.004 3.717 0 .137 0 .17.041.17.162-.005 1.136-.003 2.271-.003 3.407 0 .166 0 .166-.188.166H4.527Zm0-2.985c-.366 0-.732.002-1.099-.001-.087-.001-.126.024-.124.11.004.175.004.35 0 .526-.002.085.035.111.124.111a392.41 392.41 0 0 1 2.17 0c.107.001.136-.038.133-.13a6.202 6.202 0 0 1 0-.487c.005-.104-.04-.132-.146-.131-.352.005-.705.002-1.057.002Zm-.015 2.238c.362 0 .724-.002 1.085.001.093.001.136-.024.133-.116a8.322 8.322 0 0 1 0-.514c.003-.091-.037-.118-.131-.118-.724.003-1.447.003-2.17 0-.102 0-.128.038-.126.123.005.167.006.334 0 .501-.004.096.036.126.138.125.357-.004.714-.002 1.071-.002Z" fill="#292929"/>
                                                  </svg>
                                            </div>
                                            <div class="text">Order Accepted</div>
                                        </div>
                                        <div class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                            <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="19" viewBox="0 0 25 19" fill="none">
                                                    <g clip-path="url(#a)" fill="#292929">
                                                      <path d="M4.372 10.481c.664-.274 1.148-.494 1.648-.675.299-.108.215-.296.18-.492-.19-1.078.191-1.98.943-2.855l.49.57c-.5.684-.893 1.435-.597 2.349 3.078-.884 6.088-1.97 9.4-1.26-.224-1.028.4-1.497 1.299-1.869 1.805-.745 3.58-1.56 5.373-2.337.87-.378 1.644-.002 1.86.887.12.492-.112 1.008-.628 1.253-2.01.955-4.02 1.912-6.051 2.821-.333.15-.778.066-1.204.091.05.22.133.53.19.846.28 1.542-.062 2.98-.834 4.333-2.324 4.078-8.18 6-12.622 4.141C2.174 17.596.945 16.5.188 14.914c-.311-.649-.237-1.218.23-1.736.21-.233.218-.433.147-.714a7.054 7.054 0 0 1-.202-1.292c-.037-.577.239-.927.83-1.031.305-.053.359-.188.356-.44-.01-.75-.005-1.5-.003-2.25.003-.886.544-1.469 1.347-1.456.789.013 1.274.591 1.3 1.454.03.978.113 1.953.18 3.032Zm11.243-.28c.195-.212.335-.342.448-.492.383-.509.294-.803-.344-.94a6.122 6.122 0 0 0-1.45-.137c-2.284.07-4.46.648-6.6 1.37-.099.033-.19.091-.301.146l.32.506-.592.457-.54-.724c-.609.26-1.208.515-1.815.776.557 1.31 1.437 2.192 2.808 2.555.249.066.559.07.799-.01a52.691 52.691 0 0 0 3.142-1.144c.34-.138.653-.403.9-.676.513-.57.717-1.278.87-2.007.114-.54.568-.874 1.11-.883.543-.01.988.314 1.152.84.027.085.046.174.093.363Zm-9.144 4.063c-1.663-.95-2.494-2.361-2.828-4.048-.178-.896-.18-1.826-.235-2.742-.03-.473-.203-.751-.555-.717-.436.041-.53.335-.527.703.01.795.01 1.59 0 2.387-.005.548-.279.907-.822 1.003-.292.052-.383.156-.363.425.063.856.292 1.66.812 2.365.502.682 1.207 1.077 2.076 1.01.82-.063 1.63-.253 2.442-.386Zm7.156-2.744c.621-.272 1.187-.563 1.125-1.31-.014-.157-.198-.302-.303-.453-.149.114-.377.201-.43.347-.164.448-.26.918-.392 1.416Zm4.25-3.307.127.062c.113-.222.329-.455.306-.664-.018-.175-.299-.426-.494-.455-.196-.029-.43.174-.646.275l.064.116c.653-.106.82.067.643.666Zm-16.06 6.464-.81-.98c-.424.63-.169.93.81.98ZM7.24 4.486h-.546c-.11-.68.416-1.744 1.23-2.463l.39.53-1.075 1.933ZM7.015.74c.005.401-.34.746-.759.757-.418.01-.783-.316-.8-.718C5.437.357 5.798 0 6.239 0c.42.002.771.337.776.74ZM4.28 3.41c-.02.402-.388.726-.806.712-.419-.014-.761-.36-.753-.762.009-.424.39-.761.83-.733.419.026.75.382.73.784ZM.787 5.223v-.692h.73v.692h-.73Zm5.02.395H5.1v-.712h.707v.712Z"/>
                                                      <path d="M5.447 8.281v.687h-.742V8.28h.742Zm2.345 3.375v.687h-.741v-.687h.741Zm-5.082 1.11h.664l1.067 1.247-.38.543c-.677-.46-1.211-.966-1.35-1.79Z"/>
                                                    </g>
                                                    <defs>
                                                      <clipPath id="a">
                                                        <path fill="#fff" d="M0 0h25v19H0z"/>
                                                      </clipPath>
                                                    </defs>
                                                  </svg>
                                            </div>
                                            <div class="text">In kitchen</div>
                                        </div>
                                        <div class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                            <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                <svg width="27" height="20" viewBox="0 0 27 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.941 10.548c.25-1.727-.237-3.343-.347-4.986-.021-.316-.074-.631-.1-.947-.058-.682-.577-.994-1.23-.919-1.192.138-2.03.842-2.742 1.727-.531.661-1.231.779-1.961.991-.962.28-1.665-.261-2.438-.593-.294-.127-.449-.08-.639.15a2.947 2.947 0 0 0-.688 1.591c-.027.247.023.377.287.405.463.051.924.133 1.46.213-.291.58-.543 1.086-.802 1.59-.391.764-.769 1.538-1.19 2.285-.207.365-.238.648.077.945.097.092.157.226.286.42-1.066.033-1.91.397-2.477 1.279-.335.521-.467 1.1-.431 1.73.071 1.24.883 2.275 2.102 2.518.459.091.987.068 1.43-.077.43-.14.854-.442 1.163-.786.32-.356.497-.848.743-1.29-.005 0 .038-.003.047.014.282.561.751.603 1.301.595 1.896-.029 3.792-.009 5.689-.012.704-.002 1.432.133 2.057-.462.398 1.08 1.026 1.796 2.074 2.041.657.154 1.278.06 1.86-.265a2.654 2.654 0 0 0 1.377-1.959c.143-.862-.057-1.659-.622-2.38l.84-.53c-.557-.559-1.055-1.098-1.596-1.585-.318-.287-.24-.62-.213-.954.005-.059.19-.142.292-.145.474-.017.949-.004 1.422-.01.605-.007.836-.243.841-.864.008-.914-.069-.807.789-.81.683-.004 1.367.003 2.05-.003.206-.002.467.085.46-.307-.008-.395-.283-.29-.479-.29-1.868-.007-3.737-.004-5.606-.006-.498 0-.526-.043-.419-.647h4.595c.122-.6.098-.634-.412-.637-.795-.005-1.59-.013-2.384-.014-.215 0-.384-.013-.381-.315.002-.3.174-.312.387-.31.444.004.887.001 1.38.001 0-.625.036-1.215-.015-1.796-.03-.35-.329-.54-.664-.543a351.773 351.773 0 0 0-5.062 0c-.46.004-.711.338-.713.882-.004 1.516-.016 3.034.007 4.55.007.425-.118.569-.518.526-.3-.03-.603-.006-.893-.006l.006-.005ZM9.938 6.195c.054.165.098.268.12.375.156.732.294 1.467.468 2.195.06.258.02.347-.236.419-.979.275-1.952.573-2.924.877-.658.205-.917.647-.808 1.344.233 1.48.472 2.958.705 4.438.079.497.005.571-.471.453-.65-.161-1.067-.599-1.15-1.27-.131-1.057-.278-2.123-.259-3.183.024-1.278.214-2.553.332-3.83.03-.335.178-.5.535-.504.388-.003.773-.11 1.161-.129.544-.026 1.033-.162 1.476-.512.306-.242.656-.424 1.051-.673Zm-.227 5.406c.027.074.039.088.035.1-.033.123-.092.244-.097.368-.004.122.005.292.079.361.734.694.883 1.56.742 2.528-.166 1.146-.498 1.444-1.583 1.392-.014 0-.028-.002-.042 0-.223.016-.336-.085-.345-.323-.044-1.296-.096-2.593-.132-3.89-.003-.103.077-.285.148-.304.398-.1.804-.16 1.194-.232h.001Zm-8.58 4.623c.01-.857.736-1.603 1.56-1.604.855-.001 1.573.752 1.56 1.637-.013.874-.715 1.602-1.55 1.606-.839.005-1.58-.77-1.57-1.638Zm16.104 1.637c-.698-.009-1.28-.452-1.513-1.099-.102-.281-.037-.456.223-.595a41.76 41.76 0 0 0 1.907-1.067c.238-.143.384-.098.532.102.386.522.505 1.085.225 1.7-.283.622-.778.912-1.376.959h.002ZM8.833 1.595l1.487-.172c.331 1.219-.684 1.428-1.295 1.906.193.696.242.715.855.442.627-.278 1.264-.529 1.883-.825.143-.068.302-.262.321-.415.047-.383.053-.779.01-1.162C11.996.482 11.366-.027 10.46 0c-.864.026-1.563.686-1.626 1.593v.001Z" fill="#fff"/>
                                                    <path d="M23.968 14.216h2.633c.199 0 .39.022.399-.294.01-.34-.19-.321-.409-.32l-5.308.001c-.195 0-.393-.037-.396.286-.004.327.179.33.406.328.892-.005 1.784-.002 2.675-.002Zm-3.803-2.109c-.124.449.005.589.412.583 1.334-.022 2.668-.008 4.003-.009.207 0 .426.04.43-.303.006-.354-.224-.299-.426-.299h-4.086c-.109 0-.217.018-.332.028h-.001Z" fill="#fff"/>
                                                </svg>
                                            </div>
                                            <div class="text">Out For Delivery</div>
                                        </div>
                                        <div class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                            <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.995 9.475c.004-.087.01-.15.01-.21v-3.48c0-.118.06-.177.18-.177h5.143c.18 0 .18 0 .18.177v3.94c0 .065-.01.13-.014.191-2.228-.752-4.216-.389-5.769 1.392-1.623 1.86-1.676 3.949-.527 6.115-.049.005-.1.015-.15.015-3.298.001-6.596 0-9.893.003-.118 0-.155-.035-.155-.154.003-3.845.003-7.69 0-11.534 0-.113.035-.148.147-.147 1.736.002 3.473.003 5.21-.001.124 0 .15.045.15.159a819.003 819.003 0 0 0-.002 3.505c0 .062.006.123.012.218.198-.13.373-.244.546-.36.292-.195.585-.387.872-.59.106-.074.185-.069.29.004.305.214.62.416.928.628.075.051.13.052.205 0 .304-.21.616-.406.917-.62.12-.086.205-.078.323.004.433.3.874.588 1.312.88.018.011.038.018.085.041Zm-3.92 3.619c0-.86-.003-1.72.003-2.58.001-.14-.04-.176-.176-.175-1.719.004-3.437.004-5.156 0-.137 0-.174.038-.174.175.004 1.725.004 3.45 0 5.176 0 .138.038.175.175.175 1.719-.005 3.437-.005 5.156 0 .137 0 .176-.039.175-.177-.006-.864-.003-1.73-.003-2.594Z" fill="#fff"/>
                                                    <path d="M19 14.649a4.362 4.362 0 0 1-4.366 4.35 4.364 4.364 0 0 1-4.355-4.376 4.365 4.365 0 0 1 4.374-4.345A4.364 4.364 0 0 1 19 14.648Zm-2.518-.92c-.03-.038-.052-.072-.08-.101-.105-.108-.212-.213-.318-.32-.137-.136-.141-.136-.28.003-.612.61-1.225 1.22-1.833 1.835-.092.093-.156.093-.247-.002-.217-.226-.446-.442-.664-.667-.084-.087-.148-.102-.235-.006-.107.119-.22.231-.338.338-.09.082-.08.143.002.225.421.415.839.834 1.255 1.255.073.073.127.08.203.004.819-.822 1.64-1.642 2.46-2.463.028-.028.047-.064.075-.102ZM0 4.65l.47-.654c.69-.953 1.383-1.906 2.074-2.859.248-.342.496-.684.742-1.027A.24.24 0 0 1 3.502 0C4.572.003 5.64.002 6.71.002c.155 0 .161.019.122.165-.102.379-.196.76-.294 1.139-.094.363-.192.724-.286 1.087-.091.354-.18.708-.27 1.063-.09.354-.181.708-.27 1.063-.027.111-.086.153-.212.153-1.767-.004-3.534-.002-5.3-.004-.058 0-.115-.01-.199-.019Zm16.509-.002c-.071.009-.122.021-.173.021-1.714.001-3.428 0-5.141.003-.122 0-.165-.035-.183-.162-.056-.392-.133-.782-.198-1.173-.063-.383-.121-.767-.185-1.149-.064-.387-.132-.773-.198-1.16a51.353 51.353 0 0 1-.151-.937c-.004-.025.032-.066.059-.08.029-.015.07-.008.105-.008.885 0 1.771.001 2.657-.003.106 0 .173.036.232.12.927 1.321 1.857 2.642 2.785 3.962.128.181.252.365.39.566Zm-8.097.024H6.696c-.163 0-.174-.006-.138-.156.09-.377.188-.753.283-1.128l.268-1.05.295-1.153c.089-.35.18-.7.261-1.052.021-.09.055-.133.15-.132L9.38 0c.077 0 .116.027.129.104.07.409.144.817.215 1.226l.21 1.227.174 1.016.157.923c.028.166.02.176-.15.176H8.413Zm1.849 3.196c-.156-.101-.284-.183-.41-.266a.536.536 0 0 0-.64.001c-.225.149-.452.292-.671.447-.097.07-.17.059-.263-.005-.295-.202-.597-.395-.893-.596-.068-.046-.117-.046-.184 0-.168.117-.34.227-.512.338-.035.022-.071.041-.126.072-.008-.065-.018-.11-.018-.154 0-.652.002-1.303-.003-1.955 0-.113.036-.144.147-.144 1.148.004 2.297.003 3.446 0 .098 0 .146.02.145.134-.005.66-.002 1.32-.003 1.98 0 .037-.007.073-.015.147ZM4.526 14.95c-.617 0-1.234-.004-1.851.002-.136.001-.185-.027-.184-.162.006-1.14.005-2.28.001-3.42 0-.112.028-.156.162-.156 1.239.005 2.478.005 3.717 0 .137 0 .17.042.17.163-.005 1.135-.003 2.27-.003 3.406 0 .166 0 .166-.188.167H4.527Zm0-2.986c-.366 0-.732.002-1.099 0-.087-.002-.126.024-.124.109.004.175.004.351 0 .527-.002.084.035.11.124.11a301.89 301.89 0 0 1 2.17.001c.107 0 .135-.039.133-.13a6.202 6.202 0 0 1 0-.488c.005-.104-.04-.132-.146-.13-.353.004-.705.001-1.057.001Zm-.015 2.238c.362 0 .724-.001 1.085.002.093 0 .136-.025.133-.117a8.32 8.32 0 0 1 0-.514c.003-.09-.037-.117-.132-.117-.723.002-1.446.002-2.17 0-.1 0-.127.038-.125.123.005.166.006.334 0 .5-.004.097.036.127.138.125.357-.004.714-.001 1.071-.001Z" fill="#fff"/>
                                                  </svg>
                                            </div>
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="footer-box-main-orderlist">
                                        <div class="footer-box-main-orderlist-header d-flex align-items-center justify-content-between">
                                            <div class="text-grp d-flex align-items-center gap-1">
                                                <div class="title">Order List :</div>
                                                <div class="number">(2 x items)</div>
                                            </div>
                                        </div>
                                        <div class="footer-box-main-orderlist-main d-flex flex-column">
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer-main-total">
                                        <div class="footer-main-total-header d-flex align-items-center justify-content-between">
                                            <div class="text-grp d-flex align-items-center gap-2">
                                                <div class="title">Total :</div>
                                                <div class="number">€10.20</div>
                                            </div>
                                            <button class="bg-transparent border-0 d-flex align-items-center justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="10" viewBox="0 0 17 10" fill="none">
                                                <g clip-path="url(#clip0_476_42883)">
                                                  <path d="M8.55439 2.70064e-05C8.32941 -0.00123943 8.10639 0.0407738 7.89811 0.123659C7.68983 0.206542 7.50039 0.328667 7.34066 0.48303L0.502743 7.14514C0.180842 7.45876 -3.46587e-07 7.88413 -2.73935e-07 8.32766C-2.01283e-07 8.77119 0.180842 9.19656 0.502744 9.51018C0.824645 9.82381 1.26124 10 1.71647 10C2.17171 10 2.6083 9.82381 2.9302 9.51018L8.55439 4.01394L14.1786 9.49353C14.5056 9.76638 14.9263 9.90896 15.3565 9.89277C15.7867 9.87658 16.1949 9.70281 16.4993 9.40619C16.8038 9.10957 16.9821 8.71194 16.9987 8.29277C17.0153 7.8736 16.869 7.46375 16.5889 7.14513L9.75102 0.483029C9.43261 0.175333 9.00285 0.00186751 8.55439 2.70064e-05Z" fill="#949494"/>
                                                </g>
                                                <defs>
                                                  <clipPath id="clip0_476_42883">
                                                    <rect width="17" height="10" fill="white" transform="translate(17 10) rotate(180)"/>
                                                  </clipPath>
                                                </defs>
                                              </svg>
                                            </button>
                                        </div>
                                        <div class="footer-main-total-main">
                                            <div class="title">Bill Details</div>
                                            <div class="text-grp d-flex flex-column gap-3">
                                                <div class="text d-flex align-items-center justify-content-between gap-2">
                                                    <div class="key">Item Total</div>
                                                    <div class="value">+€10.20</div>
                                                </div>
                                                <div class="text d-flex align-items-center justify-content-between gap-2">
                                                    <div class="key">Service</div>
                                                    <div class="value">+€01</div>
                                                </div>
                                                <div class="text d-flex align-items-center justify-content-between gap-2">
                                                    <div class="key">Free Delivery (25 mins)</div>
                                                    <div class="value">-€00</div>
                                                </div>
                                                <div class="active text d-flex align-items-center justify-content-between gap-2">
                                                    <div class="key">Item Discount</div>
                                                    <div class="value">-€01</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footer-main-total-footer">
                                            <div class="text-grp d-flex align-items-center gap-2 justify-content-between">
                                                <div class="key">Total</div>
                                                <div class="value">€10.20</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="foodorder-box-details-footer d-flex align-items-center justify-content-between gap-2">
                                    <button class="btn">Print Label</button>
                                    <button class="btn active" class="customize-foodlink button" data-bs-toggle="modal" data-bs-target="#deleteAlertModal">Move to Kitchen</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
    @include('layouts.admin.footer_design')
    <!-- end footer -->
    </div>
