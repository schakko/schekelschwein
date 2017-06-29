# Schekelschwein - Mining rig information

Retrieve information about your mining rig.

## On your webserver
- `cp .config.php.tempate .config.php`
- configure values in `.config.php`
- make the "data" directory writable

## On your rig
- copy the *scripts/update_rig.sh* to your rig and modify the HTTP endpoint in it. The script has been written for Fedora 25.
- make it executable:
	
	chmod +x rig_information.sh
	chmod +x commit_update.sh

- copy the configuration file *scripts/commit_update.config.template* to *scripts/commit_update.config* and configure the entries
- Add a crontab entry to refresh the state every 5 minutes

	5   *   *   *   * /home/schekelschwein/commit_update.sh


## Trivia
Please note that you have to POST the data in binary format (*--data-binary*) to preserve the line breaks
