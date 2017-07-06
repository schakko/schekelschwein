#!/bin/bash
# Print aggregated output of this mining rig.
# Written for Fedora 25.

# Uptime
echo ">>>uptime"
echo `uptime`
echo "<<<uptime"

# Host
echo ">>>hostname"
echo `hostname`
echo "<<<hostname" 

# IP
echo ">>>ifconfig"
for device in `/usr/sbin/ifconfig | grep 'flags' | cut -d: -f1 | awk '{ print $1}'`; do
        echo `/usr/sbin/ifconfig $device | grep 'inet ' | cut -d: -f3 | awk '{ print $2}'`
done
echo "<<<ifconfig" 

# Graphic card(s)
echo ">>>nvidia"
data=`nvidia-smi`
echo "$data"
echo "<<<nvidia"

# Processes
echo ">>>processes" 
echo `ps aux | grep miner | grep -v "grep"`
echo "<<<processes" 

echo ">>>mining-logs" 

echo "<<<mining-logs"

for service in `systemctl list-units | grep "miner@" | cut -d: -f1 | awk '{ print $1 }'`; do
        echo ">>>mining-log:$service" 
        content=`journalctl -u $service -n 20`
        echo "$content"
        echo "<<<mining-log:$service"
done

