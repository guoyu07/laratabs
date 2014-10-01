<?php

$I = new AcceptanceTester($scenario);
$I->am('a programmer');
$I->wantTo('Generate tabs from the command line, and see the generated tabs');

$key = $I->chooseRandomKey();
$tabs = $I->generateRandomTabs();
$I->runShellCommand("cd ../../.. && php artisan tabs:generate {$key} --tabs='". implode(",",$tabs)."'");
$I->amOnPage("tabs/{$key}");
$I->see($tabs[0]);

$I->removeTheViews($key);




