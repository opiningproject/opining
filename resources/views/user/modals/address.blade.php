<!-- start address modal -->
<div class="modal fade custom-modal customisable-modal" id="addressChangeModal" tabindex="-1" aria-labelledby="addressChangeModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content border-radius">
      <div class="modal-header border-0 align-items-stretch">
        <div>
          <h1 class="modal-title mb-0 font-sebinomedium"> delivery address </h1>
          <p class="text-muted-lead-1 mb-0"> You have a saved address in this location </p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12">
              <div class="form-group prev-input-group">
                <span class="input-group-icon">
                  <img src="images/zipcode-svg.svg" alt="zipcode" class="img-fluid" width="22" height="22" />
                </span>
                <input type="number" class="form-control" placeholder="Zip Code" />
              </div>
            </div>
            <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12">
              <div class="form-group prev-input-group">
                <span class="input-group-icon">
                  <img src="images/home-icon-svg.svg" alt="home address" class="img-fluid" width="22" height="22" />
                </span>
                <input type="text" class="form-control" placeholder="House Number" />
              </div>
            </div>
            <div class="colxx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12 form-group">
              <a href="#" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100">Save</a>
            </div>
          </div>
        </form>
        <div class="address-box">
          <h1 class="modal-title mb-0 font-sebinomedium">My Address</h1>
          <hr />
          <div class="row">
            <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12 mobile-mb-10">
              <div class="card card-body h-100 address-card active">
                <p> Tochtstraat 10, 3036 SK, Nieuwegein, Netherlands 3950009 </p>
                <div class="d-flex align-items-center justify-content-between">
                  <a href="javascript:void(0);" class="btn btn-xs-sm btn-custom-yellow text-capitalize">Deliver Here</a>
                  <a class="btn btn-custom-yellow btn-icon" data-bs-toggle="modal" data-bs-target="#deleteAlertModal">
                    <i class="fa-regular fa-trash-can"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-xx-6 col-xl-6 col-lg-col-md-12 col-sm-12 col-12">
              <div class="card card-body h-100 address-card">
                <p> Tochtstraat 10, 3036 SK, Nieuwegein, Netherlands 3950009 </p>
                <div class="d-flex align-items-center justify-content-between">
                  <a href="javascript:void(0);" class="btn btn-xs-sm btn-custom-yellow text-capitalize">Deliver Here</a>
                  <a class="btn btn-custom-yellow btn-icon" data-bs-toggle="modal" data-bs-target="#deleteAlertModal">
                    <i class="fa-regular fa-trash-can"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end address modal -->