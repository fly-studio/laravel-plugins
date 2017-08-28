<?php
namespace Plugins\Wechat\App\Tools\Pay;

/**
 *
 * 获取查询接口
 *
 */
class Gethbinfo extends Base
{

	public function __construct($mch_billno)
	{
		$this->setMchBillNo($mch_billno);
	}

	/**
	 * 设置微信分配的公众账号ID
	 * @param string $value
	 **/
	public function setAppid($value)
	{
		$this->values['appid'] = $value;
		return $this;
	}

	/**
	 * 获取微信分配的公众账号ID的值
	 * @return 值
	 **/
	public function getAppid()
	{
		return $this->values['appid'];
	}

	/**
	 * 判断微信分配的公众账号ID是否存在
	 * @return true 或 false
	 **/
	public function isAppidSet()
	{
		return array_key_exists('appid', $this->values);
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
	 * 设置订单类型
	 * @param string $value
	 **/
	public function setBillType($value)
	{
		$this->values['bill_type'] = $value;
		return $this;
	}

	/**
	 * 获取订单类型
	 * @return 值
	 **/
	public function getBillType()
	{
		return $this->values['bill_type'];
	}

	/**
	 * 判断订单类型是否存在
	 * @return true 或 false
	 **/
	public function isBillTypeSet()
	{
		return array_key_exists('bill_type', $this->values);
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
}