<?php
/*//////////////////////////////
  10 Minute Cron Job                
  Should be run every 10 minutes (you can also run every 5 mins if your webhost is sometimes failing to execute every 10)    
  Ex:                         
  01,11,21,31,41,51 * * * * wget -qO- http://yoursite.com/MarginBot/TenMinuteCron.php >/dev/null 2>&1
////////////////////////////////*/
//error_reporting(E_ERROR);
// file configs //
require_once("../inc/config.php");

// db connectors and functions //
require_once("../inc/database.php");
$db = new Database();

// account functions //
require_once("../inc/Accounts.php");

require_once('../inc/ExchangeAPIs/bitfinex.php');

// * Get All Active BFX Accounts     * //
// * Create Account Objects for them * //

// check that the crons database exists //
$cronsTableSQL = '
    CREATE TABLE IF NOT EXISTS `'.$config['db']['prefix'].'CronRuns` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `cron_id` tinyint(1) NOT NULL,
      `lastrun` datetime NOT NULL,
      `details` varchar(256) NOT NULL,
      PRIMARY KEY (`id`)
    )';
$rt = $db->iquery($cronsTableSQL);

$cronIds = array();
$userIds = $db->query("SELECT id from `".$config['db']['prefix']."Users` WHERE status >= '1' AND ( status != '2' AND  status != '8' )  ORDER BY id ASC");
foreach($userIds as $uid){
    // assume each user needs to run the cronjob
    $cronIds[$uid['id']] = true;
}

$cronSql = $db->query("SELECT DISTINCT details, MAX(lastrun) last from `".$config['db']['prefix']."CronRuns` where cron_id = 2 group by details order by lastrun desc");
if (count($cronSql) >=  1) {
    foreach($cronSql as $row){
        // extract user ID (should be its own column, but meh...)
        $user = filter_var($row['details'], FILTER_SANITIZE_NUMBER_INT);
        if(!isset($cronIds[$user])){
            // skip this user, not in allowed ID list
            continue;
        }
        $age = floor((time()-strtotime($row['last'])));
        if($age < 480){
            // less than 8 minutes has passed, no need to run again (enables us to use 5 min crons)
            $cronIds[$user] = false;
        }
    }
}

foreach($cronIds as $id => $doCron){
    if(!$doCron){
        echo sprintf('--No need to run cron for user #%d<br>', $id);
        continue;
    }
    $account = new Accounts($id);
    $account->bfx->bitfinex_updateMyLends();
    // mark it in the crons table so we know its working
    $cronUpdates = $db->iquery("INSERT into `".$config['db']['prefix']."CronRuns` (`cron_id`, `lastrun`, `details`) VALUES ('2', NOW(), 'Updated User ".$id." Current Loans')");

}

