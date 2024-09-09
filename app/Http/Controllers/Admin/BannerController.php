<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use PHPUnit\Exception;
use Illuminate\Http\Request;
use Response;

class BannerController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            if ($request->has('image')) {
                $imageName = uploadImageToBucket($request, 'banners/');
            }
            $storedBanner = Banner::orderBy('sort_order', 'desc')->first();
            $addBanner = new Banner();
            $addBanner->image = $imageName;
            $addBanner->content_en = $request->content_en;
            $addBanner->content_nl = $request->content_nl;

            if (empty($storedBanner->sort_order)) {
                $addBanner->sort_order = 1;
            } else {
                $addBanner->sort_order = $storedBanner->sort_order + 1;
            }

            $addBanner->save();
            return redirect()->back()->with(['message' => trans('rest.message.banner_add_success')]);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Banner::find($id)->delete();
            return response::json(['status' => 200, 'message' => trans('rest.message.banner_delete_success')]);

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @return mixed
     */
    public function updateBannerStatus(Request $request, string $id)
    {
        try {
            $banner = Banner::find($id);
            if ($banner) {
                $banner->status = $request->status;
                $banner->save();

                return response::json(['status' => 200, 'data' => $banner, 'message' => trans('rest.message.banner_status_success')]);
            } else {
                return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
            }

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @return mixed
     */
    public function updateBanner(Request $request, string $id)
    {
        try {
            $banners = Banner::find($id);
            if ($banners) {
                if ($request->has('image')) {
                    $imageName = uploadImageToBucket($request, 'banners/', '');
                    $banners->image = $imageName;
                }
                $banners->content_en = $request->content_en;
                $banners->content_nl = $request->content_nl;
                $banners->save();

                return response::json(['status' => 200, 'message' => trans('rest.message.banner_updated_success')]);

            } else {
                return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
            }
            return response::json(['status' => 200, 'data' => $banners]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    /**
     * @param Request $request
     */
    public function updateBannerRowOrder(Request $request)
    {
        foreach ($request->order as $key => $order) {
            $data = Banner::find($order['id']);
            $data->sort_order = $order['position'];
            $data->save();
        }
    }
}
