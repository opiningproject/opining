<div class="modal fade custom-modal customisable-modal" id="customisableModal" tabindex="-1" aria-labelledby="customisableModal" aria-hidden="true">
  <div class="modal-dialog custom-w-625px modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header border-0 d-block">
        <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="customisable-item-detail mt-3 text-center">
          <img src="<?= asset('images/burger-svg.svg') ?>" alt="burger" width="100" height="100">
          <h4>big mac with Cheese</h4>
          <p> Ketchup, sliced onion, slices cheese(2X), Quarter Pound Bun(2X), tomato ketchup, garlic paste</p>
          <span class="food-custom-price">€20</span>
          <div class="row justify-content-center">
            <div class="col-xl-5">
              <div class="form-group mb-0">
                <div class="input-group w-100">
                  <div class="dropdown w-100  ingredientslist-dp custom-default-dropdown">
                    <button class="form-control bg-white dropdown-toggle d-flex align-items-center justify-content-between w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="d-block"> grilled </div>
                    </button>
                    <ul class="dropdown-menu w-100">
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);">grilled 1</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="javascript:void(0);">grilled 2</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-body pt-0">
        <div class="customisable-table custom-table">
          <table class="w-100">
            <thead>
              <tr>
                <th colspan="3">Existing Ingredients</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td width="10%">
                  <img src="<?= asset('images/ketchup_img.svg') ?>" class="img-fluid me-15px" alt="ingredient img 1" width="50" height="50">
                </td>
                <td class="text-left">Ketchup</td>
                <td width="5%">
                  <div class="form-check">
                    <input class="form-check-input from-check-input-yellow" type="checkbox">
                  </div>
                </td>
              </tr>
              <tr>
                <td width="10%">
                  <img src="<?= asset('images/american_cheese_img.svg') ?>" class="img-fluid me-15px" alt="ingredient img 2" width="50" height="50">
                </td>
                <td class="text-left">Cheese</td>
                <td width="5%">
                  <div class="form-check">
                    <input class="form-check-input from-check-input-yellow" type="checkbox" checked>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="customisable-table custom-table mt-4">
          <table class="w-100">
            <thead>
              <tr>
                <th colspan="3">Add Extra Ingredients</th>
              </tr>
            </thead>
          </table>
          <div class="accordion accordion-flush customisable-accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Sauce </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <table>
                    <tbody>
                      <tr>
                        <td width="10%">
                          <img src="<?= asset('images/ketchup_img.svg') ?>" class="img-fluid me-15px" alt="ingredient img 1" width="50" height="50">
                        </td>
                        <td class="text-left">Ketchup <span class="food-custom-price">€05</span>
                        </td>
                        <td width="7%">
                          <div class="foodqty">
                            <span class="minus">
                              <i class="fas fa-minus align-middle"></i>
                            </span>
                            <input type="number" class="count" name="qty" value="1">
                            <span class="plus">
                              <i class="fas fa-plus align-middle"></i>
                            </span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Bun </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <table>
                    <tbody>
                      <tr>
                        <td width="10%">
                          <img src="<?= asset('images/american_cheese_img.svg') ?>" class="img-fluid me-15px" alt="ingredient img 2" width="50" height="50">
                        </td>
                        <td class="text-left">Ketchup <span class="food-custom-price">€20</span>
                        </td>
                        <td width="7%">
                          <div class="foodqty">
                            <span class="minus">
                              <i class="fas fa-minus align-middle"></i>
                            </span>
                            <input type="number" class="count" name="qty" value="1">
                            <span class="plus">
                              <i class="fas fa-plus align-middle"></i>
                            </span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Cheese </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <table>
                    <tbody>
                      <tr>
                        <td width="10%">
                          <img src="<?= asset('images/quarter_pounder_bun_img.svg') ?>" class="img-fluid me-15px" alt="ingredient img 3" width="50" height="50">
                        </td>
                        <td class="text-left">Ketchup <br />
                          <span class="food-custom-price">€20</span>
                        </td>
                        <td width="7%">
                          <div class="foodqty">
                            <span class="minus">
                              <i class="fas fa-minus align-middle"></i>
                            </span>
                            <input type="number" class="count" name="qty" value="1">
                            <span class="plus">
                              <i class="fas fa-plus align-middle"></i>
                            </span>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-top-0 d-block">
        <div class="row">
          <div class="col">
            <div class="foodqty">
              <span class="minus">
                <i class="fas fa-minus align-middle"></i>
              </span>
              <input type="number" class="count" name="qty" value="1">
              <span class="plus">
                <i class="fas fa-plus align-middle"></i>
              </span>
            </div>
          </div>
          <div class="col-xx-6 col-xl-7 col-lg-6 col-md-6 col-sm-12 col-12 text-end float-end ms-auto">
            <a href="javascript:void(0);" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold m-0 w-100">Add To cart <span>| €30</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>