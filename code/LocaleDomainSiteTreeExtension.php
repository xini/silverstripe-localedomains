<?php

class LocaleDomainSiteTreeExtension extends SiteTreeExtension
{
    
    private static $ignored_url_segments = array(
        'Security',
        'dev',
        'admin'
    );
    
    public function addIgnoredURLSegment($urlSegment=null)
    {
        if (!in_array($urlSegment, self::$ignored_url_segments)) {
            $ignored_url_segments[] = $urlSegment;
        }
    }


    public function contentcontrollerInit()
    {
        if ($this->owner->hasExtension('Translatable')) {
            // get locale according to host
            $hostLoc = LocaleDomains::getLocaleFromHost();
            // get locale according to settings
            $currLoc = Translatable::get_current_locale();
            // check if locales differ
            if ($hostLoc != $currLoc && !in_array($this->owner->URLSegment, self::$ignored_url_segments)) {
                // check if homepage called. if so, set target locale to domain locale
                $targetLoc = $currLoc;
                if ($this->owner->URLSegment == RootURLController::get_homepage_link()) {
                    $targetLoc = $hostLoc;
                }
                // check if page has translation in target locale. if so, get translation
                $targetPage = $this->owner;
                if ($this->owner->hasTranslation($targetLoc)) {
                    $targetPage = $this->owner->getTranslation($targetLoc);
                }
                // redirect to target domain with target page
                if ($targetPage) {
                    Controller::curr()->redirect(Controller::join_links(Director::protocol().LocaleDomains::getHostFromLocale($targetLoc), $targetPage->RelativeLink()));
                }
            }
        }
    }
    
    public function alternateAbsoluteLink($action=null)
    {
        $link = Director::absoluteURL($this->owner->Link($action));
        if ($this->owner->hasExtension('Translatable')) {
            $targetLoc = $this->owner->Locale;
            $currLoc = Translatable::get_current_locale();
            if ($targetLoc != $currLoc) {
                $link = Controller::join_links(Director::protocol().LocaleDomains::getHostFromLocale($targetLoc), $this->owner->RelativeLink($action));
            }
        }
        return $link;
    }
    
    public function updateRelativeLink(&$base, &$action) 
    {
        if ($base == RootURLController::get_default_homepage_link()) {
            $base = '';
        }
    }

}
