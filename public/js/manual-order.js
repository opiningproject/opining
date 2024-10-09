$(function () {
    $('.add-customer').on("click", function () {
        $('.create-customer-popup').modal('show')
    });
})
function getDishes(catId) {
    console.log("eee", $(this))
    // var targetOffset = $('.section-page-title').offset().top;
    // $('html, body').animate({
    //     scrollTop: targetOffset
    // }, 500);
    $('.tab-listing .category').removeClass('active');  // Remove active class from all
    $('.category-' + catId + ' .category').addClass('active');
    if(!catId) {
        catId = $('#view-all-dishes').attr('data-category-id');
    }
    activateSlide(catId);

    $.ajax({
        url: `${baseURL}/get-dish/${catId}`,
        type: 'GET',
        success: function (response) {

            // window.history.pushState('',app_name, '/user/dashboard/'+catId);

            // update view all button attribute id
            $('#view-all-dishes').attr('data-category-id',catId);

            $('.sub-title').text(response.cat_name)
            $('.order-listing-row').html(response.data)
        },
        error: function (response) {}
    })

}
function activateSlide(categoryId) {

    // Find the index of the slide with the given category ID
    var slideIndex = $('.swiper-slide[data-category-id="' + categoryId + '"]').index();
    // Check if the slide index is valid
    if (slideIndex >= 0) {
        // Use Swiper's slideTo method to make the specific slide active
        swiper.slideTo(slideIndex);

        // Remove active class from all slides
        $('.swiper-slide').removeClass('selected-cart-active swiper-slide-active');

        // Add active class to the selected slide
        $('.swiper-slide[data-category-id="' + categoryId + '"]').addClass('selected-cart-active swiper-slide-active');
    }
}

//customizeDish
function customizeDish(id, doesExist=0)
{
    console.log("in")
    $.ajax({
        url: baseURL+'/user/get-dish-details/'+id+'/'+doesExist,
        type: 'GET',
        success: function (response) {

            var data = response.data;

            if(response.status == 2)
            {
                $('#signInModal').modal('show');
                return false;
            }

            $('.customisable-modal-body').html(data);

            $("#customisableModal").modal("show");

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })


}
