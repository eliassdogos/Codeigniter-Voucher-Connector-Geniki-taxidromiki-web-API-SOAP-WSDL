<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Name:  Codeigniter voucher library API for  Geniki's web API SOAP/WSDL
 * Author:  Elias Sdogos
 * Email: elsdogos@gmail.com
 * @link https://github.com/eliassdogos/
 * @filesource
 */

class Printvoucher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('voucher_model');// Your CRUD for Order Tables and Vouchers in database
        $this->load->library(array('my_voucher'));
        $this->load->config('myvoucher_config');
    }

    public function index()
    {
        $mergeprintvoucher=null; // Default URL Vouchers to Print are null

        $ids=$this->input->get("id");// Get Orders ID from multiple Input Checkbox id[]

        $this->my_voucher->connect(); // Connect To Geniki Taxidromiki API and optain second key

        $secondkey=$this->my_voucher->assign2key(); // Assign second key to Var

        foreach ($ids as $value) {
            $istherevoucher=$this->voucher_model->YOUR_QUERY_FUNCTION_TO_CHECK($value); // Checking if Order has no Voucher
            if ($istherevoucher->num_rows() > 0) {
                foreach ($istherevoucher->result_array() as $voucherdata) {
                    /////Fill The array with tour records from Database
                    $oVoucher = array(
                        'OrderId' => $voucherdata["your_column"],
                        'Name' => $voucherdata["your_column"],
                        'Address' => 'Test address',
                        'City' => 'Test city',
                        'Telephone' => '2109999999',
                        'Zip' => '12345','Destination' => "",
                        'Courier' => "",
                        'Pieces' => 3,
                        'Weight' => 12,
                        'Comments' => 'Test comment','Services' => "αν",
                        'CodAmount' => 1234.56,
                        'InsAmount' => 0,
                        'VoucherNumber' => "",
                        'SubCode' => "",
                        'BelongsTo' => "",
                        'DeliverTo' => "",
                        'ReceivedDate' => "2012-01-01"
                        );
                    $jobid=$this->my_voucher->create_voucher_and_insert($secondkey, $oVoucher, $voucherdata["Columnu_of_Order_id"]);//Assign to variable JobId Result of Voucher Create Method

                    $currentvoucher=$this->my_voucher->get_current_voucher();//Geting Voucher Number from current orderId

                    $this->voucher_model->insert_vouche_data_to_your_database($currentvoucher, $voucherdata["Columnu_of_Order_id"], $jobid); // Insert Voucher Id To Database / Order details // Optional. It depends your Tables and what you want

                    $newprintvoucher="&voucherNumbers=".urlencode($currentvoucher);//Assign Current Voucher Number To URL variable "&voucherNumbers="
                }//End foreach  loop


    $mergeprintvoucher.=$newprintvoucher;// Merge &voucherNumbers= to URL
            }//End If OrderId has no Voucher
        }///End Loop for OrderID Checked


$secondkeyencoded=urlencode($secondkey);// Encode key string for URL GET Method to Geniki

        $urlforgreekshiper=$this->config->item('urlpost', 'voucher');// GEting URL to post Voucher

        $urlprintvoucher=$urlforgreekshiper.$secondkeyencoded.$mergeprintvoucher."&Format=Sticker&extraInfoFormat=None";//Setting URL

        redirect($urlprintvoucher);// and Redirect to print PDFS
    }///End function index Voucher Create
}/// End of Controller
