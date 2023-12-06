@extends('layouts.user-app') @section('content') <div class="main">
  <div class="main-view">
    <div class="container-fluid bd-gutter bd-layout"> @include('layouts.user.side_nav_bar') <main class="bd-main order-1">
        <div class="main-content">
          <div class="section-page-title main-page-title mb-0">
            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
              <h1 class="page-title">Privacy Policy</h1>
            </div>
          </div>
          <section class="custom-section informativeterms-section h-100">
            <div class="card custom-card h-100">
              <div class="card-body pb-0 custom-single-text">
                <?= $terms ?>
              </div>
            </div>
          </section>
        </div>
      </main>
    </div>
  </div>
    <!-- start footer -->
    @include('layouts.user.footer_design')
    <!-- end footer -->
</div> @endsection
