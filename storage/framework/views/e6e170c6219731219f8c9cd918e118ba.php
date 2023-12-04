
<script type="text/javascript" src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/swiper-bundle.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/dark-mode-switch.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>

<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.gammel.js"></script>
<script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.charts.js"></script>
<script src="https://unpkg.com/jquery-fusioncharts@1.1.0/dist/fusioncharts.jqueryplugin.js"></script>
<script type="text/javascript" src="<?php echo e(asset('js/jquery.datepicker.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('js/user-auth.js')); ?>"></script>

<script>
    var baseURL = "<?php echo e(url('/')); ?>"

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });
    // timepicker
</script>

<footer>
  <div class="footer-link-item-grid"></div>
  <div class="row footer-link-item">
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 text-lg-center text-left mb-4 mb-md-0">
      <div class="footer-logo">
        <a href="javascript:void(0);">
          <p class="mb-0">Gomeal <span class="text-yellow-1">.</span>
          </p>
        </a>
      </div>
    </div>
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
      <div class="row">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-4 mb-md-0">
          <div class="footer-link">
            <ul>
              <li>
                <a href="javascript:void(0);">Dashboard</a>
              </li>
              <li>
                <a href="javascript:void(0);">Profile</a>
              </li>
              <li>
                <a href="javascript:void(0);">My Coupon</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-4 mb-md-0">
          <div class="footer-link">
            <ul>
              <li>
                <a href="javascript:void(0);">Chat Support</a>
              </li>
              <li>
                <a href="<?php echo e(route('terms')); ?>">Terms & Condition</a>
              </li>
              <li>
                <a href="<?php echo e(route('privacy-policy')); ?>">Privacy Policy</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="footer-link">
            <ul>
              <li>
                <a href="javascript:void(0);">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.499897 4.23L0.500015 4.21493C0.505138 3.56427 0.59207 2.93307 0.897041 2.33371L0.899357 2.32916L0.89938 2.32917C1.00505 2.12664 1.13821 1.93969 1.29509 1.7736C1.50251 1.54876 1.72401 1.3332 1.93387 1.12896C1.99146 1.07292 2.04817 1.01773 2.10347 0.963439L0.499897 4.23ZM0.499897 4.23L0.500685 4.24504M0.499897 4.23L0.500685 4.24504M0.500685 4.24504C0.501404 4.25875 0.502266 4.27877 0.503317 4.30317C0.506225 4.37071 0.510576 4.47176 0.517312 4.56501L0.517402 4.56621M0.500685 4.24504L0.517402 4.56621M6.59073 5.45373L6.59049 5.45397C6.53657 5.50826 6.47963 5.5672 6.42016 5.62875C6.24953 5.80536 6.05808 6.00352 5.8572 6.17554L5.85705 6.17567C5.79114 6.23206 5.76667 6.28033 5.7537 6.32725C5.73791 6.38438 5.73214 6.4678 5.74808 6.59923C5.80672 7.07587 6.0114 7.51387 6.31147 7.95289L6.31212 7.95386C6.94519 8.88478 7.73357 9.60289 8.74758 10.0384C9.09541 10.1869 9.36731 10.253 9.62512 10.2012C9.66834 10.1909 9.70824 10.17 9.7412 10.1405C9.91474 9.98128 10.0719 9.8224 10.2382 9.65436C10.3335 9.558 10.4318 9.45863 10.5379 9.35447M6.59073 5.45373L14.6876 13.4728L15.0457 13.8218C15.0459 13.8216 15.0461 13.8214 15.0463 13.8212C15.647 13.2041 15.6565 12.2938 15.043 11.6737L15.0429 11.6736C14.2682 10.8911 13.4881 10.114 12.7026 9.34219L12.7026 9.34214C12.0729 8.72357 11.1522 8.75064 10.5379 9.35447M6.59073 5.45373C6.89182 5.15016 7.06719 4.76651 7.06969 4.35799M6.59073 5.45373L7.06969 4.35799M10.5379 9.35447L10.8882 9.71122L10.5376 9.3547C10.5377 9.35462 10.5378 9.35454 10.5379 9.35447ZM10.2164 15.2291L10.2162 15.2291C8.61924 14.8246 7.22674 14.0402 5.96264 13.0726L5.96249 13.0725C4.05183 11.6088 2.48893 9.83013 1.41146 7.64417L10.2164 15.2291ZM10.2164 15.2291C11.082 15.448 11.9983 15.5413 12.9379 15.3062L10.2164 15.2291ZM0.517402 4.56621C0.599879 5.6706 0.940762 6.6898 1.4114 7.64406L0.517402 4.56621ZM3.19387 0.492213C3.59993 0.489807 3.98526 0.657484 4.29014 0.958379L3.19387 0.492213ZM3.19387 0.492213C2.78874 0.494614 2.40622 0.665968 2.10366 0.963254L3.19387 0.492213ZM7.06969 4.35799C7.07219 3.94863 6.90071 3.56252 6.59732 3.25713L7.06969 4.35799ZM6.59722 3.25703C5.83225 2.48672 5.06326 1.72054 4.29027 0.958504L6.59722 3.25703Z" stroke="#F5F5F5" />
                  </svg> +31 <?php echo e(getRestaurantDetail()->phone_no); ?> </a>
              </li>
              <li>
                <a href="javascript:void(0);">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="13" viewBox="0 0 18 13" fill="none">
                    <path d="M1.00171 2.06878C1.08065 1.79196 1.18049 1.52705 1.38573 1.31444C1.67418 1.01679 2.02151 0.859458 2.43711 0.859458C6.92992 0.859458 11.4226 0.859458 15.9151 0.859458C16.1045 0.857415 16.2924 0.893043 16.4679 0.964259C16.6433 1.03548 16.8027 1.14085 16.9368 1.27421C17.0708 1.40757 17.1769 1.56624 17.2486 1.74093C17.3204 1.91563 17.3565 2.10283 17.3548 2.29159C17.3565 5.15671 17.3565 8.02183 17.3548 10.887C17.3564 11.0757 17.3202 11.2629 17.2484 11.4375C17.1766 11.6122 17.0706 11.7709 16.9365 11.9042C16.8025 12.0376 16.6431 12.143 16.4678 12.2143C16.2924 12.2856 16.1045 12.3214 15.9151 12.3195C11.428 12.3195 6.94073 12.3195 2.45332 12.3195C1.75141 12.3195 1.19116 11.8688 1.0303 11.1825C1.0221 11.1578 1.01197 11.1337 1 11.1106L1.00171 2.06878ZM2.68032 1.81833C2.72299 1.86425 2.74049 1.88891 2.76225 1.9106C4.76885 3.91763 6.77574 5.92423 8.78291 7.93041C9.01717 8.16428 9.35084 8.15748 9.59363 7.91638C11.5897 5.92126 13.5852 3.92571 15.5802 1.92973C15.6105 1.89997 15.6352 1.86467 15.6736 1.81833H2.68032ZM2.69099 11.356H15.6736C14.2958 9.9974 12.9338 8.65371 11.5718 7.31002C11.1562 7.72248 10.7218 8.15195 10.2891 8.58312C9.64611 9.22307 8.71037 9.22307 8.07033 8.581C7.67578 8.18696 7.28123 7.79264 6.88668 7.39804C6.84657 7.35807 6.8039 7.32065 6.79494 7.31299L2.69099 11.356ZM1.96305 10.614L6.05079 6.58927L1.96305 2.55395V10.614ZM16.3905 10.6395V2.56628L12.2942 6.60118L16.3905 10.6395Z" fill="white" stroke="white" stroke-width="0.5" />
                  </svg> <?php echo e(getRestaurantDetail()->user->email); ?> </a>
              </li>
              <li>
                <a href="javascript:void(0);">
                  <svg xmlns="http://www.w3.org/2000/svg" width="13" height="17" viewBox="0 0 13 17" fill="none">
                    <path d="M6.47031 0.97237L6.51303 0.972675C9.19606 0.991864 11.4031 3.16868 11.713 5.90313L11.713 5.90325C11.8707 7.29629 11.5031 8.52996 11.0053 9.64791L11.0053 9.64803C10.2888 11.2563 9.30254 12.6448 8.24586 13.9268L6.47031 0.97237ZM6.47031 0.97237L6.42784 0.976917M6.47031 0.97237L6.42784 0.976917M6.42784 0.976917C6.36582 0.983556 6.29975 0.99032 6.23168 0.997289M6.42784 0.976917L6.23168 0.997289M7.25061 15.0626L7.2505 15.0627C7.14486 15.1838 6.91 15.4117 6.54123 15.4269C6.15809 15.4427 5.90066 15.2206 5.77627 15.0851C4.31262 13.4949 2.96172 11.7523 2.00913 9.66442L7.25061 15.0626ZM7.25061 15.0626C7.35409 14.9439 7.46623 14.8186 7.58198 14.6892M7.25061 15.0626L7.58198 14.6892M1.25072 6.4151L1.25073 6.41482C1.292 3.77345 3.28771 1.33775 5.83866 1.03947L1.25072 6.4151ZM1.25072 6.4151C1.23251 7.60927 1.56063 8.682 2.00905 9.66425L1.25072 6.4151ZM6.50114 8.06742C7.1655 8.06963 7.81463 7.45655 7.81728 6.60884C7.81995 5.72776 7.17583 5.11756 6.50821 5.11638H6.5082C5.83871 5.11518 5.19358 5.72494 5.18961 6.5761L6.50114 8.06742ZM6.50114 8.06742C5.82742 8.06444 5.18565 7.45179 5.18961 6.57616L6.50114 8.06742ZM7.58198 14.6892C7.80174 14.4436 8.03449 14.1834 8.24564 13.927L7.58198 14.6892ZM6.23168 0.997289C6.10337 1.01042 5.96795 1.02429 5.83916 1.03942L6.23168 0.997289Z" stroke="white" stroke-width="1.5" />
                  </svg> <?php echo e(getRestaurantDetail()->rest_address); ?> </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
          <div class="footer-link">
            <ul>
              <li>
                <a href="javascript:void(0);">Opening Hours</a>
              </li>
              <li>
                <a href="javascript:void(0);">Mon - Fri : 08:00 - 16:00</a>
              </li>
              <li>
                <a href="javascript:void(0);">Sat - Sun : 08:00 - 16:00</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom text-center">
    <p class="mb-0 footer-copyright-text">Gomeal &copy; 2023 Gomeal - ALL Rights Reserved</p>
  </div>
</footer><?php /**PATH /var/www/html/go-meal/resources/views/layouts/user/footer.blade.php ENDPATH**/ ?>