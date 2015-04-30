<?php
class LocaleDomainsGoogleSitemapControllerExtension extends Extension {
	
	public function onBeforeInit() {
		Translatable::set_current_locale(LocaleDomains::getLocaleFromHost());
	}
	
	public function updateGoogleSitemapItems(ArrayList $items, $class, $page) {
		if($class == "SiteTree") {
			$items = $items->filter("Locale", LocaleDomains::getLocaleFromHost());
		}
	}
}