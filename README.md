# miniredirect
TYPO3 Extension: Transform a URL to lowerCase and redirect to the new URL

## Installation
Install with ExtensionManager or with 
composer `composer require svenjuergens/miniredirect`

## Configuration
As an administrator, you can enable logging, go to "Settings" -> "Extension Configuration" and mark the checkbox "Use Logging".
Then you will find your own logfile under 
``typo3temp/var/log/typo3_miniredirect_xxx.log``

## Usage
Now you have a 301 redirect on urls like https://example.org/sTandOrt/Kürten -> https://example.org/standort/kuerten

