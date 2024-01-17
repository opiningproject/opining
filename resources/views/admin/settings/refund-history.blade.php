<div class="tab-pane fade " id="refundPayment-tab-pane" role="tabpanel" aria-labelledby="refundPayment-tab" tabindex="0">
  <div class="card-body">
    <div class="refundPayment-card-body rounded-custom-12 border-custom-1 py-3 pb-0">
      <div class="refundPayment-table custom-table">
        <table class="table mb-0">
          <thead>
            <tr>
              <th scope="col" class="text-center">Order Id</th>
              <th scope="col" class="text-center">User Name </th>
              <th scope="col" class="text-center">Date and Time </th>
              <th scope="col" class="text-center">Transaction ID </th>
              <th scope="col" class="text-center">Price </th>
              <th scope="col" class="text-center" width="20%">Reason </th>
              <th scope="col" class="text-center">Action </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center">
                <div>1254522</div>
              </td>
              <td class="text-center">
                <div>Jonson Jole</div>
              </td>
              <td class="text-center">
                <div>20 Aug 2023 | 8:00 PM</div>
              </td>
              <td class="text-center">
                <div>1254522</div>
              </td>
              <td class="text-center">
                <div>€20</div>
              </td>
              <td class="text-left">
                <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </div>
              </td>
              <td class="text-center">
                <div class="d-flex align-items-center gap-3 flex-lg-wrap flex-xl-nowrap justify-content-center">
                  <a class="btn btn-custom-yellow btn-default d-block px-2 py-1 rounded-2">
                    <span class="align-middle" style="font-size: 11px;">Reject</span>
                  </a>
                  <a class="btn btn-custom-yellow btn-default d-block px-2 py-1 rounded-2">
                    <span class="align-middle" style="font-size: 11px;">Accept</span>
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex flex-wrap pagination-row">
          <div class="text-center pagination-item">
            <div class="d-flex align-items-center gap-3">
              <button class="border-0 outline-0 bg-transparent">
                <img src="{{ asset('images/left-icon.svg') }}" alt="" class="ima-fluid svg" height="24" width="24">
              </button>
              <div class="text text-muted"> 01 of <span class="text-dark fw-600">05</span>
              </div>
              <button class="border-0 outline-0 bg-transparent" style="transform: rotate(180deg);">
                <img src="{{ asset('images/left-icon.svg') }}" alt="" class="ima-fluid svg" height="24" width="24">
              </button>
            </div>
          </div>
          <div class="text-center pagination-item"> 
            <div class="d-flex gap-2 align-items-center">
                <div class="text text-muted">
                  Rows per page 
              </div>
              <select class="form-select rounded-2" style="max-width: 70px;min-height: auto;font-size: 14px;">
                  <option selected>05</option>
                  <option value="1">06</option>
                  <option value="2">07</option>
                  <option value="3">08</option>
                </select>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>