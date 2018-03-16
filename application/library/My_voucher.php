<?php defined('BASEPATH') OR exit('No direct script access allowed');

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

















}//End Of Class