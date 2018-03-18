#Codeigniter MyVoucher


Custom Library for interaction with API Geniki Taxidromiki Greek Shipper Company (https://www.taxydromiki.com/ )

#Important. This code is tested on Geniki's web API SOAP/WSDL web service version 2018.
#Works on Codeigniter >= 3.1.4

STEPS
1. First you must have signed to Geniki Taxidromiki and optain Username - Password and API KEY for live and production  environment.
2. All Functions are the same for LIVE and PRODUCTION enviroment. The only change is to set up the fileds in application/config/* for each case
3. Stay Tuned Test / Commit 3/2018
4. Not Finished the commits. Stay Tunned. 



# Methods / Library application/myvoucher

1. Connect() . Connect and check Connection
2. Assign2key() Get Second key after succes connection
3. get_status_for_jobid() Get result array and status of current JobID assigned to OrderId
4. cancel_jobid() Cancel Voucher with specified JobId
5. create_voucher_and_insert() Create Voucher to Geniki's API
6. get_current_voucher() Get Voucher Number to Use everywhere you want
7. track_and_trace() Array of Voucher Log History . Usefull to make script for "Where is my order?"
8. close_voucher_untill_now() Notify Geniki's API with ne vouchers. Products are ready to pick up by shipper.