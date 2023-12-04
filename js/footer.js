document.write(`<footer>
        <div class="footer-logo">
            <a href="javascript:void(0);">
                <p class="mb-0">Gomeal<span class="text-yellow-1">.</span></p>
            </a>
        </div>
        <p class="mb-0 footer-copyright-text">Gomeal &copy; 2023 Gomeal - ALL
            Rights Reserved</p>
    </footer>`)

$(document).on('click','.pagination-dropdown-value', function (){
    var limit = $('.pagination-dropdown-value').val()

    var modelConditions = [];
    var pageNo = 1
    var model = 'Order';

    modelConditions['payment_status'] = 1;
    modelConditions['order_status'] = 6;
    console.log(modelConditions)
    // console.log(JSON.stringify(modelConditions));

    $.ajax({
        url: baseURL + '/get-paginate-data',
        type: 'POST',
        data: {
            limit,
            pageNo,
            model,
            conditions: JSON.stringify(modelConditions)
        },
        success(response){

        }
    })

})
