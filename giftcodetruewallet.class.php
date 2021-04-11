<?php 
// Credit : BossNz
namespace BossNz\TrueMoneyWallet;
class Voucher {
	public function redeem($phone, $voucher_hash){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://gift.truemoney.com/campaign/vouchers/'.$voucher_hash.'/redeem',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode(array('mobile' => $phone,'voucher_hash' => $voucher_hash)),
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'accept-encoding: gzip, deflate, br',
				'accept-language: en-US,en;q=0.9',
				'content-length: 59',
				'content-type: application/json',
				'origin: https://gift.truemoney.com',
				'referer: https://gift.truemoney.com/campaign/?v='.$voucher_hash,
				'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 Edg/87.0.664.66',
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		$result = json_decode($response);
		if (isset($result->status->code)) {
			$codestatus = $result->status->code;
			if ($codestatus == "VOUCHER_OUT_OF_STOCK") {
				$message['status'] = "error";
				$message['info'] = "อั๋งเปานี้ถูกใช้งานไปแล้ว";
			} elseif ($codestatus == "VOUCHER_NOT_FOUND") {
				$message['status'] = "error";
				$message['info'] = "ไม่พบอั๋งเปานี้!!";
			} elseif ($codestatus == "VOUCHER_EXPIRED"){
				$message['status'] = "error";
				$message['info'] = "อั๋งเปาหมดอายุ!!";
			} elseif ($codestatus == "SUCCESS"){
				$balance = $result->data->voucher;
				$ownerprofile = $result->data->owner_profile;
				if ($balance->amount_baht == $balance->redeemed_amount_baht) {
					$message['status'] = "success";
					$message['info'] = "เติมเงินสำเร็จ!!";
					$message['amount_baht'] = $balance->redeemed_amount_baht;
					$message['voucher_owner'] = $ownerprofile->full_name;
				} else {
					$message['status'] = "error";
					$message['info'] = "กรุณาแบ่งอั๋งเปาแค่1คน!!";
				}
			} else {
				$message['status'] = "error";
				$message['info'] = "ไม่ทราบสาเหตุ!!";
			}
		} else {
			$message['status'] = "error";
			$message['info'] = "ลิ้งอั๋งเปาไม่ถูกต้อง";
		}
		return $message;
	}
}


?>
