<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_digiseller
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.helper');

/**
 * Digiseller Model
 *
 * @since  0.0.1
 */
class DigisellerModelDigiseller extends JModelItem
{
	/**
	 * Get the message
	 *
	 * @return  string
	 */
	public function getMsg()
	{
		$params = JComponentHelper::getParams('com_digiseller');

		$options = array(
			'sellerid' => $params->get('sellerid', ''),
			'logo' => $params->get('logo', 0),
			'search' => $params->get('search', 0),
			'cart' => $params->get('cart', 0),
			'purchases' => $params->get('purchases', 0),
			'lang' => $params->get('lang', 0),
			'cat' => $params->get('cat', 0),
			'menu' => $params->get('menu', 0),
		);

		//echo '<pre>';print_r($options);die;

		if (empty($options['sellerid'])) return '<a href="/administrator/index.php?option=com_config&view=component&component=com_digiseller">SellerID</a> is required.';

		return $this->digiseller_generator($options);
	}


	private function digiseller_generator($options) {

		$o = array(
			'sellerid' => $options['sellerid'] ? 1 : 0,
			'logo' => $options['logo'] ? 1 : 0,
			'search' => $options['search'] ? 1 : 0,
			'cart' => $options['cart'] ? 1 : 0,
			'purchases' => $options['purchases'] ? 1 : 0,
			'lang' => $options['lang'] ? 1 : 0,
			'cat' => in_array($options['cat'], array('h', 'v')) ? $options['cat'] : '0',
			'menu' => $options['menu'] ? 1 : 0,
		);

		ob_start();
		?>

		<script>!function(e){var l=function(l){return e.cookie.match(new RegExp("(?:^|; )digiseller-"+l+"=([^;]*)"))},i=l("lang"),s=l("cart_uid"),t=i?"&lang="+i[1]:"",d=s?"&cart_uid="+s[1]:"",r=e.getElementsByTagName("head")[0]||e.documentElement,n=e.createElement("link"),a=e.createElement("script");n.type="text/css",n.rel="stylesheet",n.id="digiseller-css",n.href="//shop.digiseller.ru/xml/store_css.asp?seller_id=<?php echo $options['sellerid']; ?>",a.async=!0,a.id="digiseller-js",a.src="//www.digiseller.ru/store/digiseller-api.js.asp?seller_id=<?php echo $options['sellerid']; ?>"+t+d,!e.getElementById(n.id)&&r.appendChild(n),!e.getElementById(a.id)&&r.appendChild(a)}(document);</script>

		<span class="digiseller-body" id="digiseller-body" 
			data-logo="<?php echo $o['logo']; ?>" 
			data-search="<?php echo $o['search']; ?>"
			data-cart="<?php echo $o['cart']; ?>" 
			data-purchases="<?php echo $o['purchases']; ?>" 
			data-langs="<?php echo $o['lang']; ?>" 
			data-cat="<?php echo $o['cat']; ?>" 
			data-downmenu="<?php echo $o['menu']; ?>"></span>

		<?php
		$r = ob_get_contents();
		ob_end_clean();
		return $r;
	}

}
