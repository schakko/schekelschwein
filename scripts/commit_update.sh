#!/bin/bash
# Push Schekelschwein information to the central hub

SCRIPT_DIR=$(dirname $(readlink -f $0))

. $SCRIPT_DIR/commit_update.config

# create output
$SCRIPT_DIR/rig_information.sh > $TMP_FILE

# push information
curl -v -H "Secret-Key: $SECRET_KEY" -H "Mining-Rig: $MINING_RIG" --data-binary @$TMP_FILE $HTTP_ENDPOINT
