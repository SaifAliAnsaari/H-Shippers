<?php

namespace App\Http\Controllers;

use App\Customer as Cust;
use Illuminate\Http\Request;
use DB;
use URL;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;

class Customer extends ParentController
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
         parent::get_notif_data();
        return view('customer.customer', [ 'customers' => Cust::selectRaw('id, company_name')->get(), 'types' => DB::table('customer_types')->get(), 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    //Ajax Call from list-customers.js
    public function CustomersList(){
        // GetCustomersList
        echo json_encode( DB::table('customers as cust')->select('id', 'company_name', 'company_poc', 'customer_type', 'country', DB::raw('IFNULL(region, "NA") as region'), DB::raw('IFNULL((SELECT company_name from customers where id = cust.parent_company), "NA") as parent_company'))->get());
    }

    public function viewProfile($customerId){
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('customer.profile', [ 'customers' => Cust::select('id', 'company_name')->get(), 'types' => DB::table('customer_types')->get(), 'update_customer' => DB::table('customers')->where('id', $customerId)->first(), 'check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        parent::get_notif_data();
         parent::VerifyRights();if($this->redirectUrl){return redirect($this->redirectUrl);}
        return view('customer.create', ['check_rights' => $this->check_employee_rights, 'notifications_counts' => $this->notif_counts, 'notif_data' => $this->notif_data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'businessPh' => 'required|max:100|numeric',
        //     'compName' => 'required|max:100'
        // ]);
        $customer = new Cust;
        $customer->company_name = $request->compName;
        $customer->company_poc = $request->poc;
        $customer->job_title = $request->jobTitle;
        $customer->business_phone = $request->businessPh;
        $customer->home_phone = $request->homePh;
        $customer->mobile_phone = $request->mobPh;
        $customer->whatsapp_phone = $request->whatsappPh;
        $customer->fax_number = $request->faxPh;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->state = $request->state;
        $customer->country = $request->country;
        $customer->region = $request->region;
        $customer->email = $request->email;
        $customer->webpage = $request->webpage;
        $customer->customer_acquisition_source = $request->acqSource;
        $customer->remarks = $request->description;
        $customer->customer_type = $request->type;
        $customer->parent_company = $request->parentCompnay;
        
        if($request->hasFile('compPicture')){
            $completeFileName = $request->file('compPicture')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('compPicture')->getClientOriginalExtension();
            $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
            $path = $request->file('compPicture')->storeAs('public/company', $compPic);
            $customer->picture = $compPic;
        }

        if($customer->save()){
            $delivPorts = explode(",", $request->delivery_ports);
            foreach($delivPorts as $port){
                DB::table('customer_delivery_ports')->insert(array('customer_id' => $customer->id, 'port_name' => $port));
            }

            $docTypes = explode(",", $request->document_types);
            foreach($docTypes as $type){
                DB::table('customer_documents')->insert(array('customer_id' => $customer->id, 'document_id' => $type));
            }
            echo json_encode($customer->id);
            
        }

        // DB::table('customer_delivery_ports')->insert(array('customer_id' => $customer->id, 'port_name' => ));

        // $customer->type = $request->documentTypes;
        // $customer->type = $request->deliveryPorts;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo json_encode(array('info' => DB::table('customers as cust')->selectRaw('`id`, `company_name`, `company_poc`, `job_title`, `business_phone`, `home_phone`, `mobile_phone`, `whatsapp_phone`, `fax_number`, `address`, `city`, `state`, `country`, `region`, `email`, `webpage`, `remarks`, `customer_type`, `customer_acquisition_source`, `parent_company`, `picture`')->where('id', $id)->first(), 'delivery_ports' => DB::table('customer_delivery_ports')->select('port_name')->where('customer_id', $id)->get(), 'document_types' => DB::table('customer_documents')->select('document_id')->where('customer_id', $id)->get(), 'base_url' => URL::to('/')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Cust::find($id);

        $customer->company_name = $request->compName;
        $customer->company_poc = $request->poc;
        $customer->job_title = $request->jobTitle;
        $customer->business_phone = $request->businessPh;
        $customer->home_phone = $request->homePh;
        $customer->mobile_phone = $request->mobPh;
        $customer->whatsapp_phone = $request->whatsappPh;
        $customer->fax_number = $request->faxPh;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->state = $request->state;
        $customer->country = $request->country;
        $customer->region = $request->region;
        $customer->email = $request->email;
        $customer->webpage = $request->webpage;
        $customer->customer_acquisition_source = $request->acqSource;
        $customer->remarks = $request->description;
        $customer->customer_type = $request->type;
        $customer->parent_company = $request->parentCompnay;

        if($request->hasFile('compPicture')){
            $existingImg = $customer->picture;
            if(Storage::exists('public/company/'.$existingImg)){
                Storage::delete('public/company/'.$existingImg);
            }

            $completeFileName = $request->file('compPicture')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('compPicture')->getClientOriginalExtension();
            $compPic = str_replace(' ', '_', $fileNameOnly).'-'. rand() .'_'.time().'.'.$extension;
            $path = $request->file('compPicture')->storeAs('public/company', $compPic);
            $customer->picture = $compPic;
        }

        $customer->save();
        if($customer->save()){
            DB::table('customer_delivery_ports')->where('customer_id', $id)->delete();
            $delivPorts = explode(",", $request->delivery_ports);
            foreach($delivPorts as $port){
                DB::table('customer_delivery_ports')->insert(array('customer_id' => $id, 'port_name' => $port));
            }

            DB::table('customer_documents')->where('customer_id', $id)->delete();
            $docTypes = explode(",", $request->document_types);
            foreach($docTypes as $type){
                DB::table('customer_documents')->insert(array('customer_id' => $id, 'document_id' => $type));
            }
            echo json_encode('success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($customerId)
    {
        DB::table('customer_documents')->where('customer_id', $customerId)->delete();
        DB::table('customer_delivery_ports')->where('customer_id', $customerId)->delete();
        
        if(Storage::exists('public/company/'.Cust::find($customerId)->picture)){
            Storage::delete('public/company/'.Cust::find($customerId)->picture);
        }
        $status = Cust::find($customerId)->delete();
        if($status){
            echo json_encode('success');
        }else{
            echo json_encode('Exception: ' + $status);
        }
    }

    //Api Call
    public function getCustomers(){
        $jar = new JsonApiResponse('success', '200', Cust::all());
        return $jar->apiResponse();
    }

    //Api Call
    public function customerMeta(){
        $jar = new JsonApiResponse('success', '200', array('types' => array(array('id' => 1, 'title' => 'Residential'), array('id' => 2, 'title' => 'Corporate'), array('id' => 2, 'title' => 'Commercial')), 'acquisition_sources' => array('Source 1', 'Source 2', 'Source 3'), 'parent_company' => Cust::select('id', 'company_name')->get()));
        return $jar->apiResponse();
    }

    //Api Call
    public function storeCustomer(Request $request){
        
        $customer = new Cust;

        $rules = [
            'customer_type' => 'required|numeric',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors = array();
            $counter = 0;
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                $errors[$counter]["field"] = $field_name;
                $errors[$counter]["errors"] = $messages;
                $counter++;
            }
            $jar = new JsonApiResponse('failed', '102', $errors);
            return $jar->apiResponse();
        }

        if($request->customer_type == 1){
            $rules = [
                'company_name' => 'required|max:200',
                'home_phone' => 'max:30',
                'cnic' => 'max:20'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = array();
                $counter = 0;
                foreach ($validator->messages()->getMessages() as $field_name => $messages)
                {
                    $errors[$counter]["field"] = $field_name;
                    $errors[$counter]["errors"] = $messages;
                    $counter++;
                }
                $jar = new JsonApiResponse('failed', '102', $errors);
                return $jar->apiResponse();
            }
            $customer->company_name = $request->company_name;
            $customer->home_phone = $request->home_phone;
            $customer->cnic = $request->cnic;
        }else if($request->customer_type == 2){
            $rules = [
                'organization_name' => 'required|max:200',
                'fax_number' => 'max:50',
                'job_title' => 'max:150',
                'strn' => 'max:100',
                'ntn' => 'max:100'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = array();
                $counter = 0;
                foreach ($validator->messages()->getMessages() as $field_name => $messages)
                {
                    $errors[$counter]["field"] = $field_name;
                    $errors[$counter]["errors"] = $messages;
                    $counter++;
                }
                $jar = new JsonApiResponse('failed', '102', $errors);
                return $jar->apiResponse();
            }
            $customer->organization_name = $request->organization_name;
            $customer->fax_number = $request->fax_number;
            $customer->job_title = $request->job_title;
            $customer->strn = $request->strn;
            $customer->ntn = $request->ntn;
        }else if($request->customer_type == 3){
            $rules = [
                'merchant_name' => 'required|max:200',
                'merchant_type' => 'required|max:100',
                'fax_number' => 'max:50',
                'job_title' => 'max:150',
                'strn' => 'max:100',
                'ntn' => 'max:100'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors = array();
                $counter = 0;
                foreach ($validator->messages()->getMessages() as $field_name => $messages)
                {
                    $errors[$counter]["field"] = $field_name;
                    $errors[$counter]["errors"] = $messages;
                    $counter++;
                }
                $jar = new JsonApiResponse('failed', '102', $errors);
                return $jar->apiResponse();
            }
            $customer->merchant_name = $request->merchant_name;
            $customer->merchant_type = $request->merchant_type;
            $customer->fax_number = $request->fax_number;
            $customer->job_title = $request->job_title;
            $customer->strn = $request->strn;
            $customer->ntn = $request->ntn;
        }

        $rules = [
            'address' => 'max:500',
            'city' => 'max:150',
            'postal_code' => 'max:50',
            'business_phone' => 'max:30',
            'mobile_phone' => 'max:30',
            'email' => 'email|max:30',
            'company_poc' => 'max:100',
            'delivery' => 'max:100',
            'day_of_delivery' => 'max:50',
            'customer_acquisition_source' => 'max:200'
        ];

        if ($validator->fails()) {
            $errors = array();
            $counter = 0;
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                $errors[$counter]["field"] = $field_name;
                $errors[$counter]["errors"] = $messages;
                $counter++;
            }
            $jar = new JsonApiResponse('failed', '102', $errors);
            return $jar->apiResponse();
        }

        $customer->customer_type = $request->customer_type;
        $customer->latitude = $request->latitude;
        $customer->longitude = $request->longitude;
        $customer->mobile_phone = $request->mobile_phone;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->postal_code = $request->postal_code;
        $customer->business_phone = $request->business_phone;
        $customer->mobile_phone = $request->mobile_phone;
        $customer->email = $request->email;
        $customer->company_poc = $request->company_poc;
        $customer->delivery = $request->delivery;
        $customer->day_of_delivery = $request->day_of_delivery;
        $customer->bottles_per_week = $request->bottles_per_week;
        $customer->parent_company = $request->parent_company;
        $customer->customer_acquisition_source = $request->customer_acquisition_source;
        if($request->picture){
            $pic = $this->upload_file($request->picture);
            if($pic["status"] == "success"){
                $customer->picture = $pic["name"];
            }
        }
        $status = $customer->save();
        $jar = new JsonApiResponse('failed', '103', $status);
        if($status){
            $status = "Customer has been saved";
            $jar = new JsonApiResponse('success', '200', $status);
        }
        return $jar->apiResponse();
    }

    function upload_file($encoded_string){
        $target_dir = storage_path('app/public/company'); // add the specific path to save the file
        $decoded_file = base64_decode($encoded_string); // decode the file
        $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
        $extension = $this->mime2ext($mime_type); // extract extension from mime type
        $file = time().'-'.uniqid() .'.'. $extension; // rename file as a unique name
        $file_dir = $target_dir . '/' . $file;
        try {
            file_put_contents($file_dir, $decoded_file); // save
            return array("status" => "success", "name" => $file);
        } catch (Exception $e) {
            return array("status" => "failed", "error" => $e->getMessage());
        }
    
    }
    /*
    to take mime type as a parameter and return the equivalent extension
    */
    function mime2ext($mime){
        $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
        "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
        "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
        "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
        "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
        "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
        "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
        "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
        "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
        "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
        "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
        "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
        "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
        "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
        "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
        "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
        "pdf":["application\/pdf","application\/octet-stream"],
        "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
        "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
        "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
        "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
        "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
        "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
        "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
        "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
        "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
        "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
        "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
        "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
        "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
        "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
        "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
        "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
        "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
        "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
        "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
        "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
        "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
        "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
        "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
        "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
        "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
        "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
        "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
        "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
        $all_mimes = json_decode($all_mimes,true);
        foreach ($all_mimes as $key => $value) {
            if(array_search($mime,$value) !== false) return $key;
        }
        return false;
    }
}
