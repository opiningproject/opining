<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\CMS;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\User;
use App\Models\ManageMessages;
use Response, Mail;
use App\Enums\UserType;

class CMSController extends Controller
{
   public function getCommonLinks(Request $request)
   {
      $root_url = url('/').'/page?type=';

      $about_us = $root_url.'about-us';
      $faq = $root_url.'faq';
      $terms = $root_url.'terms';
      $legal = $root_url.'legal';
      $privacy_policy = $root_url.'privacy-policy';

      return response()->json([
              'status' => '1',
              'message' => '',
              'data'    => [
                  'links' => [
                    'about_us' => $about_us,
                    'faq' => $faq,
                    'terms' => $terms,
                    'legal' => $legal,
                    'privacy_policy' => $privacy_policy,
                  ],
              ]
          ], 200);
   }

   public function contactUs(Request $request)
   {
        $data = $request->all('name','email','notes');

        if(isEmpty($data) == 1)
        {
            return response()->json([
            'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }

        $contact = new ContactUs;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->notes;
        
        if($contact->save())
        {
            $link = url('/contact-us').'/'.$contact->id.'/edit';

            $data = [
              'title' => $request->name, 
              'email' => $request->email, 
              'description' => $request->notes, 
              'link' => $link
            ];

            $adminEmails = User::where('user_role', 1)->get();

            foreach ($adminEmails as $key => $admin) 
            {
              $data['name'] = $admin->first_name.' '.$admin->last_name;

              Mail::send('admin.emails.admin-contact-email', $data, function($message) use($admin)  {
                 $message->to( $admin->email, $admin->first_name.' '.$admin->last_name)->subject(trans('api.contact_us_mail_subject'));
                 $message->from(config('mail.from.address'),config('mail.from.name'));
              });
            }

            return response::json(['status' => '1', 'message' => trans('api.contact_us_success')]);
        } else {
            return response::json(['status' => '0', 'message' => trans('api.something_wrong')]);
        }
   }
   
}
