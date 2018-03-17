<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Name:  Codeigniter voucher library API for  Geniki's web API SOAP/WSDL
 * Author:  Elias Sdogos
 * Email: elsdogos@gmail.com
 * @link https://github.com/eliassdogos/
 * @filesource
 */


class My_voucher {

public $user;
public $pass;
public $api;
public $url;

	public function __construct()
	{
        //Initialize the Library and parse vars from Config
		      	$this->CI =& get_instance();
			 	$this->CI->load->config('myvoucher_config');
			 	$this->user=$this->CI->config->item('user','voucher');
				$this->pass=$this->CI->config->item('pass','voucher');
				$this->api=$this->CI->config->item('api','voucher');
				$this->url=$this->CI->config->item('url','voucher');
	}

                            public function connect()
                            {       try { $soap = new SoapClient($this->url);
                                            $oAuthResult = $soap->Authenticate(
                                                                        array(
                                                                                'sUsrName' => $this->user,
                                                                                    'sUsrPwd' => $this->pass,
                                                                                        'applicationKey' => $this->api,
                                                                                                                )
                                                                                                                        );
                                            if ($oAuthResult->AuthenticateResult->Result == 0) {
                                                                $secondpasskey=$this->secondpasskey=$oAuthResult->AuthenticateResult->Key;//Obtain second PassKey
                                                                                                }
                                        }///end try
                                                catch(SoapFault $fault) {
                                                        echo $fault;
                                                        }

                            }// End Connect Function


                            public function assign2key()
                            {	
                                    return $this->secondpasskey;
                                
                                }//end function assign2key



                                public function get_status_for_jobid($key,$jobid)
                                        {
                                                $soap = new SoapClient($this->url);
                                                $xml = array(
                                                'sAuthKey' => $key,
                                                'nJobId' => $jobid,//Data
                                                );
                                                $resultstatus=$soap->GetVoucherJob($xml);
                                                return $resultstatus;
                                        }//end function


                        public function cancel_jobid($key,$jobid)
                        {
                                $soap = new SoapClient($this->url);
                                                           $xml = array(
                                                'sAuthKey' => $key,
                                                'nJobId' => $jobid,// JobId
                                                'bCancel' => true, //If cancel parameter is true the job is canceled.
                                                          );
                                                $resultcancel=$soap->CancelJob($xml);
                                                return $resultcancel;
                                          }//end function





                                public function create_voucher_and_insert($secondkey,$datacustomer,$orderid)
                                {
                                $soap = new SoapClient($this->url);
                                $xml = array(
                                'sAuthKey' => $secondkey,
                                'oVoucher' => $datacustomer,//Data Customer is Array() with Order's data
                                'eType' =>  "Voucher"
                                );
                                        $oResult = $soap->CreateJob($xml); //Voucher creation (Usage of the CreateJob method)
                                        $newvoucher=$this->voucherID=$oResult->CreateJobResult->Voucher; //Initilize Variable voucherID which is voucher number that this job created and assign as public to Variable $newvoucher
                                        $newvoucherreturn=$this->newvoucherreturn=$newvoucher;//Global Variable To Current Library
                                        $jobidcreated=$this->voucherID=$oResult->CreateJobResult->JobId;
                                        return $jobidcreated; //Send Result of Voucher Create Method
                                          }


                                public function get_current_voucher()
                                          {
                                             return $this->newvoucherreturn;
                                                   }//end function


                                public function track_and_trace($datav){
                                         $soap = new SoapClient($this->url);
                                                $TT = $soap->TrackAndTrace($datav);
                                                        return $TT;
                                        }//end function








}//End Of Class