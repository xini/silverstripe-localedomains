<?php

class LocaleDomains {
	
	private static $locale_domains = array();
	
	public static function addLocaleDomain($locale, $domain){
		self::$locale_domains[$locale] = $domain;
	}
	
	public static function getLocaleFromHost($host = null){
		if (!$host) {
			$host = $_SERVER["HTTP_HOST"];
		}
		$keys = array_keys(self::$locale_domains, $host);
		if ($keys && isset($keys[0])) {
			$locale = $keys[0];
		} else if (DataObject::has_extension('SiteTree', 'Translatable')) {
			$locale = Translatable::get_current_locale();
		} else {
			$locale = i18n::get_locale();
		}  
		return $locale;
	}

	public static function getHostFromLocale($locale = null){
		if (!$locale) {
			$locale = i18n::get_locale();
		}
		if (isset(self::$locale_domains[$locale])) {
			$host = self::$locale_domains[$locale];
		} else {
			$host = $_SERVER["HTTP_HOST"];
		}
		return $host;
	}
}