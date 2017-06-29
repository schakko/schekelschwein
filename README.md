# Schekelschwein - Mining rig information

Retrieve information about your mining rig.

## On your webserver
- `cp .config.php.tempate .config.php`
- configure values in `.config.php`
- make the "data" directory writable

## On your rig
- copy the *scripts/update_rig.sh* to your rig and modify the HTTP endpoint in it. The script has been written for Fedora 25.
- make it executable:

    chmod +x update_rig.sh

- Add a crontab entry like

    5   *   *   *   * /home/usr/update_rig.sh > /tmp/stat.txt; curl -v -X POST -H "Secret-Key: YOUR_SECRET_KEY" -H "Mining-Rig: YOUR_MINING_RIG.mining" --data-binary @/tmp/stat.txt http://YOUR_ENDPOINT/commit.php 

Please note that you have to POST the data in binary format (*--data-binary*) to preserve the line breaks
