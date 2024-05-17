#!/bin/bash

#Restore the public directory from the backup
#docker cp /var/backups/uploads <ANmKtT7U>:/0/EgorNerubatsky/alphamovers_gitlab/src/public/upload
#docker cp /var/backups/uploads <ANmKtT7U>:/var/www/src/public/upload
cp -r /var/backups/uploads /root/builds/ANmKtT7U/0/EgorNerubatsky/alphamovers_gitlab/src/public/uploads
