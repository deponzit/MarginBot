This is a PHP based Margin Lending Management Bot for the Bitfinex [API](https://bitfinex.com/pages/api).

## Details
This bot is designed to manage 1 or more bitfinex accounts, doing its best to keep any money in the "depost" wallet lent out at the highest rate possible while avoiding long periods of pending loans (as often happens when using the Flash Return Rate, or some other arbitrary rate).  There are numerous options and setting to tailor the bot to your requirements.

### Install

[Download the most current version](https://github.com/Deponzit/MarginBot/archive/master.zip), unzip to a folder on your server, then browse to that folder.  An install script will run you through the rest of the process.

### Update from an older Version

**Important**  - The Deponzit fork is not compatible with older versions of this bot. You will need to reinstall for it to work!

## Requirements

A live webserver running
* PHP 5.1+
* MySQL
* Access to add a cronjob
* A Bitfinex Account with API Access [(Set Up Here)](https://www.bitfinex.com/account/api)
* At least $50 in your Bitfinex "Deposit" wallet.  Preferably $100 or more. ( *Note: This is a bitfinex requirement, not a bot requirement.  Bitfinex doesn't allow Margin Loans of less than $50.* ) 

If you don't have a bitfinex account, please consider using HFenter's (the original MarginBot creator's) [affiliate code](https://www.bitfinex.com/?refcode=vsAnxuo5bM) when signing up.  By doing so, you'll save 10% on all fees for the first month.

[https://www.bitfinex.com/?refcode=vsAnxuo5bM](https://www.bitfinex.com/?refcode=vsAnxuo5bM).

## Donations
Developing this software, and testing the various strategies for lending that led to its development have taken significant time and effort.  If you find this software useful, please send a small donation our way.  All donations support the continued development of this software, and help to cover my distribution and support costs.

You can send donations to:

Deponzit (This fork's author): 1rq1YCXFemXAWyfUHpZo8fYinWor9eVst
HFenter (original author): 1A3y1xDXtyZySmPZySbpz7PPog4Vsyqig1
