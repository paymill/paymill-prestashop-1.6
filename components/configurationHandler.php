<?php
/**
 * 2012-2014 PAYMILL
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 *  @author    PAYMILL <support@paymill.com>
 *  @copyright 2012-2014 PAYMILL
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

require_once 'models/configurationModel.php';

/**
 * configurationHandler
 *
 * @category   PayIntelligent
 * @copyright  Copyright (c) 2011 PayIntelligent GmbH (http://payintelligent.de)
 */
class ConfigurationHandler
{

	/**
	 * Loads the configuration from the Database
	 * @return ConfigurationModel
	 */
	public function loadConfiguration()
	{
		$config_model = new ConfigurationModel();
		$config = Configuration::getMultiple(
				array(
					'PIGMBH_PAYMILL_PUBLICKEY',
					'PIGMBH_PAYMILL_PRIVATEKEY',
					'PIGMBH_PAYMILL_DEBIT_DAYS',
					'PIGMBH_PAYMILL_DEBUG',
					'PIGMBH_PAYMILL_LOGGING',
					'PIGMBH_PAYMILL_DEBIT',
					'PIGMBH_PAYMILL_CREDITCARD',
					'PIGMBH_PAYMILL_FASTCHECKOUT',
					'PIGMBH_PAYMILL_ACCEPTED_BRANDS',
					'PIGMBH_PAYMILL_CAPTURE',
					'PIGMBH_PAYMILL_MODE',
					'PIGMBH_PAYMILL_PCI',
				)
		);

		$config_model->setPublicKey(isset($config['PIGMBH_PAYMILL_PUBLICKEY']) ? $config['PIGMBH_PAYMILL_PUBLICKEY'] : '');
		$config_model->setPrivateKey(isset($config['PIGMBH_PAYMILL_PRIVATEKEY']) ? $config['PIGMBH_PAYMILL_PRIVATEKEY'] : '');
		$config_model->setDebitDays(isset($config['PIGMBH_PAYMILL_DEBIT_DAYS']) ? $config['PIGMBH_PAYMILL_DEBIT_DAYS'] : '');
		$config_model->setDebug(isset($config['PIGMBH_PAYMILL_DEBUG']) ? $config['PIGMBH_PAYMILL_DEBUG'] : false);
		$config_model->setLogging(isset($config['PIGMBH_PAYMILL_LOGGING']) ? $config['PIGMBH_PAYMILL_LOGGING'] : false);
		$config_model->setDirectdebit(isset($config['PIGMBH_PAYMILL_DEBIT']) ? $config['PIGMBH_PAYMILL_DEBIT'] : false);
		$config_model->setCreditcard(isset($config['PIGMBH_PAYMILL_CREDITCARD']) ? $config['PIGMBH_PAYMILL_CREDITCARD'] : false);
		$config_model->setFastcheckout(isset($config['PIGMBH_PAYMILL_FASTCHECKOUT']) ? $config['PIGMBH_PAYMILL_FASTCHECKOUT'] : false);
		$config_model->setCapture(isset($config['PIGMBH_PAYMILL_CAPTURE']) ? $config['PIGMBH_PAYMILL_CAPTURE'] : false);
		$config_model->setPci(isset($config['PIGMBH_PAYMILL_PCI']) ? $config['PIGMBH_PAYMILL_PCI'] : 0);
		$accepted_brands = false;
		if (isset($config['PIGMBH_PAYMILL_ACCEPTED_BRANDS']))
			$accepted_brands = Tools::jsonDecode($config['PIGMBH_PAYMILL_ACCEPTED_BRANDS'], true);
		$config_model->setAccpetedCreditCards($accepted_brands);
		return $config_model;
	}

	/**
	 * Updates the Config and writes changes into db
	 * @param ConfigurationModel $model
	 */
	public function updateConfiguration(ConfigurationModel $model)
	{
		Configuration::updateValue('PIGMBH_PAYMILL_DEBIT', $model->getDirectdebit());
		Configuration::updateValue('PIGMBH_PAYMILL_CREDITCARD', $model->getCreditcard());
		Configuration::updateValue('PIGMBH_PAYMILL_PUBLICKEY', $model->getPublicKey());
		Configuration::updateValue('PIGMBH_PAYMILL_PRIVATEKEY', $model->getPrivateKey());
		Configuration::updateValue('PIGMBH_PAYMILL_DEBIT_DAYS', $model->getDebitDays());
		Configuration::updateValue('PIGMBH_PAYMILL_DEBUG', $model->getDebug());
		Configuration::updateValue('PIGMBH_PAYMILL_LOGGING', $model->getLogging());
		Configuration::updateValue('PIGMBH_PAYMILL_FASTCHECKOUT', $model->getFastcheckout());
		Configuration::updateValue('PIGMBH_PAYMILL_CAPTURE', $model->getCapture());
		Configuration::updateValue('PIGMBH_PAYMILL_ACCEPTED_BRANDS', Tools::jsonEncode($model->getAccpetedCreditCards()));
                Configuration::updateValue('PIGMBH_PAYMILL_PCI', $model->getPci());
	}

	/**
	 * Initiate the Pluginconfiguration
	 */
	public function setDefaultConfiguration()
	{
		Configuration::updateValue('PIGMBH_PAYMILL_DEBIT', 'OFF');
		Configuration::updateValue('PIGMBH_PAYMILL_CREDITCARD', 'OFF');
		Configuration::updateValue('PIGMBH_PAYMILL_PUBLICKEY', '');
		Configuration::updateValue('PIGMBH_PAYMILL_PRIVATEKEY', '');
		Configuration::updateValue('PIGMBH_PAYMILL_DEBIT_DAYS', '7');
		Configuration::updateValue('PIGMBH_PAYMILL_DEBUG', 'OFF');
		Configuration::updateValue('PIGMBH_PAYMILL_LOGGING', 'ON');
		Configuration::updateValue('PIGMBH_PAYMILL_FASTCHECKOUT', 'OFF');
		Configuration::updateValue('PIGMBH_PAYMILL_CAPTURE', 'OFF');
		Configuration::updateValue(
			'PIGMBH_PAYMILL_ACCEPTED_BRANDS', Tools::jsonEncode(
				array(
					'visa' => false,
					'mastercard' => false,
					'amex' => false,
					'carta-si' => false,
					'carte-bleue' => false,
					'diners-club' => false,
					'jcb' => false,
					'maestro' => false,
					'china-unionpay' => false,
					'discover' => false,
					'dankort' => false
				)
			)
		);
		Configuration::updateValue('PIGMBH_PAYMILL_PCI', 0);

		return true; //needs to return true for installation
	}

}
