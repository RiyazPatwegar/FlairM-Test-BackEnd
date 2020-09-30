<?php

namespace App\Http\Controllers;

use App\Model\Sql\Organization as OrganizationModel;
use App\Model\Sql\OrganizationContact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Organization extends BaseController
{
    /**
     * Get Organization list
     *
     * @param Request $request
     * @return Array
     */
    public function getList(Request $request) {
        
        $details = OrganizationModel::with('contactDetails')
        ->get();

        $data = [];
        if($details->isNotEmpty()){
            
            $data = $details->toArray();
            $response = [
                'code'  =>  200,
                'message'   =>  'success',
                'data' => $data
            ];
        }else{

            $response = [
                'code'  =>  400,
                'message'   =>  'No data found',
                'data' => []
            ];
        }        
        
        return response($response);
    }

    /**
     * Create new Organization
     *
     * @param Request $request
     * @return response
     */
    public function createOrganization(Request $request) {

        try {

            $rules = [
                'orgn_name' => ['required'],                
                'orgn_email' => ['required']                
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

            $newOrg = new OrganizationModel();

            $newOrg->orgn_name = $request['orgn_name'];
            //$newOrg->orgn_logo = $request['orgn_name'];
            $newOrg->orgn_email = $request['orgn_email'];
            $newOrg->save();
                                    
            $response = [
                'code'  =>  200,
                'message'   =>  'Success'                    
            ];

            return response($response);

        } catch (\Throwable $e){

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
        try{                   
            $rules = [
                'orgn_id' => ['required'],
                'contact_name' => ['required'],
                'contact_email' =>  ['required'],
                'contact_address'   =>  ['required'],
                'contact_no'    =>  ['required']                
            ];
            $customMessages = [
                'orgn_id.required' => 'Please select organization'                
            ];
            
            //contact_photo

            $validator = Validator::make($request->all(), $rules, $customMessages);
            
            if ($validator->fails()) {
                $message = $validator->messages()->first();
                return response(['code' => 400, 'status' => 'failed', 'message' => $message]);
            }
            
            $contact = new OrganizationContact();
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
