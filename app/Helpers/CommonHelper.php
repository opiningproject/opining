<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as Image;
use App\Models\RestaurantDetail;

if (!function_exists('activeMenu')) {
    function activeMenu($path)
    {
        $path = explode('.', $path);
        $segment = 1;
        foreach ($path as $p) {
            if (request()->segment($segment) != $p) {
                return '';
            }
            $segment++;
        }
        return 'active';
    }
}

if (!function_exists('uploadImageToBucket')) {
    function uploadImageToBucket($request, $type, $deleteImg = '')
    {
        if (!empty($deleteImg) && Storage::disk('s3')->exists($type . '/' . $deleteImg)) {
            Storage::disk('s3')->delete($type . '/' . $deleteImg);
            Storage::disk('s3')->delete($type . '/thumb/' . $deleteImg);
        }

        $file = $request->file('image');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $image = Image::make($file)->resize(300, 300);
            Storage::disk('s3')->put('/' . $type . '/thumb/' . $file_name, $image->stream());
        }

        $filePath = $type . '/' . $file_name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));

        return $file_name;
    }
}

if (!function_exists('uploadPermitDocImageToBucket')) {
    function uploadPermitDocImageToBucket($request, $type, $deleteImg = '')
    {
        if (!empty($deleteImg) && Storage::disk('s3')->exists($type . '/' . $deleteImg)) {
            Storage::disk('s3')->delete($type . '/' . $deleteImg);
            Storage::disk('s3')->delete($type . '/thumb/' . $deleteImg);
        }

        $file = $request->file('permit-doc');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $image = Image::make($file)->resize(300, 300);
            Storage::disk('s3')->put('/' . $type . '/thumb/' . $file_name, $image->stream(), 'public');
        }

        $filePath = $type . '/' . $file_name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));

        return $file_name;
    }
}

if (!function_exists('deleteImage')) {
    function deleteImage($type, $id)
    {
        $food_image = FoodImages::find($id);
        $image = $food_image->getRawOriginal('image');

        if (!empty($food_image) && Storage::disk('s3')->exists($type . '/' . $image)) {
            Storage::disk('s3')->delete($type . '/' . $image);
            Storage::disk('s3')->delete($type . '/thumb/' . $image);

            $food_image->delete();
        }
    }
}

if (!function_exists('checkValidation')) {
    function checkValidation($request, $validate)
    {
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return $validator->messages()->first();
        } else {
            return '';
        }
    }
}

if (!function_exists('getRestaurantDetail')) {
    function getRestaurantDetail()
    {
        $rest = RestaurantDetail::findOrFail(1);

        return $rest;
    }
}

if (!function_exists('getOrderDishIngredients')) 
{
    function getOrderDishIngredients($dish)
    {
        $ingredients = '';

        if(!empty($dish->orderDishIngredients))
        {
            foreach($dish->orderDishIngredients as $key => $ingredient)
            {
                $ingredients .= $ingredient->dishIngredient->ingredient->name;

                $ingredients .= $ingredient->is_free ? ', ': "($ingredient->quantity"."x), ";

            } 
        }

        return trim($ingredients,', ');
                                                                                
    }
}
