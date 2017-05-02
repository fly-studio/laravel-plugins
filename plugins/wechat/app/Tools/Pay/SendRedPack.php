<?php
namespace Plugins\Wechat\App\Tools\Pay;

/**
 *
 * 统一下单输入对象
 *
 */
class SendRedPack extends Base
{
	/**
	 * 设置微信分配的公众账号ID
	 * @param string $value
	 **/
	public function setAppid($value)
	{
		$this->values['wxappid'] = $value;
		return $this;
	}

	/**
	 * 获取微信分配的公众账号ID的值
	 * @return 值
	 **/
	public function getAppid()
	{
		return $this->values['wxappid'];
	}

	/**
	 * 判断微信分配的公众账号ID是否存在
	 * @return true 或 false
	 **/
	public function isAppidSet()
	{
		return array_key_exists('wxappid', $this->values);
	}

	/**
	 * 设置微信支付分配的商户号
	 * @param string $value
	 **/
	public function setMchId($value)
	{
		$this->values['mch_id'] = $value;
		return $this;
	}

	/**
	 * 获取微信支付分配的商户号的值
	 * @return 值
	 **/
	public function getMchId()
	{
		return $this->values['mch_id'];
	}

	/**
	 * 判断微信支付分配的商户号是否存在
	 * @return true 或 false
	 **/
	public function isMchIdSet()
	{
		return array_key_exists('mch_id', $this->values);
	}

	/**
	 * 设置商户名称
	 * @param string $value
	 **/
	public function setSendName($value)
	{
		$this->values['send_name'] = $value;
		return $this;
	}

	/**
	 * 获取商户名称
	 * @return 值
	 **/
	public function getSendName()
	{
		return $this->values['send_name'];
	}
	
	/**
	 * 判断商户名称是否设置
	 * @return true 或 false
	 **/
	public function isSendNameSet()
	{
	    return array_key_exists('send_name', $this->values);
	}
	
	/**
	 * 设置用户openid
	 * @param string $value
	 **/
	public function setOpenID($value)
	{
		$this->values['re_openid'] = $value;
		return $this;
	}

	/**
	 * 获取用户openid
	 * @return 值
	 **/
	public function getOpenID()
	{
		return $this->values['re_openid'];
	}

	/**
	 * 判断openid是否设置
	 * @return true 或 false
	 **/
	public function isOpenIDSet()
	{
		return array_key_exists('re_openid', $this->values);
	}

	/**
	 * 设置随机字符串，不长于32位。推荐随机数生成算法
	 * @param string $value
	 **/
	public function setNonceStr($value)
	{
		$this->values['nonce_str'] = $value;
		return $this;
	}

	/**
	 * 获取随机字符串，不长于32位。推荐随机数生成算法的值
	 * @return 值
	 **/
	public function getNonceStr()
	{
		return $this->values['nonce_str'];
	}

	/**
	 * 判断随机字符串，不长于32位。推荐随机数生成算法是否存在
	 * @return true 或 false
	 **/
	public function isNonceStrSet()
	{
		return array_key_exists('nonce_str', $this->values);
	}

	/**
	 * 设置付款金额 只能发放1.00块到200块钱的红包
	 * @param string $value
	 **/
	public function setTotalAmount($value)
	{
		$this->values['total_amount'] = $value;
		return $this;
	}

	/**
	 * 获取付款金额
	 * @return 值
	 **/
	public function getTotalAmount()
	{
		return $this->values['total_amount'];
	}

	/**
	 * 判断付款金额是否设置
	 * @return true 或 false
	 **/
	public function isTotalAmountSet()
	{
		return array_key_exists('total_amount', $this->values);
	}

	/**
	 * 设置红包发放总人数
	 * @param string $value
	 **/
	public function setTotalNum($value)
	{
		$this->values['total_num'] = $value;
		return $this;
	}

	/**
	 * 获取红包发放总人数
	 * @return 值
	 **/
	public function getTotalNum()
	{
		return $this->values['total_num'];
	}

	/**
	 * 判断红包发放总人数是否设置
	 * @return true 或 false
	 **/
	public function isTotalNumSet()
	{
		return array_key_exists('total_num', $this->values);
	}

	/**
	 * 设置红包祝福语
	 * @param string $value
	 **/
	public function setWishing($value)
	{
		$this->values['wishing'] = $value;
		return $this;
	}

	/**
	 * 获取红包祝福语
	 * @return 值
	 **/
	public function getWishing()
	{
		return $this->values['wishing'];
	}

	/**
	 * 判断红包祝福语是否存在
	 * @return true 或 false
	 **/
	public function isWishingSet()
	{
		return array_key_exists('wishing', $this->values);
	}

	/**
	 * 设置商户订单号
	 * 商户订单号（每个订单号必须唯一）
     * 组成：mch_id+yyyymmdd+10位一天内不能重复的数字。 
	 * @param string $value
	 **/
	public function setMchBillNo($value)
	{
		$this->values['mch_billno'] = $value;
		return $this;
	}

	/**
	 * 获取商户订单号
	 * @return 值
	 **/
	public function getMchBillNo()
	{
		return $this->values['mch_billno'];
	}

	/**
	 * 判断商户订单号是否存在
	 * @return true 或 false
	 **/
	public function isMchBillNoSet()
	{
		return array_key_exists('mch_billno', $this->values);
	}

	/**
	 * 设置Ip地址
	 * @param string $value
	 **/
	public function setClientIp($value)
	{
		$this->values['client_ip'] = $value;
		return $this;
	}

	/**
	 * 获取Ip地址
	 * @return 值
	 **/
	public function getClientIp()
	{
		return $this->values['client_ip'];
	}

	/**
	 * 判断Ip地址是否存在
	 * @return true 或 false
	 **/
	public function isClientIpSet()
	{
		return array_key_exists('client_ip', $this->values);
	}

	/**
	 * 设置活动名称
	 * @param string $value
	 **/
	public function setActName($value)
	{
		$this->values['act_name'] = $value;
		return $this;
	}

	/**
	 * 获取活动名称
	 * @return 值
	 **/
	public function getActName()
	{
		return $this->values['act_name'];
	}

	/**
	 * 判断活动名称是否存在
	 * @return true 或 false
	 **/
	public function isActNameSet()
	{
		return array_key_exists('act_name', $this->values);
	}

	/**
	 * 设置活动备注(猜越多得越多，快来抢！)。
	 * @param string $value (256)
	 **/
	public function setRemark($value)
	{
		$this->values['remark'] = $value;
		return $this;
	}

	/**
	 * 获取活动备注
	 * @return 值
	 **/
	public function getRemark()
	{
		return $this->values['remark'];
	}

	/**
	 * 判断活动备注是否存在
	 * @return true 或 false
	 **/
	public function isRemarkSet()
	{
		return array_key_exists('remark', $this->values);
	}
}