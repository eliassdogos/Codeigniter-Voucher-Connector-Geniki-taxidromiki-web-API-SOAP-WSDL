<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:  Codeigniter voucher library API for  Geniki's web API SOAP/WSDL
 * Author:  Elias Sdogos
 * Email: elsdogos@gmail.com
 * @link https://github.com/eliassdogos/
 * @filesource
 * You should understand the functions from library and fork the code fro your needs
 */

/// Get from form your order id or order data


 if(!empty($orderdata)){
   $this->my_voucher->connect();
       $secondkey=$this->my_voucher->assign2key();
           $currentvoucher=$this->YOUR_voucher_model->get_currentvoucher(); // Get Existing Voucher ID Number from orders table // Your custom code here
                        if($currentvoucher->num_rows() > 0){
                            	 foreach (  $currentvoucher->result_array() as $myvouchertable){
                                             $currentvouchernumber=$myvouchertable["yourCollumbDataName"];
                                              $jobidres=$myvouchertable["yourCollumbDataName"];
                                                }
                                           $data_for_search_voucher = array (
                                         	    'authKey' => $secondkey,
                                         	        'voucherNo' => $currentvouchernumber,
                                         	            'language' => 'el'
                                         	                  );
                                $statusvoucher=$this->my_voucher->track_and_trace($data_for_search_voucher);
                                $result_for_current_voucher=$this->my_voucher->get_status_for_jobid($secondkey,$jobidres);
                                $vouche_status_flag=$result_for_current_voucher->GetVoucherJobResult->Job->IsCanceled;
                        if($vouche_status_flag==1){$vouche_status_flagmsg="Voucher has Cancelled";}
                        if($vouche_status_flag==0){$vouche_status_flagmsg="Voucher Ready";}  ?>


                        <div class="col-md-12">
                          <h3><?php echo "Order Number: ".$orderdata." / Voucher Number :".$currentvouchernumber." / Status Voucher: ".$vouche_status_flagmsg?></h3>
<?php   if($vouche_status_flag==0){ ?>
        						<table class="table table-hover"><thead><tr>
        								<th>#</th>
        								<th>Status</th>
        								<th>Date</th>
        								<th>City</th>
        							</tr></thead><tbody>
                        <?php $points=$statusvoucher->TrackAndTraceResult->Checkpoints->Checkpoint;
                              $j=1;foreach ($points as $place => $report) { ?>
                							<tr>
                								<th scope="row"><?php echo $j;?></th>
                								<td><?php echo $report->Status;?></td>
                								<td><?php echo $report->StatusDate;?></td>
                								<td><?php echo $report->Shop;?></td>
                							</tr>
        					                 <?php $j=$j+1; } ?>
                  <tr>
                    <th colspan="4"scope="row"><?php
                    echo $statusvoucher->TrackAndTraceResult->Status." στις ".$statusvoucher->TrackAndTraceResult->DeliveryDate; ?></th>
                  </tr>
        							</tbody>
        						</table>
                  <?php } ?>
					           </div>
                <?php
                }//end of if
              }/// end if post order data  ?>
