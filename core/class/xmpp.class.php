<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

include_file('3rdparty', 'Xmpp/XmppAutoload', 'php','xmpp');

class xmpp extends eqLogic {

}

class xmppCmd extends cmd {
	/*     * *************************Attributs****************************** */

	/*     * ***********************Methode static*************************** */

	/*     * *********************Methode d'instance************************* */

	public function preSave() {
		$this->setType('action');
		$this->setSubType('message');
		if ($this->getConfiguration('recipient') == '') {
			throw new Exception(__('Le jid destinataire ne peut etre vide', __FILE__));
		}
		$bValid = true;
		foreach(explode(',', $this->getConfiguration('recipient')) AS $sJid){
			$bValid = ($bValid && filter_var(trim($sJid), FILTER_VALIDATE_EMAIL));
		}
		if ($bValid == false) {
			throw new Exception(__('Le jid destinataire n\'est pas valide', __FILE__));
		}
	}

	public function execute($_options = null) {
		$eqLogic = $this->getEqLogic();
		if ($_options === null) {
			throw new Exception(__('[XMPP] Les options de la fonction ne peuvent etre null', __FILE__));
		}

		if ($_options['message'] == '' && $_options['title'] == '') {
			throw new Exception(__('[XMPP] Le message et le sujet ne peuvent être vide', __FILE__));
			return false;
		}

		if ($_options['title'] == '') {
			$_options['title'] = __('[Jeedom] - Notification', __FILE__);
		}

		$options = new Fabiang\Xmpp\Options('tcp://'.$eqLogic->getConfiguration('xmpp::server').':'.$eqLogic->getConfiguration('xmpp::port'));
		$options
	    ->setUsername($eqLogic->getConfiguration('xmpp::fromjid'))
	    ->setPassword($eqLogic->getConfiguration('xmpp::password'));

		$xmpp = new Fabiang\Xmpp\Client($options);
		$xmpp->connect();

		foreach(explode(',', $this->getConfiguration('recipient')) AS $sJid){
			$message = new Fabiang\Xmpp\Protocol\Message();
			$message->setMessage($_options['message'])
			    ->setTo($sJid)
			$xmpp->send($message);
		}
		return $xmpp->disconnect();
	}

	/*     * **********************Getteur Setteur*************************** */
}
