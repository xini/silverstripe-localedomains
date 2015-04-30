<?php

SiteTree::add_extension("LocaleDomainSiteTreeExtension");

if (class_exists("GoogleSitemapController")) {
	GoogleSitemapController::add_extension("LocaleDomainsGoogleSitemapControllerExtension");
}
