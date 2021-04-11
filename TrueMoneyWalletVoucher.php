<?php 
	/**
		*
		* True Money Wallet - API
		*
		* This is Open Source PHP Code from @bossNzXD and @Framyomyim
		*
		* PHP version 7.3^
		*
		* @category		PHP Library
		* @author		Original Author @bossNzXD (https://github.com/bossNzXD)
		* @author		Another Author @Framyomyim (https://github.com/Framyomyim)
		* @version		1.1
		* @link 		https://github.com/Framyomyim/vouchertruewallet_api
	*/

	namespace BossNz\TrueMoneyWallet;
	
	class Voucher {
		private $_phoneNumber;
		private $_voucherHash;

		const INPUT_PHONE_TYPE = 'TrueMoneyWalletPhoneNumber';
		const INPUT_VOUCHER_TYPE = 'TrueMoneyWalletVoucherHash';

		/** 
			* @method setUser
			* @param array $arrayData | User Data (Phone, VoucherHash)
			* @return true & null
		*/
		public function setUser(array $arrayData) {
			if(isset($arrayData[self::INPUT_PHONE_TYPE]) && isset($arrayData[self::INPUT_VOUCHER_TYPE])) {
				$this->_phoneNumber = $arrayData[self::INPUT_PHONE_TYPE];
				$this->_voucherHash = $arrayData[self::INPUT_VOUCHER_HASH];

				return true;
			} else {
				return null;
			}
		}

		private function createRequest() {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://gift.truemoney.com/campaign/vouchers/' . $this->_voucherHash . '/redeem',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode(array('mobile' => $this->_phoneNumber,'voucher_hash' => $this->_voucherHash)),
				CURLOPT_HTTPHEADER => array(
					'accept: application/json',
					'accept-encoding: gzip, deflate, br',
					'accept-language: en-US,en;q=0.9',
					'content-length: 59',
					'content-type: application/json',
					'origin: https://gift.truemoney.com',
					'referer: https://gift.truemoney.com/campaign/?v=' . $this->_voucherHash,
					'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 Edg/87.0.664.66',
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);

			return response;
		}

		/** 
			* @method redeem
			* @return array (status, info, others if success)
		*/
		public function redeem() {
			$response = $this->createRequest();
			$result = json_decode($response);
			if (isset($result->status->code)) {
				$codeStatus = $result->status->code;
				if ($codeStatus == "VOUCHER_OUT_OF_STOCK") {
					$message['status'] = "error";
					$message['info'] = "อั๋งเปานี้ถูกใช้งานไปแล้ว";
				} elseif ($codeStatus == "VOUCHER_NOT_FOUND") {
					$message['status'] = "error";
					$message['info'] = "ไม่พบอั๋งเปานี้!!";
				} elseif ($codeStatus == "VOUCHER_EXPIRED"){
					$message['status'] = "error";
					$message['info'] = "อั๋งเปาหมดอายุ!!";
				} elseif ($codeStatus == "SUCCESS"){
					$balance = $result->data->voucher;
					$ownerProfile = $result->data->owner_profile;
					if ($balance->amount_baht == $balance->redeemed_amount_baht) {
						$message['status'] = "success";
						$message['info'] = "เติมเงินสำเร็จ!!";
						$message['amount_baht'] = $balance->redeemed_amount_baht;
						$message['voucher_owner'] = $ownerProfile->full_name;
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
