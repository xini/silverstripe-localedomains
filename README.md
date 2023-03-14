# Local Domains

**This is an archived project and is no longer maintained. Please do not file issues or pull-requests against this repo. If you wish to continue to develop this code yourself, we recommend you fork it or contact us.**


## Introduction

Allows to setup a domain for each language configured and forces translated pages to the domain 
according to their locale.

## Requirements

 * SilverStripe ~3.0
 * Translatable ~1.0
 
## Usage

Add the following entries to your _config.php and configure them with your domains and locales:

```
LocaleDomains::addLocaleDomain('de_DE', 'www.germandomain.de');
LocaleDomains::addLocaleDomain('en_GB', 'www.englishdomain.com');
LocaleDomains::addLocaleDomain('fr_FR', 'www.frenchdomain.fr');
```

To get the customised links to the domain according to the locale of the target page, 
add the following code to your Page.php:

```
public function Link($action=null) {
	$link = parent::Link($action);
	if($this->hasExtension('Translatable') && $this->hasExtension("LocaleDomainDecorator")){
		// check base url and set localised domain if necessary
		$currHost = Director::protocolAndHost();
		$localeHost = Director::protocol().LocaleDomains::getHostFromLocale($this->Locale);
		if ($currHost != $localeHost) {
			$link = Controller::join_links($localeHost, $link);
		}
	}
	return $link;
}
```

