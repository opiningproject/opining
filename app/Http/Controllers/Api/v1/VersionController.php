<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Version;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class VersionController extends Controller
{
   /**
    * Common logout api for userApp and adminApp
    *
    * @return response
    **/

   public function getAppVersion(Request $request)
   {
      $data = $request->all('device_type','current_version');

      if(isEmpty($data) == 1)
      {
          return response()->json([
          'status' => '0',
              'message' => trans('api.something_wrong'),
          ], 200);
      }

      $latest_version = Version::where('device_type',$request->device_type)->orderby('id','desc')->get()->first();

      if(!empty($latest_version))
      {
          $currentVersionArray = explode(".",$request->current_version);
          $dbVersionArray = explode(".", $latest_version->version_name);

          $isUpdateAvailable = 0;
          $forward = 0;

          for ($i = 0; $i < count($currentVersionArray); $i++) 
          {
              $cv = (int)$currentVersionArray[$i];
              $fv = (int)$dbVersionArray[$i];

              if (!$forward) 
              {
                  if ($cv < $fv) 
                  {
                      $isUpdateAvailable = 1;
                      break;
                  }
              }

              if ($cv > $fv) 
              {
                  $forward = 1;
              }
          }

          if ($isUpdateAvailable == 0) 
          {
              $message = trans('api.version.app_up_to_date');
              $data['device_type']        = $request->device_type;
              $data['version_name']       = $request->current_version;
              $data['force_update']     = '0';
              $data['is_new_version_available'] = '0';

              return response()->json(['status' => "1",'message' => $message,'data' => $data]);

          } 
          else 
          {
            $message = "";
            $data = [];

              if ($latest_version->force_update) 
              {
                  $data['force_update'] = '1';
                  $data['is_new_version_available'] = '1';
                  $message = trans('api.version.new_version_available_force');
              }
              // Check if there's any intermediate forceful update.
              else 
              {

                  $forceUpdate = Version::where(
                          [
                              'device_type' => $request->device_type,
                              'force_update'   => 1,
                          ]
                      )
                      ->where('version_name', '>' ,$request->current_version)
                      ->get()->first();

                  if ($forceUpdate) 
                  {
                      $data['force_update'] = '1';
                      $data['is_new_version_available'] = '1';
                      $message = trans('api.version.new_version_available_force');
                  } 
                  else 
                  {
                      $data['force_update'] = '0';
                      $data['is_new_version_available'] = '1';
                      $message = trans('api.version.new_version_available');
                  }
              }

              return response()->json(['status' => '1' ,'message' => $message,'data' => $data]);
            
          }
      }
      else
      {
        return response()->json(['status' => '1','message' => trans('api.no_data_found'),'data'=>(object)[]]);
      } 
   }

   public function postApiLog(Request $request)
   {
      $data = $request->all('api_name','params','response');

      if(isEmpty($data) == 1)
      {
          return response()->json([
          'status' => '0',
              'message' => trans('api.something_wrong'),
          ], 200);
      }

      $data['time'] = date('H:i:s d-m-Y');

      $myfile = fopen('log.txt', "a") or die("Unable to open file!");
      fwrite($myfile, json_encode($data)."\r\n\n\n");
      fclose($myfile);
   }
   
}
