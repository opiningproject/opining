<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DishFavorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use App\Models\User;
Use App\Models\Dish;
use Validator,Redirect,Response;

class DishController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('user.home');
    }

    public function getFavoriteDishes()
    {
        $dishes = DishFavorites::with('dish')->where('user_id',Auth::user()->id)->get();

        return view('user.favorite',['dishes' => $dishes]);
    }

    public function unFavorite(Request $request)
    {
        try {
            DishFavorites::where('dish_id', $request->dish_id)->delete();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function favorite(Request $request)
    {
        if(!Auth::user())
        {
            return response::json(['status' => 2, 'message' => '']);
        }

        try 
        {
            $request->merge(["user_id"=>Auth::user()->id]);

            DishFavorites::create(      
              $request->all()
            );
        } 
        catch (Exception $e) 
        {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function getCollectedPoints()
    {
        return view('user.points');
    }

    public function getDishDetails(Request $request)
    {
        $dish = Dish::find($request->id);
        $options = $dish->option;
        $freeIngredients = $dish->freeIngredients;

        $html_options = '';
        foreach ($options as $key => $option) 
        {
          $html_options .= "<option>$option->name</option>";
        }

        $html_free_ingredients = '';
        foreach ($freeIngredients as $key => $ingredient) 
        {
          $ingredient_name = $ingredient->ingredient->name;
          $ingredient_image = $ingredient->ingredient->image;

          $html_free_ingredients .= "<tr>
                                  <td width='10%'>
                                    <img src='$ingredient_image' class='img-fluid me-15px' alt='ingredient img 1' width='50' height='50'>
                                  </td>
                                  <td class='text-left'>$ingredient_name</td>
                                  <td width='5%'>
                                    <div class='form-check'>
                                      <input class='form-check-input from-check-input-yellow' type='checkbox' checked>
                                    </div>
                                  </td>
                                </tr>";
        }

        $html = "<div class='modal-content'>
                  <div class='modal-header border-0 d-block'>
                    <button type='button' class='btn-close float-end' data-bs-dismiss='modal' aria-label='Close'></button>
                    <div class='customisable-item-detail mt-3 text-center'>
                      <img src='$dish->image' alt='burger' width='100' height='100' id='dish_image'>
                      <h4>$dish->name</h4>
                      <p> Ketchup, sliced onion, slices cheese(2X), Quarter Pound Bun(2X), tomato ketchup, garlic paste</p>
                      <span class='food-custom-price' id='dish_price'>€$dish->price</span>
                      <div class='row justify-content-center'>
                        <div class='col-xl-5'>
                          <div class='form-group mb-0'>
                            <div class='input-group w-100'>
                              <div class='dropdown w-100  ingredientslist-dp custom-default-dropdown'>
                                <select class='form-control bg-white dropdown-toggle d-flex align-items-center justify-content-between w-100'>
                                  $html_options
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class='modal-body pt-0'>
                    <div class='customisable-table custom-table'>
                      <table class='w-100'>
                        <thead>
                          <tr>
                            <th colspan='3'>Existing Ingredients</th>
                          </tr>
                        </thead>
                        <tbody>
                          $html_free_ingredients
                        </tbody>
                      </table>
                    </div>
                    <div class='customisable-table custom-table mt-4'>
                      <table class='w-100'>
                        <thead>
                          <tr>
                            <th colspan='3'>Add Extra Ingredients</th>
                          </tr>
                        </thead>
                      </table>
                      <div class='accordion accordion-flush customisable-accordion' id='accordionExample'>
                        <div class='accordion-item'>
                          <h2 class='accordion-header'>
                            <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapseOne' aria-expanded='true' aria-controls='collapseOne'> Sauce </button>
                          </h2>
                          <div id='collapseOne' class='accordion-collapse collapse show' data-bs-parent='#accordionExample'>
                            <div class='accordion-body'>
                              <table>
                                <tbody>
                                  <tr>
                                    <td width='10%'>
                                      <img src='' class='img-fluid me-15px' alt='ingredient img 1' width='50' height='50'>
                                    </td>
                                    <td class='text-left'>Ketchup <span class='food-custom-price'>€05</span>
                                    </td>
                                    <td width='7%'>
                                      <div class='foodqty'>
                                        <span class='minus'>
                                          <i class='fas fa-minus align-middle'></i>
                                        </span>
                                        <input type='number' class='count' name='qty' value='1'>
                                        <span class='plus'>
                                          <i class='fas fa-plus align-middle'></i>
                                        </span>
                                      </div>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class='accordion-item'>
                          <h2 class='accordion-header'>
                            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapseTwo' aria-expanded='false' aria-controls='collapseTwo'> Bun </button>
                          </h2>
                          <div id='collapseTwo' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
                            <div class='accordion-body'>
                              <table>
                                <tbody>
                                  <tr>
                                    <td width='10%'>
                                      <img src='' class='img-fluid me-15px' alt='ingredient img 2' width='50' height='50'>
                                    </td>
                                    <td class='text-left'>Ketchup <span class='food-custom-price'>€20</span>
                                    </td>
                                    <td width='7%'>
                                      <div class='foodqty'>
                                        <span class='minus'>
                                          <i class='fas fa-minus align-middle'></i>
                                        </span>
                                        <input type='number' class='count' name='qty' value='1'>
                                        <span class='plus'>
                                          <i class='fas fa-plus align-middle'></i>
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
                  <div class='modal-footer border-top-0 d-block'>
                    <div class='row'>
                      <div class='col'>
                        <div class='foodqty'>
                          <span class='minus'>
                            <i class='fas fa-minus align-middle'></i>
                          </span>
                          <input type='number' class='count' name='qty' value='1'>
                          <span class='plus'>
                            <i class='fas fa-plus align-middle'></i>
                          </span>
                        </div>
                      </div>
                      <div class='col-xx-6 col-xl-7 col-lg-6 col-md-6 col-sm-12 col-12 text-end float-end ms-auto'>
                        <a href='javascript:void(0);' class='btn btn-custom-yellow fw-400 text-uppercase font-sebibold m-0 w-100'>Add To cart <span>| €30</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>";

        return response::json(['status' => 1, 'data' => $html]);
    }
}
