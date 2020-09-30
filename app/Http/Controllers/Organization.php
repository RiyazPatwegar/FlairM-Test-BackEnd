<?php

namespace App\Http\Controllers;

use App\Model\Sql\Organization as OrganizationModel;
use App\Model\Sql\OrganizationContact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

/**
 * Controller Orgnization
 *
 * @license         <add Licence here>
 * @link            https://github.com/riyazpatwegar
 * @author          Riyaz Patwegar
 * @since           Sep 29, 2020
 * @copyright       2020 <https://github.com/riyazpatwegar>
 * @version         1.0
 */

class Organization extends BaseController
{
    /**
     * Get Organization list
     *
     * @param Request $request
     * @return Array
     */
    public function getList(Request $request)
    {
        try {
            $details = OrganizationModel::with('contactDetails')
                ->get();

            $data = [];
            if ($details->isNotEmpty()) {

                $data = $details->toArray();
                $response = [
                    'code'  =>  200,
                    'message'   =>  'success',
                    'data' => $data
                ];
            } else {

                $response = [
                    'code'  =>  400,
                    'message'   =>  'No data found',
                    'data' => []
                ];
            }

            return response($response);
        } catch (\Throwable $e) {

            $response = [
                'code'  =>  400,
                'message'   =>  'Something went wrong',
                'error_message' => $e->getMessage()
            ];

            return response($response);
        }
    }

    /**
     * Create new Organization
     *
     * @param Request $request
     * @return response
     */
    public function createOrganization(Request $request)
    {        
        try {
            $rules = [
                'orgn_name' => ['required','max:50'],
                'orgn_email' => ['required','email','max:44'],
                'orgn_logo' => ['required','image'],
            ];
            $customMessages = [
                'userCode.required' => 'Organization name required',
                'userName.required' => 'Organization logo required',
            ];

            $validator = Validator::make($request->all(), $rules, $customMessages);

            if ($validator->fails()) {
                $message = $validator->messages()->first();
                return response(['code' => 400, 'status' => 'failed', 'message' => $message]);
            }

            if (!$request->hasfile('orgn_logo')) {
                return response(['code' => 400, 'status' => 'failed', 'message' => 'Image is missing']);
            }

            if ($request->hasfile('orgn_logo')) {
                $image = $request->file('orgn_logo');
                $filename = time() . '.' . $image->getClientOriginalExtension();                
                $destinationPath = public_path('/organization_images');
                $image->move($destinationPath, $filename);
                $url = '/organization_images/'.$filename;
            }

            $newOrg = new OrganizationModel();

            $newOrg->orgn_logo = $url;
            $newOrg->orgn_name = $request['orgn_name'];
            $newOrg->orgn_email = $request['orgn_email'];
            $newOrg->save();

            $response = [
                'code'  =>  200,
                'message'   =>  'Success'
            ];

            return response($response);
        } catch (\Throwable $e) {

            $response = [
                'code'  =>  400,
                'message'   =>  'Something went wrong',
                'error_message' =>  $e->getMessage()
            ];

            return response($response);
        }
    }

    /**
     * Add contact details to organization
     *
     * @return response
     */
    public function addOrganizationContact(Request $request)
    {
        try {
            $rules = [
                'orgn_id' => ['required'],
                'contact_name' => ['required','max:45'],
                'contact_email' =>  ['required','email','max:45'],
                'contact_address'   =>  ['required','max:250'],
                'contact_no'    =>  ['required','min:11','min:12','numeric'],
                'contact_photo' =>  ['required','image']
            ];
            $customMessages = [
                'orgn_id.required' => 'Please select organization'
            ];            

            $validator = Validator::make($request->all(), $rules, $customMessages);

            if ($validator->fails()) {
                $message = $validator->messages()->first();
                return response(['code' => 400, 'status' => 'failed', 'message' => $message]);
            }

            if (!$request->hasfile('contact_photo')) {
                return response(['code' => 400, 'status' => 'failed', 'message' => 'Image is missing']);
            }

            if ($request->hasfile('contact_photo')) {
                $image = $request->file('contact_photo');
                $filename = time() . '.' . $image->getClientOriginalExtension();                
                $destinationPath = public_path('/organization_contacts');
                $image->move($destinationPath, $filename);
                $url = '/organization_contacts/'.$filename;
            }

            $contact = new OrganizationContact();

            $contact->contact_img = $url;
            $contact->orgn_id = $request['orgn_id'];
            $contact->contact_name = $request['contact_name'];
            $contact->contact_email = $request['contact_email'];
            $contact->contact_address = $request['contact_address'];
            $contact->contact_no = $request['contact_no'];
            $contact->save();

            $response = [
                'code'  =>  200,
                'message'   =>  'Contact details added successfully'
            ];

            return response($response);
        } catch (\Throwable $e) {

            $response = [
                'code'  =>  200,
                'message'   =>  'Contact details added successfully',
                'error_message' =>  $e->getMessage()
            ];

            return response($response);
        }
    }
}
